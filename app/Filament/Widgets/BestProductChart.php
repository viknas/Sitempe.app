<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Widgets\BarChartWidget;

class BestProductChart extends BarChartWidget
{
    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {

        $data = Product::all();

        return [
            'datasets' => [
                [
                    'label' => 'Terjual',
                    'data' => $data->map(fn (Product $product) => $product->soldPerMonth()),
                    'backgroundColor' => 'rgba(245, 158, 11, 0.5)'
                ],
            ],
            'labels' => $data->map(fn (Product $product) => $product->nama_produk),
        ];
    }
}
