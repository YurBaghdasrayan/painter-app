<?php

namespace App\Filament\Resources\ExhibitionItemResource\Pages;

use App\Filament\Resources\ExhibitionItemResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListExhibitionItems extends ListRecords
{
    protected static string $resource = ExhibitionItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

