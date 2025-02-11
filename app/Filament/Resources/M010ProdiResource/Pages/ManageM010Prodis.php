<?php

namespace App\Filament\Resources\M010ProdiResource\Pages;

use App\Filament\Resources\M010ProdiResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageM010Prodis extends ManageRecords
{
    protected static string $resource = M010ProdiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
