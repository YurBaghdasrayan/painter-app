<?php

namespace App\Filament\Resources\PicturesAndVideoResource\Pages;

use App\Filament\Resources\PicturesAndVideoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPicturesAndVideo extends EditRecord
{
    protected static string $resource = PicturesAndVideoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

