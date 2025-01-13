<?php

namespace App\Filament\Resources;

use App\Filament\Resources\M002SemesterResource\Pages;
use App\Filament\Resources\M002SemesterResource\RelationManagers;
use App\Models\M002Semester;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class M002SemesterResource extends Resource
{
    protected static ?string $model = M002Semester::class;

    protected static ?string $navigationIcon = 'heroicon-o-adjustments-horizontal';

    protected static ?string $slug = 'semester';

    protected static ?string $modelLabel = 'Semester';

    protected static ?string $navigationLabel = 'Semester';
    
    protected static ?string $navigationGroup = 'Master Data';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->label('Semester')
                    ->hint('misal: Semester 1')
                    ->required(),
                Forms\Components\TextInput::make('kode')
                    ->hint('misal: S01'),
                Forms\Components\Toggle::make('aktif')
                    ->label('Semester sedang Berjalan?')
                    ->default(false),
                Forms\Components\Toggle::make('penilaian')
                    ->label('Masa Penilaian?')
                    ->default(false),
                Forms\Components\Select::make('tahun_ajaran_id')
                    ->relationship('tahun_ajaran', 'tahun')
                    ->required(),
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
                Tables\Columns\IconColumn::make('aktif')
                    ->boolean(),
                Tables\Columns\IconColumn::make('penilaian')
                    ->boolean(),
                Tables\Columns\TextColumn::make('tahun_ajaran.tahun')
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
            'index' => Pages\ManageM002Semesters::route('/'),
        ];
    }
}
