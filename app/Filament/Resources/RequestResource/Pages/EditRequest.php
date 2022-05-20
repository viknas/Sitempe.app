<?php

namespace App\Filament\Resources\RequestResource\Pages;

use App\Filament\Resources\RequestResource;
use App\Models\Request;
use Filament\Pages\Actions\ButtonAction;
use Filament\Resources\Pages\EditRecord;

class EditRequest extends EditRecord
{
    protected static string $resource = RequestResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getActions(): array
    {
        return array_merge(parent::getActions(), [
            ButtonAction::make('cancel')
                ->action('cancel')
                ->label('Batalkan')
                ->requiresConfirmation()
                ->modalHeading('Batalkan pesanan')
                ->modalSubheading('Apakah anda yakin membatalkan pesanan ini?')
                ->modalButton('Ya')
                ->hidden(fn() : bool => $this->record->status != 'MENUNGGU KONFIRMASI' || auth()->user()->isOwner())
                ->color('danger'),
        ]);
    }

    public function cancel(): void
    {
        $this->record->status = 'DIBATALKAN';

        if ($this->record->save()) {
            $this->notify('success', 'Pesanan berhasil dibatalkan');
            redirect(route('filament.resources.requests.index'));
        } else {
            $this->notify('danger', 'Pesanan gagal dibatalkan');
        }


    }
}
