<?php

namespace App\Filament\Resources\CollectionSectionResource\Pages;

use App\Filament\Resources\CollectionSectionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCollectionSection extends EditRecord
{
    protected static string $resource = CollectionSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

