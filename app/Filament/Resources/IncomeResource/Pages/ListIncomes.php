<?php

namespace App\Filament\Resources\IncomeResource\Pages;

use App\Filament\Resources\IncomeResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListIncomes extends ListRecords
{
    protected static string $resource = IncomeResource::class;

    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()->where('tipe', '=', 'LANGSUNG')->orWhere('status', '=', 'DIKONFIRMASI');
    }
}
