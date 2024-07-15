<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    use HasFactory;

    protected string $local;

    public function __construct(array $attributes = [])
    {
        $this->local = app()->getLocale();
        parent::__construct($attributes);
    }
    
    protected function name(): Attribute
    {
        return Attribute::make(fn (mixed $value, array $attributes) => $attributes['name_'.$this->local]);
    }

    public function selectAmenities($lang = ''): array
    {
        $field = empty($lang) ? 'name' : 'name_' . $lang;

        return self::get()->pluck($field, 'id')->toArray();
    }
}
