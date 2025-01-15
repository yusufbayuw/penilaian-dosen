<?php

namespace App\Filament\Resources\M006KelasResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KelasMahasiswaRelationManager extends RelationManager
{
    protected static string $relationship = 'kelas_mahasiswa';

    protected static ?string $title = "Mahasiswa Peserta";

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('mahasiswa_id')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->relationship('mahasiswa', 'nama'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('mahasiswa_id')
            ->columns([
                Tables\Columns\TextColumn::make('mahasiswa.npm')
                    ->label('NPM'),
                Tables\Columns\TextColumn::make('mahasiswa.nama')
                    ->label('Nama'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label("Tambah Mahasiswa"),
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
