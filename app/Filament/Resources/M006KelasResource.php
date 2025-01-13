<?php

namespace App\Filament\Resources;

use App\Filament\Resources\M006KelasResource\Pages;
use App\Filament\Resources\M006KelasResource\RelationManagers;
use App\Models\M002Semester;
use App\Models\M003MataKuliah;
use App\Models\M006Kelas;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class M006KelasResource extends Resource
{
    protected static ?string $model = M006Kelas::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $slug = 'kelas';

    protected static ?string $modelLabel = 'Kelas';

    protected static ?string $navigationLabel = 'Kelas';
    
    protected static ?string $navigationGroup = 'Pembelajaran';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('mata_kuliah_id')
                    ->relationship('mata_kuliah', 'nama')
                    ->searchable()
                    ->preload()
                    ->afterStateUpdated(fn (Set $set, $state) => $set('nama', M003MataKuliah::find($state)->nama))
                    ->reactive()
                    ->required(),
                Forms\Components\Select::make('semester_id')
                    ->options(function () {
                        return M002Semester::with('tahun_ajaran')
                            ->get()
                            ->mapWithKeys(function ($semester) {
                                return [$semester->id => "{$semester->tahun_ajaran->tahun} - {$semester->nama}" ];
                            })
                            ->toArray();
                    })
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('nama'),
                Forms\Components\TextInput::make('kode'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kode')
                    ->searchable(),
                Tables\Columns\TextColumn::make('semester.nama')
                    ->sortable(),
                Tables\Columns\TextColumn::make('mata_kuliah.nama')
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
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\KelasDosenRelationManager::class,
            RelationManagers\KelasMahasiswaRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListM006Kelas::route('/'),
            'create' => Pages\CreateM006Kelas::route('/create'),
            'edit' => Pages\EditM006Kelas::route('/{record}/edit'),
        ];
    }
}
