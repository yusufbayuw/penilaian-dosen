<?php

namespace App\Filament\Resources\M003MataKuliahResource\Pages;

use App\Filament\Resources\M003MataKuliahResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageM003MataKuliahs extends ManageRecords
{
    protected static string $resource = M003MataKuliahResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
