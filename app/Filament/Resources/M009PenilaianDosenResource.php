<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\M009PenilaianDosen;
use pxlrbt\FilamentExcel\Columns\Column;
use Illuminate\Database\Eloquent\Builder;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use App\Filament\Resources\M009PenilaianDosenResource\Pages;
use App\Filament\Resources\M009PenilaianDosenResource\RelationManagers;

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
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kelas_mahasiswa.kelas.nama')
                    ->numeric()
                    ->sortable(),
                /* Tables\Columns\TextColumn::make('kelas_mahasiswa.mahasiswa.nama')
                    ->numeric()
                    ->sortable(), */
                Tables\Columns\TextColumn::make('kelas_dosen.dosen.nama')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('q_01'),
                Tables\Columns\TextColumn::make('q_02'),
                Tables\Columns\TextColumn::make('q_03'),
                Tables\Columns\TextColumn::make('q_04'),
                Tables\Columns\TextColumn::make('q_05'),
                Tables\Columns\TextColumn::make('q_06'),
                Tables\Columns\TextColumn::make('q_07'),
                Tables\Columns\TextColumn::make('q_08'),
                Tables\Columns\TextColumn::make('q_09'),
                Tables\Columns\TextColumn::make('q_10'),
                Tables\Columns\TextColumn::make('q_11'),
                Tables\Columns\TextColumn::make('q_12'),
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
            ->headerActions([
                ExportAction::make()->exports([
                    ExcelExport::make()
                        ->withColumns([
                            Column::make('kelas_mahasiswa.kelas.nama')
                                ->heading('Kelas'),
                            Column::make('kelas_dosen.dosen.nama')
                                ->heading('Dosen'),
                            Column::make('kelas_mahasiswa.kelas.mata_kuliah.nama')
                                ->heading('Mata Kuliah'),
                            Column::make('q_01'),
                            Column::make('q_02'),
                            Column::make('q_03'),
                            Column::make('q_04'),
                            Column::make('q_05'),
                            Column::make('q_06'),
                            Column::make('q_07'),
                            Column::make('q_08'),
                            Column::make('q_09'),
                            Column::make('q_10'),
                            Column::make('q_11'),
                            Column::make('q_12'),
                        ])
                        ->withFilename(fn (M009PenilaianDosen $record) => "Penilaian-Dosen-".date('Y-m-d').".xlsx")
                        ->modifyQueryUsing(fn($query) => $query->where('is_done', true)),
                ])
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
