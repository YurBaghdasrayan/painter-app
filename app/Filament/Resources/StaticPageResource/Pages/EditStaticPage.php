<?php

namespace App\Filament\Resources\StaticPageResource\Pages;

use App\Filament\Resources\StaticPageResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Arr;

class EditStaticPage extends EditRecord
{
    protected static string $resource = StaticPageResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $slug = (string) ($data['slug'] ?? '');
        if ($slug !== 'home') {
            return $data;
        }

        $paths = [
            'hero.videos.0',
            'hero.videos.1',
            'hero.videos.2',
            'about_section.background_image',
            'articles_section.main_image',
            'articles_section.side_image',
            'exhibitions_section.background_image',
        ];

        $pick = function (string $path) use ($data) {
            foreach (['en', 'am', 'ru'] as $loc) {
                $val = Arr::get($data, "content_{$loc}.{$path}");
                if (is_string($val) && trim($val) !== '') return $val;
                if (is_array($val) && $val !== []) return $val;
                if (!is_null($val) && !is_string($val) && !is_array($val)) return $val;
            }
            return null;
        };

        foreach (['am', 'ru', 'en'] as $locale) {
            foreach ($paths as $path) {
                Arr::set($data, "content_{$locale}.{$path}", $pick($path));
            }
        }

        return $data;
    }
}
