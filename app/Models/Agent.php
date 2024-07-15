<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Agent extends Authenticatable
{
    use HasFactory, SoftDeletes, LogsActivity;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function scopePublished(Builder $query)
    {
        return $query->where('status', '=', StatusEnum::PUBLISHED);
    }

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class, 'agent_id');
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
}
