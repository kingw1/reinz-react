<?php

namespace App\Models;

use App\Enums\StatusEnum;
use App\Repositories\AmenitiesRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Number;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Property extends Model
{
    use HasFactory, HasUuids, SoftDeletes, LogsActivity;

    const SALE = 'buy';
    const RENT = 'rent';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $casts = [
        'general_images' => 'array',
        'floor_plan_images' => 'array',
        'unit_plan_images' => 'array',
        'furnitures' => 'array',
        'amenities' => 'array'
    ];

    protected string $local;

    public function __construct(array $attributes = [])
    {
        $this->local = app()->getLocale();
        parent::__construct($attributes);
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::created(function (Property $property) {
            $propertyRegisterForm                       = new PropertyRegisterForm;
            $propertyRegisterForm->propertyable_id      = $property->id;
            $propertyRegisterForm->propertyable_type    = get_class($property);
            $propertyRegisterForm->agent_id             = $property->agent_id;
            $propertyRegisterForm->project_type_id      = $property->project->project_type_id;
            $propertyRegisterForm->property_type        = $property->type;
            $propertyRegisterForm->form_type            = 'single';
            $propertyRegisterForm->save();
        });
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

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function roomType(): BelongsTo
    {
        return $this->belongsTo(RoomType::class, 'room_type');
    }

    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class, 'agent_id');
    }

    protected function name(): Attribute
    {
        return Attribute::make(fn (mixed $value, array $attributes) => $attributes['name_' . $this->local]);
    }

    protected function description(): Attribute
    {
        return Attribute::make(fn (mixed $value, array $attributes) => $attributes['description_' . $this->local]);
    }

    public function getCoverImage()
    {
        if (
            count($this->general_images)
            && isset($this->general_images[0])
            && Storage::disk('public')->exists($this->general_images[0])
        ) {
            return Storage::disk('public')->url($this->general_images[0]);
        }

        return '/img/no-photo.png';
    }

    public function getRoomPricePerSqm()
    {
        return $this->room_price / $this->room_size;
    }

    public function getFurnitures()
    {
        if (!empty($this->furnitures)) {
            return Furniture::query()->whereIn('id', $this->furnitures)->pluck('name_' . $this->local)->toArray();
        }
    }

    public function isNewProperty()
    {
        $date = Carbon::parse($this->created_at)->addDays(config('custom.new_property_days'));

        return Carbon::now()->lte($date);
    }

    public function getPropertytNameAttribute()
    {
        return $this->{'name_' . $this->local};
    }

    public function getRoomPriceCurrencyAttribute()
    {
        return '$' . number_format($this->room_price, 0);
    }

    public function getRoomPriceAverageAttribute()
    {
        $average = ($this->room_price / $this->room_size);

        return number_format($average, 0) . '/m²';
    }
}
