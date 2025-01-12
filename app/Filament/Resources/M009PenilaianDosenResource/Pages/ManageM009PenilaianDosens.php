<?php

namespace App\Filament\Resources\M009PenilaianDosenResource\Pages;

use App\Filament\Resources\M009PenilaianDosenResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageM009PenilaianDosens extends ManageRecords
{
    protected static string $resource = M009PenilaianDosenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
