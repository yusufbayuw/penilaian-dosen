<?php

namespace App\Filament\Resources\M005MahasiswaResource\Pages;

use App\Filament\Resources\M005MahasiswaResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageM005Mahasiswas extends ManageRecords
{
    protected static string $resource = M005MahasiswaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
