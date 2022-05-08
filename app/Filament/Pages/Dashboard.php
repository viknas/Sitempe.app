<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\StatsMonthOverview;
use App\Filament\Widgets\StatsOverview;
use Filament\Pages\Page;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $title = 'Dasbor';
    protected static ?string $slug = 'dashboard';
    protected static string $view = 'filament.pages.dashboard';
    protected static ?int $navigationSort = 1;

    protected function getHeaderWidgets(): array
    {
        return [
            StatsOverview::class,
            StatsMonthOverview::class
        ];
    }
}
