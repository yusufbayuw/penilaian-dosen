<?php

namespace App\Filament\Resources;

use App\Filament\Resources\M008KelasDosenResource\Pages;
use App\Filament\Resources\M008KelasDosenResource\RelationManagers;
use App\Models\M008KelasDosen;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class M008KelasDosenResource extends Resource
{
    protected static ?string $model = M008KelasDosen::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $slug = 'kelas-dosen';

    protected static ?string $modelLabel = 'Kelas Dosen';

    protected static ?string $navigationLabel = 'Kelas Dosen';
    
    protected static ?string $navigationGroup = 'Mapping';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('kelas_id')
                    ->relationship('kelas', 'nama'),
                Forms\Components\Select::make('dosen_id')
                    ->relationship('dosen', 'nama'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kelas.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('dosen.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageM008KelasDosens::route('/'),
        ];
    }
}
