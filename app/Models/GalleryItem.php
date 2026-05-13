<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class GalleryItem extends Model
{
    protected $fillable = [
        'gallery_section_id',
        'slug',
        'title',
        'short_description',
        'full_description',
        'image',
        'detail_images',
        'secondary_image',
        'third_image',
        'fourth_image',
        'same_line_title',
        'size',
        'material',
        'title_am',
        'title_ru',
        'title_en',
        'short_description_am',
        'short_description_ru',
        'short_description_en',
        'full_description_am',
        'full_description_ru',
        'full_description_en',
        'same_line_title_am',
        'same_line_title_ru',
        'same_line_title_en',
        'size_am',
        'size_ru',
        'size_en',
        'material_am',
        'material_ru',
        'material_en',
        'show_columns_am',
        'show_columns_ru',
        'show_columns_en',
        'sort_order',
        'home_sort_order',
        'is_active',
        'is_featured_on_home',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured_on_home' => 'boolean',
        'sort_order' => 'integer',
        'home_sort_order' => 'integer',
        'show_columns_am' => 'array',
        'show_columns_ru' => 'array',
        'show_columns_en' => 'array',
        'detail_images' => 'array',
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(GallerySection::class, 'gallery_section_id');
    }

    /**
     * Home / collection strip: explicit home_sort_order first (smaller = earlier in the grid),
     * then gallery sort_order. Rows without home_sort_order follow those with it.
     */
    public function scopeOrderedForHomePage(Builder $query): Builder
    {
        return $query
            ->orderByRaw('(home_sort_order IS NULL) ASC')
            ->orderBy('home_sort_order')
            ->orderBy('sort_order')
            ->orderBy('id');
    }

    /**
     * Filament FileUpload may store a single-element array or JSON array string.
     */
    public static function normalizeStoredImage(mixed $value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (is_array($value)) {
            $first = reset($value);

            return is_string($first) && $first !== '' ? $first : null;
        }

        if (! is_string($value)) {
            return null;
        }

        $trimmed = trim($value);
        if ($trimmed === '') {
            return null;
        }

        if (str_starts_with($trimmed, '[')) {
            $decoded = json_decode($trimmed, true);
            if (is_array($decoded)) {
                $first = reset($decoded);

                return is_string($first) && $first !== '' ? $first : null;
            }
        }

        return $trimmed;
    }

    /**
     * @return list<string> Relative paths on the public disk (Filament may nest single paths in arrays).
     */
    public static function normalizeDetailImagesArray(mixed $value): array
    {
        if ($value === null || $value === '') {
            return [];
        }

        if (! is_array($value)) {
            if (is_string($value)) {
                $decoded = json_decode($value, true);
                $value = is_array($decoded) ? $decoded : [];
            } else {
                return [];
            }
        }

        $out = [];
        foreach ($value as $entry) {
            $path = self::normalizeDetailImagePath($entry);
            if ($path !== null) {
                $out[] = $path;
            }
        }

        return array_values(array_unique($out));
    }

    private static function normalizeDetailImagePath(mixed $entry): ?string
    {
        if ($entry === null || $entry === '') {
            return null;
        }

        if (is_string($entry)) {
            $t = trim($entry);

            return $t !== '' ? $t : null;
        }

        if (is_array($entry)) {
            return self::normalizeStoredImage($entry);
        }

        return null;
    }

    /**
     * @return list<string> Public URLs for detail row(s) under the main image on the artwork page.
     */
    public function detailImagesPublicUrls(): array
    {
        $paths = self::normalizeDetailImagesArray($this->detail_images);
        if ($paths === []) {
            return [];
        }

        $disk = Storage::disk('public');
        $urls = [];
        foreach ($paths as $path) {
            $urls[] = $disk->url($path);
        }

        return $urls;
    }

    /**
     * Public URL for list/grid views (lightweight thumb when available).
     */
    public function listImagePublicUrl(): ?string
    {
        $thumb = self::normalizeStoredImage($this->image_thumb ?? null);
        $main = self::normalizeStoredImage($this->image ?? null);
        $path = $thumb ?: $main;
        if ($path === null) {
            return null;
        }

        return Storage::disk('public')->url($path);
    }

    /**
     * Full-size main image URL (detail page, zoom).
     */
    public function mainImagePublicUrl(): ?string
    {
        $path = self::normalizeStoredImage($this->image ?? null);
        if ($path === null) {
            return null;
        }

        return Storage::disk('public')->url($path);
    }

    public function localized(string $field, ?string $locale = null): ?string
    {
        $locale = $locale ?? app()->getLocale();
        if ($locale === 'hy') $locale = 'am';

        $localizedField = $field . '_' . $locale;
        $value = $this->getAttribute($localizedField);
        if (is_string($value) && trim($value) !== '') return $value;

        $fallback = $this->getAttribute($field);
        return is_string($fallback) && trim($fallback) !== '' ? $fallback : null;
    }
}

