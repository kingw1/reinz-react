<?php

namespace App\Repositories;

use App\Enums\StatusEnum;
use App\Models\Project;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ProjectRepository
{
    public function find(int $id): Project
    {
        return Project::findOrFail($id);
    }

    public function selectProjects($lang = ''): array
    {
        return (new Project())->selectProjects($lang);
    }

    public function getAll(array $filters = [], $limit = null): Collection
    {
        $query = Project::query()
            ->with([
                'projectType',
                'developer',
                'area',
                'district',
                'properties'
            ])
            ->when($filters['search'] ?? null, function ($query, $value) {
                return $query->where('name_en', 'like', "%{$value}%")
                    ->orWhere('name_kh', 'like', "%{$value}%");
            })
            ->when($filters['project_type_id'] ?? null, function ($query, $value) {
                return $query->where('project_type_id', $value);
            })
            ->when($filters['city_id'] ?? null, function ($query, $value) {
                return $query->where('city_id', $value);
            })
            ->when($filters['district_id'] ?? null, function ($query, $value) {
                return $query->where('district_id', $value);
            })
            ->when($filters['area_id'] ?? null, function ($query, $value) {
                return $query->where('area_id', $value);
            })
            ->when($filters['developer_id'] ?? null, function ($query, $value) {
                return $query->where('developer_id', $value);
            })
            ->when($filters['count_property_sale'] ?? null, function ($query) {
                return $query->withCount(['properties AS count_property_sale' => fn (Builder $query) => $query->where('type', 'buy')]);
            })
            ->when($filters['count_property_rent'] ?? null, function ($query) {
                return $query->withCount(['properties AS count_property_rent' => fn (Builder $query) => $query->where('type', 'rent')]);
            })
            ->when($filters['avg_property_sale'] ?? null, function ($query) {
                return $query->withAvg(['properties AS avg_property_sale' => fn (Builder $query) => $query->where('type', 'buy')], 'room_price');
            })
            ->when($filters['avg_property_rent'] ?? null, function ($query) {
                return $query->withAvg(['properties AS avg_property_rent' => fn (Builder $query) => $query->where('type', 'rent')], 'room_price');
            })
            ->when($filters['min_property_sale'] ?? null, function ($query) {
                return $query->withMin(['properties AS min_property_sale' => fn (Builder $query) => $query->where('type', 'buy')], 'room_price');
            })
            ->when($filters['min_property_rent'] ?? null, function ($query) {
                return $query->withMin(['properties AS min_property_rent' => fn (Builder $query) => $query->where('type', 'rent')], 'room_price');
            })
            ->latest();

        if ($limit) {
            $query->take($limit);
        }

        return $query->published()->get();
    }

    public function paginate(array $filters = [], $perPage = 10): LengthAwarePaginator
    {
        return Project::query()
            ->with(['projectType', 'developer', 'area', 'district'])
            ->when($filters['search'] ?? null, function ($query, $value) {
                return $query->where('name_en', 'like', "%{$value}%")
                    ->orWhere('name_kh', 'like', "%{$value}%");
            })
            ->when($filters['project_type_id'] ?? null, function ($query, $value) {
                return $query->where('project_type_id', $value);
            })
            ->when($filters['city_id'] ?? null, function ($query, $value) {
                return $query->where('city_id', $value);
            })
            ->when($filters['district_id'] ?? null, function ($query, $value) {
                return $query->where('district_id', $value);
            })
            ->when($filters['area_id'] ?? null, function ($query, $value) {
                return $query->where('area_id', $value);
            })
            ->when($filters['developer_id'] ?? null, function ($query, $value) {
                return $query->where('developer_id', $value);
            })
            ->latest()
            ->paginate($perPage);
    }

    public function store(array $data): Project
    {
        $project = new Project;

        return $this->valuable($project, $data);
    }

    public function update(int $id, array $data): Project
    {
        $project = $this->find($id);

        return $this->valuable($project, $data);
    }

    public function valuable(Project $project, array $param = []): Project
    {
        $param = (object)$param;

        !isset($param->name_en) ?: $project->name_en = $param->name_en;
        !isset($param->name_kh) ?: $project->name_kh = $param->name_kh;
        !isset($param->address_en) ?: $project->address_en = $param->address_en;
        !isset($param->address_kh) ?: $project->address_kh = $param->address_kh;
        !isset($param->description_en) ?: $project->description_en = $param->description_en;
        !isset($param->description_kh) ?: $project->description_kh = $param->description_kh;
        !isset($param->project_type_id) ?: $project->project_type_id = $param->project_type_id;
        !isset($param->city_id) ?: $project->city_id = $param->city_id;
        !isset($param->district_id) ?: $project->district_id = $param->district_id;
        !isset($param->area_id) ?: $project->area_id = $param->area_id;
        !isset($param->developer_id) ?: $project->developer_id = $param->developer_id;
        !isset($param->is_pet_friendly) ?: $project->is_pet_friendly = $param->is_pet_friendly;
        !isset($param->is_shop) ?: $project->is_shop = $param->is_shop;
        !isset($param->general_images) ?: $project->general_images = $param->general_images;
        !isset($param->floor_plan_images) ?: $project->floor_plan_images = $param->floor_plan_images;
        !isset($param->unit_plan_images) ?: $project->unit_plan_images = $param->unit_plan_images;
        !isset($param->video) ?: $project->video = $param->video;
        !isset($param->google_map) ?: $project->google_map = $param->google_map;
        !isset($param->street_view) ?: $project->street_view = $param->street_view;
        !isset($param->amenities) ?: $project->amenities = $param->amenities;
        !isset($param->surroundings) ?: $project->surroundings = $param->surroundings;
        !isset($param->room_types) ?: $project->room_types = $param->room_types;
        !isset($param->room_sizes) ?: $project->room_sizes = $param->room_sizes;
        !isset($param->common_fee) ?: $project->common_fee = $param->common_fee;
        !isset($param->parking_fee) ?: $project->parking_fee = $param->parking_fee;
        !isset($param->year_of_building) ?: $project->year_of_building = $param->year_of_building;
        !isset($param->total_unit) ?: $project->total_unit = $param->total_unit;
        !isset($param->total_floor) ?: $project->total_floor = $param->total_floor;
        !isset($param->status) ?: $project->status = $param->status;

        $project->save();

        return $project;
    }
}
