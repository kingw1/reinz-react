<?php

namespace App\Repositories;

use App\Models\Furniture;


class FurnitureRepository
{
    public function getNameByWhereInId(array $id): array
    {
        return Furniture::query()->whereIn('id', $id)->pluck('name_' . app()->getLocale())->toArray();
    }
}
