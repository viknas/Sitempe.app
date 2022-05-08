<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\BestProductChart;
use Filament\Pages\Page;

class BestProduct extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $title = 'Produk terlaris';
    protected static ?int $navigationSort = 2;
    protected static string $view = 'filament.pages.best-product';
    protected static ?string $slug = 'best-product';

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
            BestProductChart::class
        ];
    }
}
