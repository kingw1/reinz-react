<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surrounding extends Model
{
    use HasFactory;

    protected function name(): Attribute
    {
        return Attribute::make(fn (mixed $value, array $attributes) => $attributes['name_en'] . ' | ' . $attributes['name_kh']);
    }

    public function selectSurroundings($lang = ''): array
    {
        $field = empty($lang) ? 'name' : 'name_' . $lang;

        return self::get()->pluck($field, 'id')->toArray();
    }
}
