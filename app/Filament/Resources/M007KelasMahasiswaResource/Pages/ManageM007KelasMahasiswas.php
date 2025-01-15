<?php

namespace App\Filament\Resources\M007KelasMahasiswaResource\Pages;

use App\Filament\Resources\M007KelasMahasiswaResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageM007KelasMahasiswas extends ManageRecords
{
    protected static string $resource = M007KelasMahasiswaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
