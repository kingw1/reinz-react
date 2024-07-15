<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class City extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected string $local;

    public function __construct(array $attributes = [])
    {
        $this->local = app()->getLocale();
        parent::__construct($attributes);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function districts(): HasMany
    {
        return $this->hasMany(District::class, 'city_id');
    }

    public function areas(): HasMany
    {
        return $this->hasMany(Area::class, 'city_id');
    }

    protected function name(): Attribute
    {
        return Attribute::make(fn (mixed $value, array $attributes) => $attributes['name_' . $this->local]);
    }
}
