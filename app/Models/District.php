<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class District extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'district_id');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    protected function name(): Attribute
    {
        return Attribute::make(fn (mixed $value, array $attributes) => $attributes['name_en'] . ' | ' . $attributes['name_kh']);
    }

    public function selectDistricts($cityId = 0, $lang = ''): array
    {
        $field = empty($lang) ? 'name' : 'name_' . $lang;

        return self::query()
            ->when($cityId, fn ($query, $cityId) => $query->where('city_id', $cityId))
            ->select('id', DB::raw("$field as label"))->get()->toArray();
    }

    public function getSlugAttribute()
    {
        return Str::slug($this->name_en);
    }
}
