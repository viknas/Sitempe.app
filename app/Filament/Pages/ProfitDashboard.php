<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\ProfitChart;
use Filament\Pages\Page;

class ProfitDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $title = 'Grafik Keuntungan';
    protected static string $view = 'filament.pages.profit-dashboard';
    protected static ?string $navigationGroup = 'Pencatatan Keuangan';
    protected static ?string $slug = 'profit-dashboard';

    protected function getHeaderWidgets(): array
    {
        return [
            ProfitChart::class
        ];
    }
}
