<?php

namespace App\Filament\Resources\M004DosenResource\Pages;

use App\Filament\Resources\M004DosenResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageM004Dosens extends ManageRecords
{
    protected static string $resource = M004DosenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
