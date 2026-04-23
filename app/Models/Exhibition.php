<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exhibition extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image',
        'title_am',
        'title_ru',
        'title_en',
        'description_am',
        'description_ru',
        'description_en',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(ExhibitionItem::class)->orderBy('sort_order');
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

