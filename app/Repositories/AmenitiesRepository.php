<?php

namespace App\Repositories;

use App\Models\Amenity;

class AmenitiesRepository
{
    public function getAll()
    {
        return Amenity::query()->get();
    }
}
