<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $label = 'Produk';
    protected static ?string $pluralLabel = 'Produk';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    Grid::make()->schema([
                        TextInput::make('nama_produk')
                            ->required()
                            ->maxLength(40),
                        TextInput::make('harga')
                            ->required()
                            ->numeric(),
                        Textarea::make('deskripsi')
                            ->maxLength(65535),
                        TextInput::make('stok')
                            ->required()
                            ->numeric(),
                        FileUpload::make('foto_produk')
                            ->image()
                            ->required()
                            ->columnSpan(2)
                            ->imagePreviewHeight('300')
                            ->directory('productImages'),
                    ])
                ])->columnSpan(2),
                Card::make([
                    Placeholder::make('created_at')
                        ->label('Dibuat')
                        ->content(fn (?Product $record): string => $record ? $record->created_at->diffForHumans() : '-'),
                    Placeholder::make('updated_at')
                        ->label('Terakhir diubah')
                        ->content(fn (?Product $record): string => $record ? $record->updated_at->diffForHumans() : '-'),
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
                ImageColumn::make('foto_produk')
                    ->height(200),
                TextColumn::make('nama_produk')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('harga')
                    ->sortable()
                    ->searchable()
                    ->money('idr', true),
                TextColumn::make('deskripsi')
                    ->searchable(),
                TextColumn::make('stok')
                    ->searchable()
                    ->sortable(),
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
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
