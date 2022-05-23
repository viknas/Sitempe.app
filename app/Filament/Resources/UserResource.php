<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
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

                Card::make()->schema([
                    Grid::make()->schema([
                        FileUpload::make('foto_profil')
                            ->image()
                            ->avatar()
                            ->imageCropAspectRatio('1:1')
                            ->imageResizeTargetWidth('300')
                            ->imageResizeTargetHeight('300')
                            ->required()->columnSpan(2)
                            ->imagePreviewHeight('300')->directory('accountImages'),
                        TextInput::make('nama')
                            ->required(),
                        TextInput::make('email')
                            ->required(),
                        TextInput::make('alamat'),
                        TextInput::make('nomor_hp')
                            ->tel(),
                        BelongsToSelect::make('regency_id')
                            ->label('Kabupaten')
                            ->relationship('regency', 'name')
                            ->searchable()
                            ->required(),
                        BelongsToSelect::make('district_id')
                            ->label('Kecamatan')
                            ->relationship('district', 'name')
                            ->searchable()
                            ->required(),
                        TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->rules(['confirmed'])
                            ->columnSpan(2),
                        TextInput::make('password_confirmation')
                            ->label('Verifikasi Password')
                            ->password()
                            ->rules([
                                'required_with:password',
                            ])->columnSpan(2)
                    ]),
                    Section::make('Ubah Kata Sandi')
                        ->columns(2)
                        ->schema([
                            TextInput::make('current_password')
                                ->label('Password Sekarang')
                                ->password()
                                ->rules(['required_with:password'])
                                ->currentPassword()
                                ->autocomplete('off')
                                ->columnSpan(1),
                            Grid::make()
                                ->schema([
                                    TextInput::make('password')
                                        ->label('Password Baru')
                                        ->password()
                                        ->rules(['confirmed'])
                                        ->autocomplete('new-password'),
                                    TextInput::make('password_confirmation')
                                        ->label('Verifikasi Password')
                                        ->password()
                                        ->rules([
                                            'required_with:password',
                                        ])
                                        ->autocomplete('new-password'),
                                ]),
                        ]),
                ])->columnSpan(2),
                Card::make([
                    Placeholder::make('created_at')
                        ->label('Dibuat')
                        ->content(fn (?User $record): string => $record ? $record->created_at->diffForHumans() : '-'),
                    Placeholder::make('updated_at')
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
                TextColumn::make('nama')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('email')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('nomor_hp')
                    ->searchable(),
                ImageColumn::make('foto_profil')
                    ->rounded(),
                TextColumn::make('regency.name')
                    ->sortable()
                    ->searchable()
                    ->label('Kabupaten'),
                TextColumn::make('district.name')
                    ->sortable()
                    ->searchable()
                    ->label('Kecamatan'),
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
            'view' => Pages\ViewUser::route('/{record}')
        ];
    }
}
