<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Developer extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

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

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'developer_id');
    }

    protected function name(): Attribute
    {
        return Attribute::make(fn (mixed $value, array $attributes) => $attributes['name_' . $this->local]);
    }

    protected function logoUrl(): Attribute
    {
        return Attribute::make(function (mixed $value, array $attributes) {
            if (!empty($attributes['logo']) && Storage::disk('public')->exists($attributes['logo'])) {
                return Storage::disk('public')->url($attributes['logo']);
            }

            return '/img/no-photo.png';
        });
    }

    public function selectDevelopers($lang = ''): array
    {
        $field = empty($lang) ? 'name' : 'name_' . $this->local;

        return self::get()->pluck($field, 'id')->toArray();
    }
}
