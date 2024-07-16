<?php

namespace App\Repositories;

use App\Models\Developer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class DeveloperRepository
{
    public function find(int $id): Developer
    {
        return Developer::findOrFail($id);
    }

    public function selectDevelopers(): array
    {
        return Developer::get()->pluck('name', 'id')->toArray();
    }

    public function getAll(): Collection
    {
        return Developer::all();
    }

    public function paginate(array $filters = [], $perPage = 10): LengthAwarePaginator
    {
        return Developer::query()
            ->when($filters['search'], function ($query, $value) {
                return $query->where('name_en', 'like', "%{$value}%")
                    ->orWhere('name_kh', 'like', "%{$value}%");
            })
            ->latest()
            ->paginate($perPage);
    }

    public function store(array $data): Developer
    {
        $agent = new Developer;

        return $this->valuable($agent, $data);
    }

    public function update(int $id, array $data): Developer
    {
        $agent = $this->find($id);

        return $this->valuable($agent, $data);
    }

    public function valuable(Developer $agent, array $param = []): Developer
    {
        $param = (object) $param;

        !isset($param->name_en) ?: $agent->name_en = $param->name_en;
        !isset($param->name_kh) ?: $agent->name_kh = $param->name_kh;
        !isset($param->logo) ?: $agent->logo = $param->logo;
        !isset($param->website) ?: $agent->website = $param->website;
        !isset($param->description_en) ?: $agent->description_en = $param->description_en;
        !isset($param->description_kh) ?: $agent->description_kh = $param->description_kh;

        $agent->save();

        return $agent;
    }
}
