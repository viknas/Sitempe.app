<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RequestResource\Pages;
use App\Models\Request;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\HasManyRepeater;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Columns\TextColumn;
use Livewire\Component;

class RequestResource extends Resource
{
    protected static ?string $model = Request::class;
    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $label = 'Permintaan produk';
    protected static ?string $pluralLabel = 'Permintaan produk';
    protected static ?string $navigationGroup = 'Pencatatan Keuangan';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                Grid::make()->schema([
                    DatePicker::make('tanggal')
                        ->required(),
                    Select::make('status')
                        ->options([
                            'MENUNGGU KONFIRMASI' => 'Menunggu Konfirmasi',
                            'DIKONFIRMASI' => 'Dikonfirmasi',
                            'SELESAI' => 'Selesai',
                        ])
                        ->required()
                        ->default('MENUNGGU KONFIRMASI')
                        ->disabled(fn (Component $livewire): bool => $livewire instanceof Pages\CreateRequest),
                ]),
                HasManyRepeater::make('details')
                    ->relationship('details')
                    ->label('Detail')
                    ->schema([
                        Grid::make()->schema([
                            BelongsToSelect::make('id_produk')
                                ->label('Produk')
                                ->searchable()
                                ->relationship('product', 'nama_produk'),
                            TextInput::make('jumlah_produk')
                                ->numeric()
                                ->required(),
                            TextInput::make('harga')
                                ->numeric()
                                ->required()
                        ])->columns(3)
                    ])->minItems(1)
            ])->columnSpan(2),
            Card::make([
                Placeholder::make('created_at')
                    ->label('Dibuat')
                    ->content(fn (?Request $record): string => $record ? $record->created_at->diffForHumans() : '-'),
                Placeholder::make('updated_at')
                    ->label('Terakhir diubah')
                    ->content(fn (?Request $record): string => $record ? $record->updated_at->diffForHumans() : '-'),
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
                TextColumn::make('user.nama')
                    ->sortable()
                    ->searchable()
                    ->label('Reseller'),
                TextColumn::make('jumlah_produk')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('total_harga')
                    ->sortable()
                    ->searchable()
                    ->money('idr', true),
                TextColumn::make('tanggal')
                    ->sortable()
                    ->searchable()
                    ->date(),
                TextColumn::make('created_at')
                    ->sortable()
                    ->label('Dibuat')
                    ->dateTime(),
                TextColumn::make('updated_at')
                    ->sortable()
                    ->label('Terakhir diubah')
                    ->dateTime(),
            ])
            ->filters([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRequests::route('/'),
            'create' => Pages\CreateRequest::route('/create'),
            'edit' => Pages\EditRequest::route('/{record}/edit'),
        ];
    }
}
