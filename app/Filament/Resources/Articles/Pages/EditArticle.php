<?php

namespace App\Filament\Resources\Articles\Pages;

use App\Filament\Resources\ArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditArticle extends EditRecord
{
    protected static string $resource = ArticleResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['title_am'] = $data['title_am'] ?? '';
        $data['title_ru'] = $data['title_ru'] ?? '';
        $data['title_en'] = $data['title_en'] ?? '';

        $data['short_description_am'] = $data['short_description_am'] ?? '';
        $data['short_description_ru'] = $data['short_description_ru'] ?? '';
        $data['short_description_en'] = $data['short_description_en'] ?? '';

        $data['content_am'] = is_array($data['content_am'] ?? null) ? $data['content_am'] : [];
        $data['content_ru'] = is_array($data['content_ru'] ?? null) ? $data['content_ru'] : [];
        $data['content_en'] = is_array($data['content_en'] ?? null) ? $data['content_en'] : [];

        $data['images'] = is_array($data['images'] ?? null) ? $data['images'] : [];

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['title_am'] = $data['title_am'] ?? '';
        $data['title_ru'] = $data['title_ru'] ?? '';
        $data['title_en'] = $data['title_en'] ?? '';

        $data['short_description_am'] = $data['short_description_am'] ?? '';
        $data['short_description_ru'] = $data['short_description_ru'] ?? '';
        $data['short_description_en'] = $data['short_description_en'] ?? '';

        $data['content_am'] = is_array($data['content_am'] ?? null) ? $data['content_am'] : [];
        $data['content_ru'] = is_array($data['content_ru'] ?? null) ? $data['content_ru'] : [];
        $data['content_en'] = is_array($data['content_en'] ?? null) ? $data['content_en'] : [];

        $data['images'] = is_array($data['images'] ?? null) ? $data['images'] : [];

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
