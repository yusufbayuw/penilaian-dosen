<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Livewire\Component;
use Filament\Tables\Table;
use App\Models\M009PenilaianDosen;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Wizard;
use Illuminate\Support\Facades\Blade;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Placeholder;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Filament\Resources\M009PenilaianDosenResource;
use Filament\Forms\Components\Textarea;

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
                        $penilaianIds = auth()->user()->mahasiswa
                            ->kelas_mahasiswa() 
                            ->whereHas('kelas.semester', function ($query) {
                                $query->where('aktif', true)->where('penilaian', true); 
                            })
                            ->with('penilaian') 
                            ->get()
                            ->flatMap(function ($kelasMahasiswa) {
                                return $kelasMahasiswa->penilaian->pluck('id'); 
                            })
                            ->all();
                        return M009PenilaianDosen::whereIn('id', $penilaianIds ?? null);
                    }
                }
            )
            ->columns([
                Tables\Columns\TextColumn::make('kelas_mahasiswa.kelas.nama')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kelas_mahasiswa.mahasiswa.nama')
                    ->numeric()
                    ->hidden(fn() => auth()->user()->hasRole('mahasiswa'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('kelas_dosen.dosen.nama')
                    ->numeric()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('sudah_mengisi')
                    ->disabled()
                    ->hidden(fn(M009PenilaianDosen $record) => !($record->is_done))
                    ->label('Sudah Mengisi')
                    ->badge(),
                Tables\Actions\EditAction::make()
                    ->hidden(fn(M009PenilaianDosen $record) => $record->is_done)
                    ->label('Isi Kuesioner')
                    ->form([
                        Wizard::make([
                            Wizard\Step::make('1')
                                ->label(' ')
                                ->completedIcon('heroicon-m-check-circle')
                                ->beforeValidation(function (Component $livewire) {
                                    $data = $livewire->form->getState();
                                })
                                ->schema([
                                    Section::make()
                                        ->schema([
                                            Placeholder::make('panduan')
                                                ->label('Panduan')
                                                ->content(new HtmlString('<p>Sesuai dengan yang Saudara ketahui, berilah penilaian secara <b>jujur, objektif, dan penuh tanggung jawab</b> terhadap DOSEN Saudara. Informasi yang Saudara berikan akan digunakan sebagai bahan masukan bagi dosen dan <b>tidak akan berpengaruh</b> terhadap status Saudara sebagai mahasiswa. Penilaian dilakukan terhadap aspek-aspek dalam tabel berikut dengan kriteria rentang skor 1 sampai dengan 4.</p><br>
                                                <ul>
                                                    <li><b>1</b> = Tidak baik/rendah/jarang/kurang lengkap</li>
                                                    <li><b>2</b> = Biasa/cukup/kadang-kadang/cukup lengkap</li>
                                                    <li><b>3</b> = Baik/tinggi/sering/lengkap</li>
                                                    <li><b>4</b> = Sangat baik/sangat tinggi/selalu/sangat lengkap</li>
                                                </ul>
                                                ')),
                                        ]),
                                    Radio::make('q_01')
                                        ->label('1. Saya memperoleh informasi yang cukup tentang hal-hal tertentu yang harus saya capai atau kuasai (luaran matakuliah) sesudah mengikuti matakuliah ini')
                                        ->options([
                                            1 => "1",
                                            2 => "2",
                                            3 => "3",
                                            4 => "4",
                                        ])
                                        ->inline()
                                        ->required()
                                        ->validationMessages([
                                            'required' => 'Saudara perlu memberi nilai terlebih dahulu',
                                        ])
                                        ->inlineLabel(false),
                                ]),
                            Wizard\Step::make('2')
                                ->label(' ')
                                ->completedIcon('heroicon-m-check-circle')
                                ->schema([
                                    Radio::make('q_02')
                                        ->label('2. Pelaksanaan perkuliahan diarahkan agar mahasiswa dapat mencapai atau menguasai luaran matakuliah ini.')
                                        ->options([
                                            1 => "1",
                                            2 => "2",
                                            3 => "3",
                                            4 => "4",
                                        ])
                                        ->inline()
                                        ->required()
                                        ->validationMessages([
                                            'required' => 'Saudara perlu memberi nilai terlebih dahulu',
                                        ])
                                        ->inlineLabel(false),
                                ]),
                            Wizard\Step::make('3')
                                ->label(' ')
                                ->completedIcon('heroicon-m-check-circle')
                                ->schema([
                                    Radio::make('q_03')
                                        ->label('3. Saya mencapai atau menguasai luaran matakuliah ini.')
                                        ->options([
                                            1 => "1",
                                            2 => "2",
                                            3 => "3",
                                            4 => "4",
                                        ])
                                        ->inline()
                                        ->required()
                                        ->validationMessages([
                                            'required' => 'Saudara perlu memberi nilai terlebih dahulu',
                                        ])
                                        ->inlineLabel(false),
                                ]),
                            Wizard\Step::make('4')
                                ->label(' ')
                                ->completedIcon('heroicon-m-check-circle')
                                ->schema([
                                    Radio::make('q_04')
                                        ->label('4. Pelaksanaan perkuliahan terorganisir dengan baik.')
                                        ->options([
                                            1 => "1",
                                            2 => "2",
                                            3 => "3",
                                            4 => "4",
                                        ])
                                        ->inline()
                                        ->required()
                                        ->validationMessages([
                                            'required' => 'Saudara perlu memberi nilai terlebih dahulu',
                                        ])
                                        ->inlineLabel(false),
                                ]),
                            Wizard\Step::make('5')
                                ->label(' ')
                                ->completedIcon('heroicon-m-check-circle')
                                ->schema([
                                    Radio::make('q_05')
                                        ->label('5. Dosen berkomunikasi dengan efektif.')
                                        ->options([
                                            1 => "1",
                                            2 => "2",
                                            3 => "3",
                                            4 => "4",
                                        ])
                                        ->inline()
                                        ->required()
                                        ->validationMessages([
                                            'required' => 'Saudara perlu memberi nilai terlebih dahulu',
                                        ])
                                        ->inlineLabel(false),
                                ]),
                            Wizard\Step::make('6')
                                ->label(' ')
                                ->completedIcon('heroicon-m-check-circle')
                                ->schema([
                                    Radio::make('q_06')
                                        ->label('6. Dosen peduli terhadap pencapaian atau penguasaan mahasiswa luaran matakuliah ini.')
                                        ->options([
                                            1 => "1",
                                            2 => "2",
                                            3 => "3",
                                            4 => "4",
                                        ])
                                        ->inline()
                                        ->required()
                                        ->validationMessages([
                                            'required' => 'Saudara perlu memberi nilai terlebih dahulu',
                                        ])
                                        ->inlineLabel(false),
                                ]),
                            Wizard\Step::make('7')
                                ->label(' ')
                                ->completedIcon('heroicon-m-check-circle')
                                ->schema([
                                    Radio::make('q_07')
                                        ->label('7. Dosen berlaku adil (fair) kepada mahasiswa.')
                                        ->options([
                                            1 => "1",
                                            2 => "2",
                                            3 => "3",
                                            4 => "4",
                                        ])
                                        ->inline()
                                        ->required()
                                        ->validationMessages([
                                            'required' => 'Saudara perlu memberi nilai terlebih dahulu',
                                        ])
                                        ->inlineLabel(false),
                                ]),
                            Wizard\Step::make('8')
                                ->label(' ')
                                ->completedIcon('heroicon-m-check-circle')
                                ->schema([
                                    Radio::make('q_08')
                                        ->label('8. Beban kerja untuk matakuliah ini sesuai dengan SKS-nya')
                                        ->hint(fn(M009PenilaianDosen $record) => "Matakuliah ini sejumlah " . ($record->kelas_mahasiswa->kelas->mata_kuliah->sks ?? null) . " SKS.")
                                        ->options([
                                            1 => "1",
                                            2 => "2",
                                            3 => "3",
                                            4 => "4",
                                        ])
                                        ->inline()
                                        ->required()
                                        ->validationMessages([
                                            'required' => 'Saudara perlu memberi nilai terlebih dahulu',
                                        ])
                                        ->inlineLabel(false),
                                ]),
                            Wizard\Step::make('9')
                                ->label(' ')
                                ->completedIcon('heroicon-m-check-circle')
                                ->schema([
                                    Radio::make('q_09')
                                        ->label('9. Sarana prasarana untuk matakuliah tersedia dengan memadai.')
                                        ->options([
                                            1 => "1",
                                            2 => "2",
                                            3 => "3",
                                            4 => "4",
                                        ])
                                        ->inline()
                                        ->required()
                                        ->validationMessages([
                                            'required' => 'Saudara perlu memberi nilai terlebih dahulu',
                                        ])
                                        ->inlineLabel(false),
                                ]),
                            Wizard\Step::make('10')
                                ->label(' ')
                                ->completedIcon('heroicon-m-check-circle')
                                ->schema([
                                    Radio::make('q_10')
                                        ->label('10. Tersedia cukup fasilitas pendukung di luar kuliah yang memungkinkan saya mengikuti matakuliah ini dengan baik.')
                                        ->options([
                                            1 => "1",
                                            2 => "2",
                                            3 => "3",
                                            4 => "4",
                                        ])
                                        ->inline()
                                        ->required()
                                        ->validationMessages([
                                            'required' => 'Saudara perlu memberi nilai terlebih dahulu',
                                        ])
                                        ->inlineLabel(false),
                                ]),
                            Wizard\Step::make('11')
                                ->label(' ')
                                ->completedIcon('heroicon-m-check-circle')
                                ->schema([
                                    Radio::make('q_11')
                                        ->label('11. Saya berusaha dengan sungguh-sungguh mengikuti matakuliah ini.')
                                        ->options([
                                            1 => "1",
                                            2 => "2",
                                            3 => "3",
                                            4 => "4",
                                        ])
                                        ->inline()
                                        ->required()
                                        ->validationMessages([
                                            'required' => 'Saudara perlu memberi nilai terlebih dahulu',
                                        ])
                                        ->inlineLabel(false),
                                ]),
                            Wizard\Step::make('12')
                                ->label(' ')
                                ->completedIcon('heroicon-m-check-circle')
                                ->schema([
                                    Radio::make('q_12')
                                        ->label('12. Saya memperoleh pengalaman belajar yang positif dalam matakuliah ini')
                                        ->options([
                                            1 => "1",
                                            2 => "2",
                                            3 => "3",
                                            4 => "4",
                                        ])
                                        ->inline()
                                        ->required()
                                        ->validationMessages([
                                            'required' => 'Saudara perlu memberi nilai terlebih dahulu',
                                        ])
                                        ->inlineLabel(false),
                                ]),
                            Wizard\Step::make('13')
                                ->label(' ')
                                ->completedIcon('heroicon-m-check-circle')
                                ->schema([
                                    Textarea::make('saran'),
                                    Hidden::make('is_done')->default(fn() => true),
                                ]),

                        ])->skippable()
                            ->submitAction(new HtmlString(Blade::render(<<<BLADE
                        <x-filament::button
                            type="submit"
                            size="sm"
                        >
                            Submit
                        </x-filament::button>
                    BLADE))),
                    ])
                    ->action(function (array $data, M009PenilaianDosen $record): void {
                        $record->q_01 = $data['q_01'];
                        $record->q_02 = $data['q_02'];
                        $record->q_03 = $data['q_03'];
                        $record->q_04 = $data['q_04'];
                        $record->q_05 = $data['q_05'];
                        $record->q_06 = $data['q_06'];
                        $record->q_07 = $data['q_07'];
                        $record->q_08 = $data['q_08'];
                        $record->q_09 = $data['q_09'];
                        $record->q_10 = $data['q_10'];
                        $record->q_11 = $data['q_11'];
                        $record->q_12 = $data['q_12'];
                        $record->saran = $data['saran'];
                        $record->is_done = true;
                        $record->save();
                    }),
            ]);
    }
}
