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
                    'data' => $data->map(fn ($value) => $value->total_terjual),
                ],
            ],
            'labels' => $data->map(fn ($value) => $value->nama_produk),
        ];
    }
}
