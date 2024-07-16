<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name_en' => $this->name_en,
            'name_kh' => $this->name_kh,
            'address_en' => $this->address_en,
            'address_kh' => $this->address_kh,
            'description_en' => $this->description_en,
            'description_kh' => $this->description_kh,
            'project_type' => $this->projectType->name_en ?? '',
            'city' => $this->city->name_en ?? '',
            'district' => $this->district->name_en ?? '',
            'area' => $this->area->name_en ?? '',
            'developer' => $this->developer->name_en ?? '',
            'is_pet_friendly' => $this->is_pet_friendly,
            'is_shop' => $this->is_shop,
            'general_images' => $this->general_images,
            'floor_plan_images' => $this->floor_plan_images,
            'unit_plan_images' => $this->unit_plan_images,
            'video' => $this->video,
            'google_map' => $this->google_map,
            'street_view' => $this->street_view,
            'amenities' => $this->amenities,
            'surroundings' => $this->surroundings,
            'room_types' => $this->room_types,
            'room_sizes' => $this->room_sizes,
            'common_fee' => $this->common_fee,
            'parking_fee' => $this->parking_fee,
            'year_of_building' => $this->year_of_building,
            'total_unit' => $this->total_unit,
            'total_floor' => $this->total_floor,
            'status' => $this->status,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
