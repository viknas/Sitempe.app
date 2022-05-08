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


    public function mount(): void
    {
        abort_unless(auth()->user()->isOwner(), 403);
    }

    protected static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->isOwner();
    }

    protected function getHeaderWidgets(): array
    {
        return [
            ProfitChart::class
        ];
    }
}
