<?php

namespace App\Filament\Resources\AnnonceResource\Pages;

use App\Filament\Resources\AnnonceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAnnonce extends EditRecord
{
    protected static string $resource = AnnonceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
