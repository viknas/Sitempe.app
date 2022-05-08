<?php

namespace App\Filament\Resources\RequestResource\Pages;

use App\Filament\Resources\RequestResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListRequests extends ListRecords
{
    protected static string $resource = RequestResource::class;

    protected function getTableQuery(): Builder
    {
        if (auth()->user()->isOwner()) {
            return parent::getTableQuery()->where('status', '!=', null);
        } else {
            return parent::getTableQuery()
            ->where('id_user', '=', auth()->user()->id)
            ->where('status', '!=', null);
        }
    }
}
