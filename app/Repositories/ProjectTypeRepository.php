<?php

namespace App\Repositories;

use App\Models\ProjectType;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ProjectTypeRepository
{
    public function find(int $id): ProjectType
    {
        return ProjectType::findOrFail($id);
    }

    public function getAll(): Collection
    {
        return ProjectType::all();
    }

    public function paginate(array $filters = [], $perPage = 10): LengthAwarePaginator
    {
        return ProjectType::query()
            ->when($filters['search'], function ($query, $value) {
                return $query->where('name_en', 'like', "%{$value}%")
                    ->orWhere('name_kh', 'like', "%{$value}%");
            })
            ->latest()
            ->paginate($perPage);
    }

    public function update(int $id, array $data): ProjectType
    {
        $projectType = $this->find($id);

        return $this->valuable($projectType, $data);
    }

    public function valuable(ProjectType $projectType, array $param = []): ProjectType
    {
        $param = (object) $param;

        !isset($param->name_en) ?: $projectType->name_en = $param->name_en;
        !isset($param->name_kh) ?: $projectType->name_kh = $param->name_kh;
        !isset($param->seo_title_buy_en) ?: $projectType->seo_title_buy_en = $param->seo_title_buy_en;
        !isset($param->seo_title_buy_kh) ?: $projectType->seo_title_buy_kh = $param->seo_title_buy_kh;
        !isset($param->seo_title_rent_en) ?: $projectType->seo_title_rent_en = $param->seo_title_rent_en;
        !isset($param->seo_title_rent_kh) ?: $projectType->seo_title_rent_kh = $param->seo_title_rent_kh;
        !isset($param->seo_image) ?: $projectType->seo_image = $param->seo_image;
        !isset($param->description_buy_en) ?: $projectType->description_buy_en = $param->description_buy_en;
        !isset($param->description_buy_kh) ?: $projectType->description_buy_kh = $param->description_buy_kh;
        !isset($param->description_rent_en) ?: $projectType->description_rent_en = $param->description_rent_en;
        !isset($param->description_rent_kh) ?: $projectType->description_rent_kh = $param->description_rent_kh;

        $projectType->save();

        return $projectType;
    }
}
