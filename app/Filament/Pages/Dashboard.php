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
            StatsOverview::class,
            StatsMonthOverview::class
        ];
    }
}
