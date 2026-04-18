<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaticPage extends Model
{
    protected $fillable = [
        'slug',
        'title',
        'content_am',
        'content_ru',
        'content_en',
        'is_active',
    ];

    protected $casts = [
        'content_am' => 'array',
        'content_ru' => 'array',
        'content_en' => 'array',
        'is_active' => 'boolean',
    ];

    public function localizedContent(?string $locale = null): array
    {
        $locale = $locale ?? app()->getLocale();

        if ($locale === 'hy') {
            $locale = 'am';
        }

        $tryLocales = [$locale, 'en', 'ru', 'am'];

        foreach ($tryLocales as $tryLocale) {
            $field = 'content_' . $tryLocale;
            $content = $this->{$field} ?? [];

            if (is_array($content) && !empty($content)) {
                return $content;
            }
        }

        return [];
    }

    public function getBlock(string $key, ?string $locale = null): array
    {
        if ($locale !== null) {
            if ($locale === 'hy') {
                $locale = 'am';
            }

            $field = 'content_' . $locale;
            $content = $this->{$field} ?? [];
            $block = data_get($content, $key, []);

            return is_array($block) ? $block : [];
        }

        $content = $this->localizedContent();
        $block = data_get($content, $key, []);

        return is_array($block) ? $block : [];
    }
}
