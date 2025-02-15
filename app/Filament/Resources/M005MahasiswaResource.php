<?php

namespace App\Filament\Resources;

use App\Filament\Resources\M005MahasiswaResource\Pages;
use App\Filament\Resources\M005MahasiswaResource\RelationManagers;
use App\Models\M005Mahasiswa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class M005MahasiswaResource extends Resource
{
    protected static ?string $model = M005Mahasiswa::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $slug = 'mahasiswa';

    protected static ?string $modelLabel = 'Mahasiswa';

    protected static ?string $navigationLabel = 'Mahasiswa';
    
    protected static ?string $navigationGroup = 'Master Data';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('npm')
                    ->label('NPM')
                    ->unique(ignoreRecord:true)
                    ->required(),
                Forms\Components\TextInput::make('nama')
                    ->required(),
                Forms\Components\Toggle::make('aktif')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('npm')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\IconColumn::make('aktif')
                    ->boolean(),
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
            'index' => Pages\ManageM005Mahasiswas::route('/'),
        ];
    }
}
