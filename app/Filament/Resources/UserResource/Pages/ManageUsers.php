<?php

namespace App\Filament\Resources\UserResource\Pages;

use Filament\Actions;
use Filament\Resources\Components\Tab;
use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\ManageRecords;

class ManageUsers extends ManageRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        $tabs = [
            'admin' => Tab::make('admin')
                ->modifyQueryUsing(function ($query) {
                    return $query->whereNull('dosen_id')->whereNull('mahasiswa_id');
                }),
            'dosen' => Tab::make('dosen')
                ->modifyQueryUsing(function ($query) {
                    return $query->whereNotNull('dosen_id');
                }),
            'mahasiswa' => Tab::make('mahasiswa')
                ->modifyQueryUsing(function ($query) {
                    return $query->whereNotNull('mahasiswa_id');
                }),
        ];

        return $tabs;
    }
}
