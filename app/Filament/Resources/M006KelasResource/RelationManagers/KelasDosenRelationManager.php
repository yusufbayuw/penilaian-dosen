<?php

namespace App\Filament\Resources\M006KelasResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KelasDosenRelationManager extends RelationManager
{
    protected static string $relationship = 'kelas_dosen';

    protected static ?string $title = 'Dosen Pengajar';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('kelas_id')
                    ->default($this->ownerRecord->id),
                Forms\Components\Select::make('dosen_id')
                    ->label('Pilih Dosen')
                    ->required()
                    ->relationship('dosen', 'nama'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('dosen_id')
            ->columns([
                Tables\Columns\TextColumn::make('dosen.nidn')
                    ->label("NIDN"),
                Tables\Columns\TextColumn::make('dosen.nama'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Tambah Dosen'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
