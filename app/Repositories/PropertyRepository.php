<?php

namespace App\Repositories;

use App\Models\Property;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class PropertyRepository
{
    public function find(string $id): Property
    {
        return Property::findOrFail($id);
    }

    public function getQuery(array $filters = [], $limit = null)
    {
        $query = Property::query()
            ->published()
            ->with(['project', 'agent'])
            ->when($filters['search'] ?? null, function ($query, $value) {
                return $query->where('name_en', 'like', "%{$value}%")
                    ->orWhere('name_kh', 'like', "%{$value}%");
            })
            ->when($filters['agent_id'] ?? null, function ($query, $value) {
                return $query->where('agent_id', $value);
            })
            ->when($filters['project_id'] ?? null, function ($query, $value) {
                return $query->where('project_id', $value);
            })
            ->when($filters['type'] ?? null, function ($query, $value) {
                return $query->where('type', $value);
            })
            ->when($filters['type'] == 'buy', function ($query, $value) {
                return $query->whereHas('project', function ($query) use ($value) {
                    $query->where('project_type_id', 1);
                });
            })
            ->when($filters['project_type_id'] ?? null, function ($query, $value) {
                return $query->whereHas('project', function ($query) use ($value) {
                    $query->where('project_type_id', $value);
                });
            })
            ->when($filters['city_id'] ?? null, function ($query, $value) {
                return $query->whereHas('project', function ($query) use ($value) {
                    $query->where('city_id', $value);
                });
            })
            ->when($filters['area_id'] ?? null, function ($query, $value) {
                return $query->whereHas('project', function ($query) use ($value) {
                    $query->where('area_id', $value);
                });
            })
            ->when($filters['area_id'] ?? null, function ($query, $value) {
                return $query->whereHas('project', function ($query) use ($value) {
                    $query->where('area_id', $value);
                });
            })
            ->when($filters['developer_id'] ?? null, function ($query, $value) {
                return $query->whereHas('project', function ($query) use ($value) {
                    $query->where('developer_id', $value);
                });
            })
            ->when($filters['room_size'] ?? null, function ($query, $value) {
                if (is_array($value)) {
                    return $query->whereIn('room_type', $value);
                } else {
                    return $query->where('room_type', $value);
                }
            })
            ->when($filters['range_minprice'] ?? null, function ($query, $value) {
                return $query->where('room_price', '>=', $value);
            })
            ->when($filters['range_maxprice'] ?? null, function ($query, $value) {
                return $query->where('room_price', '<=', $value);
            })
            ->when($filters['range_minsize'] ?? null, function ($query, $value) {
                return $query->where('room_size', '>=', $value);
            })
            ->when($filters['range_maxsize'] ?? null, function ($query, $value) {
                return $query->where('room_size', '<=', $value);
            })
            ->when($filters['shop_in_the_building'] ?? null, function ($query, $value) {
                return $query->whereHas('project', function ($query) use ($value) {
                    $query->where('is_shop', $value);
                });
            })
            ->when($filters['pet_friendly'] ?? null, function ($query, $value) {
                return $query->where('is_pet_friendly', $value);
            })
            ->when($filters['short_term_contract'] ?? null, function ($query, $value) {
                return $query->where('rent_minimum_contract', '<1');
            })
            ->latest();

        if ($limit) {
            $query->take($limit);
        }

        return $query;
    }

    public function getAll($query)
    {
        return $query->get();
    }

    public function getPaginate($query, $perPage = 10, $page = 1, $pageName = 'page')
    {
        return $query->paginate($perPage, ['*'], $pageName, $page);
    }

    public function getCount($query)
    {
        return $query->count();
    }

    public function paginate(array $filters = [], $perPage = 10)
    {
        return Property::query()
            ->with(['project', 'agent'])
            ->when($filters['search'] ?? null, function ($query, $value) {
                return $query->where('name_en', 'like', "%{$value}%")
                    ->orWhere('name_kh', 'like', "%{$value}%");
            })
            ->when($filters['agent_id'] ?? null, function ($query, $value) {
                return $query->where('agent_id', $value);
            })
            ->when($filters['project_id'] ?? null, function ($query, $value) {
                return $query->where('project_id', $value);
            })
            ->when($filters['project_type_id'] ?? null, function ($query, $value) {
                return $query->whereHas('project', function ($query) use ($value) {
                    $query->where('project_type_id', $value);
                });
            })
            ->latest()
            ->paginate($perPage);
    }

    public function store(array $data): Property
    {
        $property = new Property;

        return $this->valuable($property, $data);
    }

    public function update(string $id, array $data): Property
    {
        $property = $this->find($id);

        return $this->valuable($property, $data);
    }

    public function valuable(Property $property, array $param = []): Property
    {
        $param = (object)$param;

        !isset($param->id) ?: $property->id = $param->id;
        !isset($param->name_en) ?: $property->name_en = $param->name_en;
        !isset($param->name_kh) ?: $property->name_kh = $param->name_kh;
        !isset($param->agent_id) ?: $property->agent_id = $param->agent_id;
        !isset($param->project_id) ?: $property->project_id = $param->project_id;
        !isset($param->is_co_agent_acceptance) ?: $property->is_co_agent_acceptance = $param->is_co_agent_acceptance;
        !isset($param->is_pet_friendly) ?: $property->is_pet_friendly = $param->is_pet_friendly;
        !isset($param->is_shop) ?: $property->is_shop = $param->is_shop;
        !isset($param->type) ?: $property->type = $param->type;
        !isset($param->video) ?: $property->video = $param->video;
        !isset($param->sale_contract_type) ?: $property->sale_contract_type = $param->sale_contract_type;
        !isset($param->rent_minimum_contract) ?: $property->rent_minimum_contract = $param->rent_minimum_contract;
        !isset($param->general_images) ?: $property->general_images = $param->general_images;
        !isset($param->floor_plan_images) ?: $property->floor_plan_images = $param->floor_plan_images;
        !isset($param->unit_plan_images) ?: $property->unit_plan_images = $param->unit_plan_images;
        !isset($param->description_en) ?: $property->description_en = $param->description_en;
        !isset($param->description_kh) ?: $property->description_kh = $param->description_kh;
        !isset($param->room_type) ?: $property->room_type = $param->room_type;
        !isset($param->room_price) ?: $property->room_price = $param->room_price;
        !isset($param->room_size) ?: $property->room_size = $param->room_size;
        !isset($param->total_bedroom) ?: $property->total_bedroom = $param->total_bedroom;
        !isset($param->total_bathroom) ?: $property->total_bathroom = $param->total_bathroom;
        !isset($param->total_toilet) ?: $property->total_toilet = $param->total_toilet;
        !isset($param->total_floor) ?: $property->total_floor = $param->total_floor;
        !isset($param->direction) ?: $property->direction = $param->direction;
        !isset($param->building_wing) ?: $property->building_wing = $param->building_wing;
        !isset($param->furnitures) ?: $property->furnitures = $param->furnitures;
        !isset($param->status) ?: $property->status = $param->status;

        $property->save();

        // update name en,kh
        $property->name_en = $this->generatePropertyNameEn($property);
        $property->name_kh = $this->generatePropertyNameKh($property);

        $property->save();

        return $property;
    }

    /**
     * Genrate property name from [Property type + project type + total_bedroom + district + city]
     *
     * @param Property $property
     * @param string $lang
     * @return string
     */
    public function generatePropertyName(Property $property, $lang = 'en'): string
    {
        $function = 'generatePropertyName' . Str::ucfirst($lang);

        return $this->$function($property);
    }

    private function generatePropertyNameEn(Property $property): string
    {
        // Format
        // {ProjectName} for {Rent/Buy} {Room Type} {Property Type} in {Area}

        $lang = 'en';
        $fieldName = 'name_' . $lang;

        $name = $property->project->$fieldName ?? '';
        $name .= ' ' . __('property.for', [], $lang);
        $name .= ' ' . __('property.property_types.' . $property->type, [], $lang);

        $bedroom = ' ' . $property->total_bedroom . ' ' . __('property.bed', [], $lang);
        $name .= $property->total_bedroom > 1 ? Str::plural($bedroom) : $bedroom;

        $projectTypeName = $property->project->projectType->$fieldName ?? null;
        if ($projectTypeName) {
            $name .= ' ' . $projectTypeName;
        }

        $name .= ' ' . __('property.in', [], $lang);

        $areaName = $property->project->area->$fieldName ?? null;
        if ($areaName) {
            $name .= ' ' . $areaName;
        }

        // $districtName = $property->project->district->$fieldName ?? null;
        // if ($districtName) {
        //     $name .= ' ' . $districtName;
        // }

        // $cityName = $property->project->city->$fieldName ?? null;
        // if ($cityName) {
        //     $name .= ', ' . $cityName;
        // }

        return $name;
    }

    private function generatePropertyNameKh(Property $property): string
    {
        // Format
        // {ProjectName} for {Rent/Buy} {Room Type} {Property Type} in {Area}
        $lang = 'kh';
        $fieldName = 'name_' . $lang;

        $name = $property->project->$fieldName ?? '';
        $name .= ' ' . __('property.for', [], $lang);
        $name .= ' ' . __('property.property_types.' . $property->type, [], $lang);
        $name .= ' ' . $property->total_bedroom . ' ' . __('property.bed', [], $lang);

        $projectTypeName = $property->project->projectType->$fieldName ?? null;
        if ($projectTypeName) {
            $name .= ' ' . $projectTypeName;
        }

        $name .= ' ' . __('property.in', [], $lang);

        $areaName = $property->project->area->$fieldName ?? null;
        if ($areaName) {
            $name .= ' ' . $areaName;
        }

        // $districtName = $property->project->district->$fieldName ?? null;
        // if ($districtName) {
        //     $name .= ' ' . $districtName;
        // }

        // $cityName = $property->project->city->$fieldName ?? null;
        // if ($cityName) {
        //     $name .= ' ' . $cityName;
        // }

        return $name;
    }

    public function getMinPrice(string $type)
    {
        $price = Property::query()->where('type', $type)->min('room_price');

        return $price;
    }

    public function getMaxPrice(string $type)
    {
        $price = Property::query()->where('type', $type)->max('room_price');

        return $price;
    }

    public function getAllFilter(array $filters = [])
    {
        $query = Property::query()
            ->with(['project'])
            ->when($filters['property_type'] ?? null, function ($query, $value) {
                return $query->where('type', $value);
            })
            ->when($filters['room_size'] ?? null, function ($query, $value) {
                return $query->whereIn('room_type', $value);
            })
            ->when($filters['range_minprice'] ?? null, function ($query, $value) {
                return $query->where('room_price', '>=', $value);
            })
            ->when($filters['range_maxprice'] ?? null, function ($query, $value) {
                return $query->where('room_price', '<=', $value);
            })
            ->when($filters['range_minsize'] ?? null, function ($query, $value) {
                return $query->where('room_size', '>=', $value);
            })
            ->when($filters['range_maxsize'] ?? null, function ($query, $value) {
                return $query->where('room_size', '<=', $value);
            })
            ->when($filters['short_term_contract'] ?? null, function ($query, $value) {
                return $query->where('rent_minimum_contract', '<1');
            })
            ->when($filters['pet_friendly'] ?? null, function ($query, $value) {
                return $query->where('is_pet_friendly', $value);
            })
            ->when($filters['area_id'] ?? null, function ($query, $value) {
                return $query->whereHas('project', function ($query) use ($value) {
                    $query->where('area_id', $value);
                });
            })
            ->when($filters['city_id'] ?? null, function ($query, $value) {
                return $query->whereHas('project', function ($query) use ($value) {
                    $query->where('city_id', $value);
                });
            });

        $query->orderBy('room_price', 'desc');

        return $query->paginate(10);
    }

    public function getAllBuyRent($projectIds = [], $type)
    {
        $properties = Property::query()
            ->published()
            ->when($type ?? null, function ($query, $value) {
                return $query->where('type', $value);
            })
            ->whereIn('project_id', $projectIds);

        return $properties;
    }
}
