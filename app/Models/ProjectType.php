<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProjectType extends Model
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
        return Attribute::make(fn (mixed $value, array $attributes) => $attributes['name_' . $this->local]);
    }

    protected function descriptionBuy(): Attribute
    {
        return Attribute::make(fn (mixed $value, array $attributes) => $attributes['description_buy_' . $this->local]);
    }

    protected function descriptionRent(): Attribute
    {
        return Attribute::make(fn (mixed $value, array $attributes) => $attributes['description_rent_' . $this->local]);
    }

    public function selectProjectTypes($lang = ''): array
    {
        $field = empty($lang) ? 'name' : 'name_' . $lang;

        return self::select('id', DB::raw("$field as label"))->get()->toArray();
    }
}
