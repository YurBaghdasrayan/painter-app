<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    protected $fillable = [
        'slug',

        'title_am',
        'title_ru',
        'title_en',

        'short_description_am',
        'short_description_ru',
        'short_description_en',

        'content_am',
        'content_ru',
        'content_en',

        'images',

        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'content_am' => 'array',
        'content_ru' => 'array',
        'content_en' => 'array',
        'images' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected static function booted(): void
    {
        static::saving(function (self $article) {
            if (blank($article->slug)) {
                $sourceTitle = $article->title_en ?: $article->title_ru ?: $article->title_am ?: 'article';
                $article->slug = Str::slug($sourceTitle);
            }
        });
    }

    public function localized(string $field, ?string $locale = null): mixed
    {
        $locale = $locale ?? app()->getLocale();

        if ($locale === 'hy') {
            $locale = 'am';
        }

        $fieldName = $field . '_' . $locale;
        $value = $this->{$fieldName} ?? null;

        if (is_array($value) && !empty($value)) {
            return $value;
        }

        if (is_string($value) && trim($value) !== '') {
            return $value;
        }

        foreach (['en', 'ru', 'am'] as $fallbackLocale) {
            $fallbackField = $field . '_' . $fallbackLocale;
            $fallbackValue = $this->{$fallbackField} ?? null;

            if (is_array($fallbackValue) && !empty($fallbackValue)) {
                return $fallbackValue;
            }

            if (is_string($fallbackValue) && trim($fallbackValue) !== '') {
                return $fallbackValue;
            }
        }

        return is_array($value) ? [] : null;
    }

    public function localizedTitle(?string $locale = null): ?string
    {
        return $this->localized('title', $locale);
    }

    public function localizedShortDescription(?string $locale = null): ?string
    {
        return $this->localized('short_description', $locale);
    }

    public function localizedContent(?string $locale = null): array
    {
        $content = $this->localized('content', $locale);

        return is_array($content) ? $content : [];
    }

    public function firstImage(): ?string
    {
        $images = $this->images ?? [];

        if (!is_array($images) || empty($images)) {
            return null;
        }

        return $images[0] ?? null;
    }

    public function secondImage(): ?string
    {
        $images = $this->images ?? [];

        if (!is_array($images) || count($images) < 2) {
            return null;
        }

        return $images[1] ?? null;
    }
}
