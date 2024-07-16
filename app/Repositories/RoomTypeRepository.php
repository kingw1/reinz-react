<?php

namespace App\Repositories;

use App\Models\RoomType;


class RoomTypeRepository
{
    public function find(int $id): RoomType
    {
        return RoomType::findOrFail($id);
    }
}
