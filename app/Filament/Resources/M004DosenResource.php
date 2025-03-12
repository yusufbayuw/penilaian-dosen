<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\M004Dosen;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\M004DosenResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\M004DosenResource\RelationManagers;

class M004DosenResource extends Resource
{
    protected static ?string $model = M004Dosen::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static ?string $slug = 'dosen';

    protected static ?string $modelLabel = 'Dosen';

    protected static ?string $navigationLabel = 'Dosen';
    
    protected static ?string $navigationGroup = 'Master Data';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nidn')
                    ->required()
                    ->label("NIDN")
                    ->unique(ignoreRecord:true),
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
                Tables\Columns\TextColumn::make('nidn')
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
            ])
            ->headerActions([
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

                        if ($participants) {
                            foreach ($participants as $key => $participant) {
                                M004Dosen::create([
                                    "nidn" => $participant["nidn"],
                                    "nama" => $participant["nama"],
                                    "aktif" => true,
                                ]);
                            }
                        } else {
                            Notification::make('gagal')
                                    ->title('Import Data Gagal')
                                    ->body('Pastikan format file benar (.csv) dan format kolom benar')
                                    ->danger()
                                    ->send();
                        }

                    })
                    ->color('success'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageM004Dosens::route('/'),
        ];
    }
}
