<?php

namespace App\Filament\Resources\M006KelasResource\Pages;

use App\Filament\Resources\M006KelasResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListM006Kelas extends ListRecords
{
    protected static string $resource = M006KelasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
