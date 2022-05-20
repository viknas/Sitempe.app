<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RequestResource\Pages;
use App\Models\Product;
use App\Models\Request;
use Closure;
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
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Livewire\Component;

class RequestResource extends Resource
{
    protected static ?string $model = Request::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $label = 'Permintaan produk';
    protected static ?string $pluralLabel = 'Permintaan produk';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                Grid::make()->schema([
                    DatePicker::make('tanggal')
                        ->default(now())
                        ->maxDate(now())
                        ->disabled(self::authorizeAction())
                        ->required(),
                    Select::make('status')
                        ->options([
                            'DIBATALKAN' => 'Dibatalkan',
                            'MENUNGGU KONFIRMASI' => 'Menunggu Konfirmasi',
                            'SELESAI' => 'Selesai',
                        ])
                        ->required()
                        ->default('MENUNGGU KONFIRMASI')
                        ->disabled(fn (Closure $get): bool => $get('status') == 'SELESAI' || $get('status') == 'DIBATALKAN')
                        ->hidden(fn (): bool => auth()->user()->isReseller()),
                ]),
                HasManyRepeater::make('details')
                    ->disabled(self::authorizeAction())
                    ->relationship('details')
                    ->createItemButtonLabel('Tambah Produk')
                    ->disableItemCreation(self::authorizeAction())
                    ->disableItemDeletion(self::authorizeAction())
                    ->schema([
                        Grid::make()->schema([
                            BelongsToSelect::make('id_produk')
                                ->label('Produk')
                                ->reactive()
                                ->afterStateUpdated(function (Closure $set, Closure $get, $state) {
                                    if ($get('id_produk') != null) {
                                        $product = Product::find($state);
                                        $set('harga', $product['harga']);
                                    }
                                })
                                ->relationship('product', 'nama_produk'),
                            TextInput::make('jumlah_produk')
                                ->numeric()
                                ->required()
                                ->rules([function (Closure $get) {
                                    return function (string $attribute, $value, Closure $fail) use ($get) {
                                        $product_id = $get('id_produk');
                                        $stock = Product::find($product_id)->stok;
                                        if ($value > $stock) {
                                            $fail('Jumlah produk melebihi stok');
                                        }
                                    };
                                }])
                                ->minValue(1)
                                ->default(1),
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
                    ->hidden(fn (): bool => auth()->user()->isReseller())
                    ->label('Reseller'),
                BadgeColumn::make('status')
                    ->enum([
                        'DIBATALKAN' => 'Dibatalkan',
                        'MENUNGGU KONFIRMASI' => 'Menunggu Konfirmasi',
                        'SELESAI' => 'Selesai',
                    ])
                    ->colors([
                        'danger' => 'DIBATALKAN',
                        'warning' => 'MENUNGGU KONFIRMASI',
                        'success' => 'SELESAI',
                    ]),
                TextColumn::make('total_produk'),
                TextColumn::make('total_harga')
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
                SelectFilter::make('status')->options([
                    'MENUNGGU KONFIRMASI' => 'Menunggu Konfirmasi',
                    'SELESAI' => 'Selesai'
                ])
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
            'view' => Pages\ViewRequest::route('/{record}'),
        ];
    }

    public static function authorizeAction()
    {
        return function (Component $livewire, Closure $get): bool {
            if (auth()->user()->isReseller()) {
                if ($livewire instanceof Pages\EditRequest) {
                    return $get('status') == 'SELESAI' || $get('status') == 'DIBATALKAN';
                }
                return false;
            } else {
                return true;
            }
        };
    }
}
