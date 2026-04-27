<?php

namespace App\Filament\Resources\PicturesAndVideoResource\Pages;

use App\Filament\Resources\PicturesAndVideoResource;
use App\Models\PicturesAndVideo;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPicturesAndVideos extends ListRecords
{
    protected static string $resource = PicturesAndVideoResource::class;

    public function mount(): void
    {
        parent::mount();

        $record = PicturesAndVideo::query()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->first();

        if ($record) {
            $this->redirect(PicturesAndVideoResource::getUrl('edit', ['record' => $record]));
            return;
        }

        $this->redirect(PicturesAndVideoResource::getUrl('create'));
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

