<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Traits\GenerateUniqueSlugTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Area extends Model
{
    use HasFactory, LogsActivity, GenerateUniqueSlugTrait, SoftDeletes;

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

    public function sluggable(): string
    {
        return 'name_en';
    }
    
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'area_id');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    protected function name(): Attribute
    {
        return Attribute::make(fn(mixed $value, array $attributes) => $attributes['name_' . $this->local]);
    }

    public function selectAreas($cityId = 0, $lang = ''): array
    {
        $field = empty($lang) ? 'name' : 'name_' . $lang;

        return self::query()
            ->when($cityId, fn($query, $cityId) => $query->where('city_id', $cityId))
            ->get()->pluck($field, 'id')->toArray();
    }

    public function description($type)
    {
        $attr = 'description_'.$type.'_'.$this->local;
        
        return $this->$attr; 
    }

    public function getSlugAttribute()
    {
        return Str::slug($this->name_en);
    }

    public function getClassNameAttribute()
    {
        return Str::replace(' ', '', Str::title($this->name_en));
    }
}
