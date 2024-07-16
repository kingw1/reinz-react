<?php

namespace App\Repositories;

use App\Models\Area;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class AreaRepository
{
    public function find(int $id): Area
    {
        return Area::findOrFail($id);
    }

    public function findByName(string $name)
    {
        return Area::query()
            ->where('name_en', $name)
            ->orWhere('name_kh', $name)
            ->first();
    }

    public function selectAreas($lang = ''): array
    {
        $field = empty($lang) ? 'name' : 'name_' . $lang;

        return Area::get()->pluck($field, 'id')->toArray();
    }

    public function getAll(array $filters, $limit = null): Collection
    {
        $query = Area::query()
            ->when($filters['count_project'] ?? null, function ($query) {
                return $query->withCount('projects');
            })
            ->latest();

        if ($limit) {
            $query->take($limit);
        }

        return $query->get();
    }

    public function getPropertyCountByProjectArea($type = 'buy')
    {
        return Area::query()
            ->with([
                'projects' => function ($sub_query) use ($type) {
                    $sub_query
                        ->select('id', 'area_id')
                        ->withCount([
                            'properties' => function ($q) use ($type) {
                                $q->where('type', $type)->published();
                            }
                        ]);
                }
            ])
            ->get()
            ->map(fn ($data) => [
                'areaName' => $data->name,
                'areaClassName' => $data->class_name,
                'areaSlug' => $data->slug,
                'propertiesCount' => $data->projects->sum('properties_count')
            ]);
    }

    public function paginate(array $filters = [], $perPage = 10): LengthAwarePaginator
    {
        return Area::query()
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

    public function store(array $data): Area
    {
        $area = new Area;

        return $this->valuable($area, $data);
    }

    public function update(int $id, array $data): Area
    {
        $area = $this->find($id);

        return $this->valuable($area, $data);
    }

    public function valuable(Area $area, array $param = []): Area
    {
        $param = (object)$param;

        !isset($param->city_id) ?: $area->city_id = $param->city_id;
        !isset($param->name_en) ?: $area->name_en = $param->name_en;
        !isset($param->name_kh) ?: $area->name_kh = $param->name_kh;
        $area->slug = Str::slug($param->name_en);
        !isset($param->seo_image) ?: $area->seo_image = $param->seo_image;
        !isset($param->seo_title_buy_en) ?: $area->seo_title_buy_en = $param->seo_title_buy_en;
        !isset($param->seo_title_buy_kh) ?: $area->seo_title_buy_kh = $param->seo_title_buy_kh;
        !isset($param->seo_title_rent_en) ?: $area->seo_title_rent_en = $param->seo_title_rent_en;
        !isset($param->seo_title_rent_kh) ?: $area->seo_title_rent_kh = $param->seo_title_rent_kh;
        !isset($param->description_buy_en) ?: $area->description_buy_en = $param->description_buy_en;
        !isset($param->description_buy_kh) ?: $area->description_buy_kh = $param->description_buy_kh;
        !isset($param->description_rent_en) ?: $area->description_rent_en = $param->description_rent_en;
        !isset($param->description_rent_kh) ?: $area->description_rent_kh = $param->description_rent_kh;

        $area->save();

        return $area;
    }
}
