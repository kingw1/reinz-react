<?php

namespace App\Models;

use App\Enums\StatusEnum;
use App\Traits\GenerateUniqueSlugTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Project extends Model
{
    use HasFactory, SoftDeletes, LogsActivity, GenerateUniqueSlugTrait;

    protected string $local;

    protected $casts = [
        'general_images' => 'array',
        'floor_plan_images' => 'array',
        'unit_plan_images' => 'array',
        'amenities' => 'array',
        'surroundings' => 'array',
        'room_types' => 'array',
        'room_sizes' => 'array',
    ];

    public function __construct(array $attributes = [])
    {
        $this->local = app()->getLocale();
        parent::__construct($attributes);
    }

    public function sluggable(): string
    {
        return 'name_en';
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
        return $this->hasMany(Property::class, 'project_id')->where('status', StatusEnum::PUBLISHED);
    }

    public function projectType(): BelongsTo
    {
        return $this->belongsTo(ProjectType::class, 'project_type_id');
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function developer(): BelongsTo
    {
        return $this->belongsTo(Developer::class, 'developer_id');
    }

    protected function name(): Attribute
    {
        return Attribute::make(fn (mixed $value, array $attributes) => $attributes['name_' . $this->local]);
    }

    protected function description(): Attribute
    {
        return Attribute::make(fn (mixed $value, array $attributes) => $attributes['description_' . $this->local]);
    }

    protected function address(): Attribute
    {
        return Attribute::make(fn (mixed $value, array $attributes) => $attributes['address_' . $this->local]);
    }

    public function selectRoomTypes($projectId = 0, $lang = ''): array
    {
        $field = empty($lang) ? 'name' : 'name_' . $lang;

        $roomTypeList = self::query()
            ->where('id', $projectId)
            ->pluck('room_types')->first();

        $roomTypes = RoomType::query()
            ->whereIn('id', $roomTypeList)
            ->get()
            ->pluck($field, 'id')->toArray();

        return $roomTypes;
    }

    public function selectRoomSizes($projectId = 0, $lang = ''): array
    {
        $project = self::query()
            ->where('id', $projectId)
            ->first();

        return $project->room_sizes ?? [];
    }

    public function selectProjects($lang = ''): array
    {
        $field = empty($lang) ? 'name' : 'name_' . $lang;

        return self::published()->get()->pluck($field, 'id')->toArray();
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

    public function isNewProject()
    {
        $date = Carbon::parse($this->created_at)->addDays(config('custom.new_project_days'));

        return Carbon::now()->lte($date);
    }

    public function roomTypeList($projectId = 0, $lang = '')
    {
        $field = empty($lang) ? 'name' : 'name_' . $lang;

        $roomTypeList = self::query()
            ->where('id', $projectId)
            ->pluck('room_types')->first();

        return RoomType::query()
            ->whereIn('id', $roomTypeList)
            ->get();
    }
}
