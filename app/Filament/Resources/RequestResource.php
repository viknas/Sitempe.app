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
                        ->default(now())
                        ->maxDate(now())
                        ->required(),
                    Select::make('status')
                        ->options([
                            'MENUNGGU KONFIRMASI' => 'Menunggu Konfirmasi',
                            'SELESAI' => 'Selesai',
                        ])
                        ->required()
                        ->default('MENUNGGU KONFIRMASI')
                        ->disabled(fn (Component $livewire): bool => $livewire instanceof Pages\CreateRequest)
                        ->hidden(fn (): bool => auth()->user()->isReseller()),
                ]),
                HasManyRepeater::make('details')
                    ->relationship('details')
                    ->createItemButtonLabel('Tambah Produk')
                    ->schema([
                        Grid::make()->schema([
                            BelongsToSelect::make('id_produk')
                                ->label('Produk')
                                ->reactive()
                                ->afterStateUpdated(function (Closure $set, $state) {
                                    $product = Product::find($state);
                                    $set('harga', $product['harga']);
                                })
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
                    ->hidden(fn (): bool => auth()->user()->isReseller())
                    ->label('Reseller'),
                BadgeColumn::make('status')
                    ->enum([
                        'MENUNGGU KONFIRMASI' => 'Menunggu Konfirmasi',
                        'SELESAI' => 'Selesai',
                    ])
                    ->colors([
                        'warning' => 'MENUNGGU KONFIRMASI',
                        'success' => 'SELESAI',
                    ]),
                TextColumn::make('total_produk')
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
