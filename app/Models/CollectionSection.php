<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CollectionSection extends Model
{
    protected $fillable = [
        'title',
        'description',
        'more_button_text',
        'title_am',
        'title_ru',
        'title_en',
        'description_am',
        'description_ru',
        'description_en',
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
        return $this->hasMany(CollectionItem::class)->orderBy('sort_order');
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

