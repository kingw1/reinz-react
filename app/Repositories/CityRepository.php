<?php

namespace App\Repositories;

use App\Models\City;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CityRepository
{
    public function find(int $id): City
    {
        return City::findOrFail($id);
    }

    public function selectCities($lang = ''): array
    {
        $field = empty($lang) ? 'name' : 'name_' . $lang;

        return City::select('id', DB::raw("$field as label"))->get()->toArray();
    }

    public function getDefaultCity(): City
    {
        return City::first();
    }

    public function getAll(): Collection
    {
        return City::all();
    }

    public function paginate(array $filters = [], $perPage = 10): LengthAwarePaginator
    {
        return City::query()
            ->when($filters['search'], function ($query, $value) {
                return $query->where('name_en', 'like', "%{$value}%")
                    ->orWhere('name_kh', 'like', "%{$value}%");
            })
            ->latest()
            ->paginate($perPage);
    }

    public function store(array $data): City
    {
        $city = new City;

        return $this->valuable($city, $data);
    }

    public function update(int $id, array $data): City
    {
        $city = $this->find($id);

        return $this->valuable($city, $data);
    }

    public function valuable(City $city, array $param = []): City
    {
        $param = (object) $param;

        !isset($param->name_en) ?: $city->name_en = $param->name_en;
        !isset($param->name_kh) ?: $city->name_kh = $param->name_kh;

        $city->save();

        return $city;
    }
}
