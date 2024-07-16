<?php

namespace App\Repositories;

use App\Models\SeoSetting;

class SEORepository
{
    public function findKey(string $key)
    {
       $value = SeoSetting::query()
        ->where('key', $key)
        ->first();

        return $value->value ?? '';
    }
}
