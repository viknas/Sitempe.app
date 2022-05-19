<?php

namespace App\Filament\Resources\RequestResource\Pages;

use App\Filament\Resources\RequestResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRequest extends CreateRecord
{
    protected static string $resource = RequestResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['id_user'] = auth()->id();
        $data['tipe'] = 'DIPESAN';

        if (auth()->user()->isReseller()) {
            $data['status'] = 'MENUNGGU KONFIRMASI';
        }

        return $data;
    }
}
