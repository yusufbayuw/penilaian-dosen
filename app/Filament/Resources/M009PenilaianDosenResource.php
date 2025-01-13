<?php

namespace App\Filament\Resources;

use App\Filament\Resources\M009PenilaianDosenResource\Pages;
use App\Filament\Resources\M009PenilaianDosenResource\RelationManagers;
use App\Models\M009PenilaianDosen;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class M009PenilaianDosenResource extends Resource
{
    protected static ?string $model = M009PenilaianDosen::class;

    protected static ?string $navigationIcon = 'heroicon-o-pencil';

    protected static ?string $slug = 'penilaian-dosen';

    protected static ?string $modelLabel = 'Penilaian Dosen';

    protected static ?string $navigationLabel = 'Penilaian Dosen';
    
    protected static ?string $navigationGroup = 'Penilaian';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Radio::make('q_01')
                    ->label('Dosen menguasai materi perkuliahan?')
                    ->options([
                        1 => "Sangat Tidak Setuju",
                        2 => "Tidak Setuju",
                        3 => "Netral",
                        4 => "Setuju",
                        5 => "Sangat Setuju"
                    ])
                    ->inline()
                    ->inlineLabel(false),
                Forms\Components\Radio::make('q_02')
                    ->label('Dosen mengajar semua materi perkulihan?')
                    ->options([
                        1 => "Sangat Tidak Setuju",
                        2 => "Tidak Setuju",
                        3 => "Netral",
                        4 => "Setuju",
                        5 => "Sangat Setuju"
                    ])
                    ->inline()
                    ->inlineLabel(false),
                Forms\Components\Radio::make('q_03')
                    ->label('Dosen berkomunikasi dengan baik?')
                    ->options([
                        1 => "Sangat Tidak Setuju",
                        2 => "Tidak Setuju",
                        3 => "Netral",
                        4 => "Setuju",
                        5 => "Sangat Setuju"
                    ])
                    ->inline()
                    ->inlineLabel(false),
                Forms\Components\Select::make('kelas_mahasiswa_id')
                    ->relationship('kelas_mahasiswa', 'id')
                    ->hiddenOn('edit'),
                Forms\Components\Select::make('kelas_dosen_id')
                    ->relationship('kelas_dosen', 'id')
                    ->hiddenOn('edit'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kelas_mahasiswa.kelas.nama')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kelas_mahasiswa.mahasiswa.nama')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kelas_dosen.dosen.nama')
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
            'index' => Pages\ManageM009PenilaianDosens::route('/'),
        ];
    }
}
