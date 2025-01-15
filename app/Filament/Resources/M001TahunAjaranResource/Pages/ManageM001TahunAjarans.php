<?php

namespace App\Filament\Resources\M001TahunAjaranResource\Pages;

use App\Filament\Resources\M001TahunAjaranResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageM001TahunAjarans extends ManageRecords
{
    protected static string $resource = M001TahunAjaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
