<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    use HasFactory;

    protected string $local;

    public function __construct()
    {
        $this->local = app()->getLocale();
    }

    protected function name(): Attribute
    {
        return Attribute::make(fn (mixed $value, array $attributes) => $attributes['name_'.$this->local]);
    }

    public function selectRoomTypes($lang = ''): array
    {
        $field = empty($lang) ? 'name' : 'name_' . $lang;

        return self::get()->pluck($field, 'id')->toArray();
    }

    public function selectRoomTypeAlias(): array
    {
        return self::get()->pluck('alias', 'id')->toArray();
    }
}
