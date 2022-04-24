<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Livewire\Component;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Akun';
    protected static ?string $label = 'Reseller';
    protected static ?string $pluralLabel = 'Reseller';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\Grid::make()->schema([
                        Forms\Components\FileUpload::make('foto_profil')
                            ->image()
                            ->avatar()
                            ->imageCropAspectRatio('1:1')
                            ->imageResizeTargetWidth('300')
                            ->imageResizeTargetHeight('300')
                            ->required()->columnSpan(2)
                            ->imagePreviewHeight('300')->directory('accountImages'),
                        Forms\Components\TextInput::make('nama')
                            ->required(),
                        Forms\Components\TextInput::make('email')
                            ->required(),
                        Forms\Components\TextInput::make('alamat'),
                        Forms\Components\TextInput::make('nomor_hp')
                            ->tel(),
                        Forms\Components\BelongsToSelect::make('id_kecamatan')
                            ->relationship('district', 'kecamatan')
                            ->searchable()
                            ->required(),
                        Forms\Components\BelongsToSelect::make('id_kabupaten')
                            ->relationship('regency', 'kabupaten')
                            ->searchable()
                            ->required(),

                        Forms\Components\TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->rules(['confirmed'])
                            ->columnSpan(2)
                            ->hidden(fn (Component $livewire): bool => $livewire instanceof Pages\EditUser),
                        Forms\Components\TextInput::make('password_confirmation')
                            ->label('Verifikasi Password')
                            ->password()
                            ->rules([
                                'required_with:password',
                            ])->columnSpan(2)
                            ->hidden(fn (Component $livewire): bool => $livewire instanceof Pages\EditUser),
                    ]),

                    Forms\Components\Section::make('Ubah Kata Sandi')
                        ->columns(2)
                        ->schema([
                            Forms\Components\TextInput::make('current_password')
                                ->label('Password Sekarang')
                                ->password()
                                ->rules(['required_with:password'])
                                ->currentPassword()
                                ->autocomplete('off')
                                ->columnSpan(1),
                            Forms\Components\Grid::make()
                                ->schema([
                                    Forms\Components\TextInput::make('password')
                                        ->label('Password Baru')
                                        ->password()
                                        ->rules(['confirmed'])
                                        ->autocomplete('new-password'),
                                    Forms\Components\TextInput::make('password_confirmation')
                                        ->label('Verifikasi Password')
                                        ->password()
                                        ->rules([
                                            'required_with:password',
                                        ])
                                        ->autocomplete('new-password'),
                                ]),
                        ]),
                ])->columnSpan(2),
                Forms\Components\Card::make([
                    Forms\Components\Placeholder::make('created_at')
                        ->label('Dibuat')
                        ->content(fn (?User $record): string => $record ? $record->created_at->diffForHumans() : '-'),
                    Forms\Components\Placeholder::make('updated_at')
                        ->label('Terakhir diubah')
                        ->content(fn (?User $record): string => $record ? $record->updated_at->diffForHumans() : '-'),
                ])->columnSpan(1)

            ])->columns([
                'sm' => 3,
                'lg' => null,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama'),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('nomor_hp'),
                Tables\Columns\ImageColumn::make('foto_profil')->rounded(),
                Tables\Columns\TextColumn::make('district.kecamatan')->label('Kecamatan'),
                Tables\Columns\TextColumn::make('regency.kabupaten')->label('Kabupaten'),
                Tables\Columns\TextColumn::make('created_at')->label('Dibuat')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')->label('Terakhir diubah')
                    ->dateTime(),
            ])
            ->filters([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
