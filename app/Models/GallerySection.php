<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GallerySection extends Model
{
    protected $fillable = [
        'title',
        'left_text',
        'right_text',
        'more_button_text',
        'title_am',
        'title_ru',
        'title_en',
        'left_text_am',
        'left_text_ru',
        'left_text_en',
        'right_text_am',
        'right_text_ru',
        'right_text_en',
        'more_button_text_am',
        'more_button_text_ru',
        'more_button_text_en',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(GalleryItem::class)->orderBy('sort_order');
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

