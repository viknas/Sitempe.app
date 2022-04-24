<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Pendapatan hari ini', '13k'),
            Card::make('Pengeluaran hari ini', '13k'),
            Card::make('Pendapatan bulan ini ', '13k'),
            Card::make('Pengeluaran bulan ini', '13k'),
        ];
    }
}
