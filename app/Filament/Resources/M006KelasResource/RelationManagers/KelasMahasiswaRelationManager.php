<?php

namespace App\Filament\Resources\M006KelasResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\M005Mahasiswa;
use App\Models\M007KelasMahasiswa;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

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
                Tables\Actions\Action::make('import')
                    ->icon('heroicon-o-arrow-up-tray')
                    ->form([
                        Forms\Components\FileUpload::make('file')
                            ->disk('public')
                            ->directory('temp_upload')
                            ->label('Upload CSV File')
                            ->hint('Format Upload CSV tersedia di menu Template')
                            ->required()
                            ->acceptedFileTypes(['text/csv', 'text/plain', 'application/vnd.ms-excel'])
                            ->storeFiles(true),
                    ])
                    ->action(function (array $data) {
                        $file = $data['file'];
                        $filePath = public_path("storage/{$file}");

                        // Read the CSV file
                        $rows = array_map('str_getcsv', file($filePath));
                        $header = array_shift($rows);

                        // Convert rows to associative arrays
                        $participants = array_map(function ($row) use ($header) {
                            return array_combine($header, $row);
                        }, $rows);

                        // Get the owner certificate ID
                        $kelasId = $this->ownerRecord->id;

                        if ($participants) {
                            foreach ($participants as $key => $participant) {
                                $mahasiswa = M005Mahasiswa::where('npm', $participant['npm'])->first();
                                if ($mahasiswa) {
                                    if (M007KelasMahasiswa::where('kelas_id', $kelasId)->where('mahasiswa_id', $mahasiswa->id)->first()) {
                                        Notification::make('sudah_ada')
                                            ->title('NPM ' . $participant["npm"] . ' sudah terdaftar')
                                            ->body('Data NPM (' . $participant["npm"] . ') baris CSV ke-' . ($key + 1) . ' sudah terdaftar di kelas.')
                                            ->danger()
                                            ->send();
                                    } else {
                                        M007KelasMahasiswa::create([
                                            'kelas_id' => $kelasId,
                                            'mahasiswa_id' => $mahasiswa->id,
                                        ]);
                                    }
                                } else {
                                    Notification::make('tidak_ditemukan')
                                        ->title('NPM ' . $participant["npm"] . ' tidak ditemukan')
                                        ->body('Data NPM (' . $participant["npm"] . ') baris CSV ke-' . ($key + 1) . ' tidak ditemukan pada data mahasiswa.')
                                        ->danger()
                                        ->send();
                                }
                            }
                        } else {
                            Notification::make('gagal')
                                    ->title('Import Data Gagal')
                                    ->body('Pastikan format file benar (.csv) dan format kolom benar')
                                    ->danger()
                                    ->send();
                        }
                        // Insert participants with certificate_id

                    })
                    ->color('success'),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('upload')
                        ->label('Template Upload')
                        ->icon('heroicon-m-document-arrow-down')
                        ->url(url('storage/upload_kelas_mahasiswa.csv')) // Generate the URL to the file
                        ->openUrlInNewTab(), // Optionally, open in a new tab
                ])
                    ->label('Template')
                    ->icon('heroicon-m-ellipsis-vertical')
                    ->color('danger')
                    ->button(),
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
