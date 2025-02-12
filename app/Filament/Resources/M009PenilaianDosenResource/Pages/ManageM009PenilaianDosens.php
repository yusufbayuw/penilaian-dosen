<?php

namespace App\Filament\Resources\M009PenilaianDosenResource\Pages;

use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ManageRecords;
use App\Filament\Resources\M009PenilaianDosenResource;

class ManageM009PenilaianDosens extends ManageRecords
{
    protected static string $resource = M009PenilaianDosenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        $tabs = [
            'semua' => Tab::make('semua')
                ->badge($this->getModel()::count())
                ->badgeColor("primary"),
            'sudah_mengisi' => Tab::make('sudah_mengisi')
                ->label('sudah mengisi')
                ->badge($this->getModel()::whereNotNull('q_01')->count())
                ->badgeColor("success")
                ->modifyQueryUsing(function ($query) {
                    return $query->whereNotNull('q_01');
                }),
            'belum_mengisi' => Tab::make('belum_mengisi')
                ->label('belum mengisi')
                ->badge($this->getModel()::whereNull('q_01')->count())
                ->badgeColor("danger")
                ->modifyQueryUsing(function ($query) {
                    return $query->whereNull('q_01');
                }),
        ];

        return $tabs;
    }
}
