<?php

namespace App\Filament\Resources\CollectionSectionResource\Pages;

use App\Filament\Resources\CollectionSectionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCollectionSections extends ListRecords
{
    protected static string $resource = CollectionSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

