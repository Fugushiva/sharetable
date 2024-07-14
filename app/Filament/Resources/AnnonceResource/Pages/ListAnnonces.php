<?php

namespace App\Filament\Resources\AnnonceResource\Pages;

use App\Filament\Resources\AnnonceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAnnonces extends ListRecords
{
    protected static string $resource = AnnonceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
