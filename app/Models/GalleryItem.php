<?php

namespace App\Models;

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
        'is_active',
        'is_featured_on_home',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured_on_home' => 'boolean',
        'sort_order' => 'integer',
        'show_columns_am' => 'array',
        'show_columns_ru' => 'array',
        'show_columns_en' => 'array',
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(GallerySection::class, 'gallery_section_id');
    }

    /**
     * Public URL for list/grid views (lightweight thumb when available).
     */
    public function listImagePublicUrl(): ?string
    {
        $path = $this->image_thumb ?: $this->image;
        if (! is_string($path) || trim($path) === '') {
            return null;
        }

        return Storage::disk('public')->url($path);
    }

    /**
     * Full-size main image URL (detail page, zoom).
     */
    public function mainImagePublicUrl(): ?string
    {
        if (! is_string($this->image) || trim($this->image) === '') {
            return null;
        }

        return Storage::disk('public')->url($this->image);
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

