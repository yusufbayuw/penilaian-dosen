<?php

namespace App\Filament\Resources\M009RekapPenilaianDosenResource\Pages;

use App\Filament\Resources\M009RekapPenilaianDosenResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageM009RekapPenilaianDosens extends ManageRecords
{
    protected static string $resource = M009RekapPenilaianDosenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
