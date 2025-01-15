<?php

namespace App\Filament\Resources\M008KelasDosenResource\Pages;

use App\Filament\Resources\M008KelasDosenResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageM008KelasDosens extends ManageRecords
{
    protected static string $resource = M008KelasDosenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
