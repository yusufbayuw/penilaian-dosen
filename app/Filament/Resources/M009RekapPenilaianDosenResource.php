<?php

namespace App\Filament\Resources;

use App\Filament\Resources\M009RekapPenilaianDosenResource\Pages;
use App\Filament\Resources\M009RekapPenilaianDosenResource\RelationManagers;
use App\Models\M002Semester;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class M009RekapPenilaianDosenResource extends Resource
{
    protected static ?string $model = M002Semester::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';

    protected static ?string $slug = 'rekap-penilaian-dosen';

    protected static ?string $modelLabel = 'Rekap Penilaian Dosen';

    protected static ?string $navigationLabel = 'Rekap Penilaian Dosen';
    
    protected static ?string $navigationGroup = 'Penilaian';

    //protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('tahun_ajaran.tahun')
                    ->label('Tahun Ajaran')
                    ->inlineLabel(),
                TextEntry::make('nama')
                    ->inlineLabel(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tahun_ajaran.tahun')
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kode')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('export')
                    ->color('primary')
                    ->icon('heroicon-o-document-arrow-down')
                    ->button()
                    ->action(function () {
                        //
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageM009RekapPenilaianDosens::route('/'),
        ];
    }
}
