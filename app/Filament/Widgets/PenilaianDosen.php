<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Radio;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Filament\Resources\M009PenilaianDosenResource;
use App\Models\M009PenilaianDosen;

class PenilaianDosen extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    public static function canView(): bool
    {
        return auth()->user()->hasRole(['super_admin', 'mahasiswa']);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                function () {
                    if (auth()->user()->hasRole('super_admin')) {
                        return M009PenilaianDosenResource::getEloquentQuery();
                    } elseif (auth()->user()->hasRole('mahasiswa')) {
                        return M009PenilaianDosenResource::getEloquentQuery()->where('kelas_mahasiswa_id', auth()->user()->mahasiswa->kelas_mahasiswa->pluck('id') ?? null);
                    }
                }
            )
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
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Isi Kuesioner')
                    ->form([
                        Radio::make('q_01')
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
                        Radio::make('q_02')
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
                        Radio::make('q_03')
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
                    ])
                    ->action(function (array $data, M009PenilaianDosen $record): void {
                        $record->q_01 = $data['q_01'];
                        $record->q_02 = $data['q_02'];
                        $record->q_03 = $data['q_03'];
                        $record->save();
                    }),
            ]);
    }
}
