<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

/**
 * @method static saving(\Closure $param)
 */
trait GenerateUniqueSlugTrait
{
    public static function bootGenerateUniqueSlugTrait(): void
    {
        static::saving(function ($model) {
            if (!$model->{$model->slugKey()}) {
                $model->{$model->slugKey()} = static::generateUniqueSlug($model->{$model->sluggable()});
            }
        });
    }

    protected function slugKey(): string
    {
        return 'slug';
    }

    abstract public function sluggable(): string;

    public static function generateUniqueSlug(?string $str): ?string
    {
        if (!$str) {
            return null;
        }

        $counter = 1;
        $strSlug = Str::slug($str);
        $slug = $strSlug;

        while (static::whereSlug($slug)->exists()) {
            $slug = $strSlug . '-' . $counter++;
        }

        return $slug;
    }

    public function scopeWhereSlug(Builder $query, string $slug): Builder
    {
        return $query->where($this->slugKey(), $slug);
    }

    public static function findBySlug(string $slug, array $columns = ['*']): static
    {
        return static::whereSlug($slug)->first($columns);
    }

    public static function findBySlugOrFail(string $slug, array $columns = ['*']): static
    {
        return static::whereSlug($slug)->firstOrFail($columns);
    }
}
