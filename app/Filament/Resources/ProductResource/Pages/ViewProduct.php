<?php

namespace App\Filament\Resources\ProductResource\Pages;

use Akaunting\Money\Money;
use App\Filament\Resources\ProductResource;
use App\Models\Product;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\Page;

class ViewProduct extends Page
{
    protected static string $resource = ProductResource::class;
    protected static ?string $title = 'Informasi Produk';
    protected static string $view = 'filament.resources.product-resource.pages.view-product';

    public $product;

    public function mount(Product $record)
    {
        $this->product = $record;

        $this->form->fill([
            'foto_produk' => $this->product->foto_produk
        ]);
    }

    protected function getFormSchema(): array
    {
        return [
            Card::make()->schema([
                Grid::make()->schema([
                    Placeholder::make('nama_produk')
                        ->content($this->product->nama_produk),
                    Placeholder::make('harga')
                        ->content(Money::IDR($this->product->harga, true)),
                    Placeholder::make('deskripsi')
                        ->content($this->product->deskripsi),
                    Placeholder::make('stok')
                        ->content($this->product->stok),
                    FileUpload::make('foto_produk')
                        ->image()
                        ->disabled()
                        ->columnSpan(2)
                        ->imagePreviewHeight('300')
                        ->directory('productImages'),
                ]),

            ])->columnSpan(2),
        ];
    }
}
