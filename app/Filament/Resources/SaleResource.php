<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SaleResource\Pages;
use App\Filament\Resources\SaleResource\RelationManagers;
use App\Models\Product;
use App\Models\Sale;
use CanCalculateTotalProductInfo;
use Closure;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\HasManyRepeater;
use Filament\Forms\Components\Placeholder;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Columns\TextColumn;

class SaleResource extends Resource
{
    protected static ?string $model = Sale::class;
    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $label = 'Penjualan produk';
    protected static ?string $pluralLabel = 'Penjualan Produk';

    public $totalPrice;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    Grid::make()->schema([
                        DatePicker::make('tanggal')
                            ->required()
                            ->columnSpan(2)
                            ->default(now()),
                    ]),

                    HasManyRepeater::make('details')
                        ->relationship('details')
                        ->label('Detail')
                        ->schema([
                            Grid::make()->schema([
                                BelongsToSelect::make('id_produk')
                                    ->label('Produk')
                                    ->relationship('product', 'nama_produk')
                                    ->reactive()
                                    ->afterStateUpdated(function (Closure $set, $state) {
                                        $product = Product::find($state);
                                        $set('harga', $product['harga']);
                                    }),
                                TextInput::make('jumlah_produk')
                                    ->numeric()
                                    ->required()
                                    ->reactive()
                                    ->default(0),
                                TextInput::make('harga')
                                    ->numeric()
                                    ->required()
                            ])->columns(3)
                        ])->minItems(1)
                        ->createItemButtonLabel('Tambah produk')
                ])->columnSpan(2),
                Card::make([
                    Placeholder::make('created_at')
                        ->label('Dibuat')
                        ->content(fn (?Sale $record): string => $record ? $record->created_at->diffForHumans() : '-'),
                    Placeholder::make('updated_at')
                        ->label('Terakhir diubah')
                        ->content(fn (?Sale $record): string => $record ? $record->updated_at->diffForHumans() : '-'),
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
                TextColumn::make('jumlah_produk'),
                TextColumn::make('total_harga')->money('idr', true),
                TextColumn::make('tanggal')->date(),
                TextColumn::make('created_at')->label('Dibuat')
                    ->dateTime(),
                TextColumn::make('updated_at')->label('Terakhir diubah')
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
            'index' => Pages\ListSales::route('/'),
            'create' => Pages\CreateSale::route('/create'),
            'edit' => Pages\EditSale::route('/{record}/edit'),
        ];
    }
}
