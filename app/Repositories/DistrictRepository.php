<?php

namespace App\Repositories;

use App\Models\District;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class DistrictRepository
{
    public function find(int $id): District
    {
        return District::findOrFail($id);
    }

    public function selectDistricts($lang = ''): array
    {
        $field = empty($lang) ? 'name' : 'name_' . $lang;

        return District::get()->pluck($field, 'id')->toArray();
    }

    public function getAll(): Collection
    {
        return District::all();
    }

    public function paginate(array $filters = [], $perPage = 10): LengthAwarePaginator
    {
        return District::query()
            ->with('city:id,name_en,name_kh')
            ->when($filters['search'], function ($query, $value) {
                return $query->where('name_en', 'like', "%{$value}%")
                    ->orWhere('name_kh', 'like', "%{$value}%");
            })
            ->when($filters['city_id'], function ($query, $value) {
                return $query->where('city_id', $value);
            })
            ->latest()
            ->paginate($perPage);
    }

    public function store(array $data): District
    {
        $district = new District;

        return $this->valuable($district, $data);
    }

    public function update(int $id, array $data): District
    {
        $district = $this->find($id);

        return $this->valuable($district, $data);
    }

    public function valuable(District $district, array $param = []): District
    {
        $param = (object) $param;

        !isset($param->city_id) ?: $district->city_id = $param->city_id;
        !isset($param->name_en) ?: $district->name_en = $param->name_en;
        !isset($param->name_kh) ?: $district->name_kh = $param->name_kh;

        $district->save();

        return $district;
    }
}
