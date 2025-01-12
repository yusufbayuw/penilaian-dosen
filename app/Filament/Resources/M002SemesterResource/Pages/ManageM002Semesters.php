<?php

namespace App\Filament\Resources\M002SemesterResource\Pages;

use App\Filament\Resources\M002SemesterResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageM002Semesters extends ManageRecords
{
    protected static string $resource = M002SemesterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
