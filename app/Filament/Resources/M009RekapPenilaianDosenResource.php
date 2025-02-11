<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\M002Semester;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Blade;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\M009RekapPenilaianDosenResource\Pages;
use App\Filament\Resources\M009RekapPenilaianDosenResource\RelationManagers;
use App\Models\M009RekapPenilaianDosen;

class M009RekapPenilaianDosenResource extends Resource
{
    protected static ?string $model = M009RekapPenilaianDosen::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';

    protected static ?string $slug = 'rekap-penilaian-dosen';

    protected static ?string $modelLabel = 'Rekap Penilaian Dosen';

    protected static ?string $navigationLabel = 'Rekap Penilaian Dosen';

    protected static ?string $navigationGroup = 'Penilaian';

    //protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('tahun_ajaran.tahun')
                    ->label('Tahun Ajaran')
                    ->inlineLabel(),
                TextEntry::make('nama')
                    ->inlineLabel(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tahun_ajaran.tahun')
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kode')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                //Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('export')
                    ->color('primary')
                    ->icon('heroicon-o-document-arrow-down')
                    ->button()
                    ->action(
                        function (M009RekapPenilaianDosen $record) {
                            $semesterId = $record->id;

                            // Query untuk mengambil data penilaian berdasarkan semester
                            if (auth()->user()->hasRole('super_admin')) {
                                $query = "
                                SELECT 
                                    d.nama AS nama_dosen,
                                    mk.nama AS nama_mata_kuliah,
                                    k.nama AS nama_kelas,
                                    SUM(pd.q_01 + pd.q_02 + pd.q_03 + pd.q_04 + pd.q_05 + pd.q_06 + pd.q_07 + pd.q_08 + pd.q_09 + pd.q_10 + pd.q_11 + pd.q_12) AS total_nilai,
                                    COUNT(CASE WHEN pd.is_done = 1 THEN 1 END) AS jumlah_penilai,
                                    CASE 
                                        WHEN COUNT(CASE WHEN pd.is_done = 1 THEN 1 END) > 0 THEN 
                                            SUM(pd.q_01 + pd.q_02 + pd.q_03 + pd.q_04 + pd.q_05 + pd.q_06 + pd.q_07 + pd.q_08 + pd.q_09 + pd.q_10 + pd.q_11 + pd.q_12) / 
                                            COUNT(CASE WHEN pd.is_done = 1 THEN 1 END)
                                        ELSE 0
                                    END AS rata_rata
                                FROM m009_penilaian_dosens pd
                                JOIN m008_kelas_dosens kd ON kd.id = pd.kelas_dosen_id
                                JOIN m006_kelas k ON k.id = kd.kelas_id
                                JOIN m004_dosens d ON d.id = kd.dosen_id
                                JOIN m003_mata_kuliahs mk ON mk.id = k.mata_kuliah_id
                                WHERE k.semester_id = :semesterId
                                GROUP BY d.id, mk.id, k.id
                                ";
                            } else {
                                // Ambil ID prodi yang dimiliki user secara eksplisit menyebutkan nama tabel (untuk menghindari ambiguitas)
                                $userProdiIds = auth()->user()->prodi()->pluck('m010_prodis.id')->toArray();
    
                                // Pastikan array tidak kosong agar query valid
                                if (empty($userProdiIds)) {
                                    // Misalnya, jika user tidak punya prodi, kembalikan query kosong atau lakukan penanganan lain
                                    $userProdiIds = [0];
                                }
    
                                // Ubah array menjadi string, misalnya "1,2,3"
                                $prodiIdsString = implode(',', $userProdiIds);
    
                                $query = "
                                        SELECT 
                                            d.nama AS nama_dosen,
                                            mk.nama AS nama_mata_kuliah,
                                            k.nama AS nama_kelas,
                                            SUM(pd.q_01 + pd.q_02 + pd.q_03 + pd.q_04 + pd.q_05 + pd.q_06 + pd.q_07 + pd.q_08 + pd.q_09 + pd.q_10 + pd.q_11 + pd.q_12) AS total_nilai,
                                            COUNT(CASE WHEN pd.is_done = 1 THEN 1 END) AS jumlah_penilai,
                                            CASE 
                                                WHEN COUNT(CASE WHEN pd.is_done = 1 THEN 1 END) > 0 THEN 
                                                    SUM(pd.q_01 + pd.q_02 + pd.q_03 + pd.q_04 + pd.q_05 + pd.q_06 + pd.q_07 + pd.q_08 + pd.q_09 + pd.q_10 + pd.q_11 + pd.q_12) / 
                                                    COUNT(CASE WHEN pd.is_done = 1 THEN 1 END)
                                                ELSE 0
                                            END AS rata_rata
                                        FROM m009_penilaian_dosens pd
                                        JOIN m008_kelas_dosens kd ON kd.id = pd.kelas_dosen_id
                                        JOIN m006_kelas k ON k.id = kd.kelas_id
                                        JOIN m004_dosens d ON d.id = kd.dosen_id
                                        JOIN m003_mata_kuliahs mk ON mk.id = k.mata_kuliah_id
                                        JOIN m010_prodis p ON p.id = mk.prodi_id
                                        WHERE k.semester_id = :semesterId
                                        AND p.id IN ($prodiIdsString)
                                        GROUP BY d.id, mk.id, k.id
                                    ";
                            }


                            // Mengambil data berdasarkan semester
                            $data = DB::select($query, ['semesterId' => $semesterId]);

                            //Pdf::loadView('export.semester_export')->setPaper('a4', 'potrait')->download('invoice.pdf');//view('export.semester_export', ['data' => $data]);
                            return response()->streamDownload(function () use ($data, $record) {
                                echo Pdf::loadHtml(
                                    Blade::render('export.semester_export', [
                                        'data' => $data,
                                        'semester' => $record,
                                    ])
                                )->setPaper('a4', 'landscape')->stream();
                            }, "Penilaian Dosen Per Semester - " . $record->nama . " - " . date('Y-d-m') . '.pdf');
                        }
                    ),
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
            'index' => Pages\ManageM009RekapPenilaianDosens::route('/'),
        ];
    }
}
