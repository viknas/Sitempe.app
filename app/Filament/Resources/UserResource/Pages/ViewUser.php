<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Resources\Pages\Page;

class ViewUser extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $title = 'Informasi Reseller';
    protected static string $resource = UserResource::class;
    protected static string $view = 'filament.resources.user-resource.pages.view-user';

    public function mount($record)
    {
        $user = User::find($record);
        $this->form->fill([
            'nama' => $user->nama,
            'email' => $user->email,
            'nomor_hp' => $user->nomor_hp,
            'alamat' => $user->alamat,
            'kecamatan' => $user->district->kecamatan,
            'kabupaten' => $user->district->kecamatan,
            'foto_profil' => $user->district->foto_profil
        ]);
    }

    protected function getFormSchema(): array
    {
        return [
            Card::make()->schema([
                Grid::make()->schema([
                    FileUpload::make('foto_profil')
                        ->image()
                        ->avatar()
                        ->imageCropAspectRatio('1:1')
                        ->imageResizeTargetWidth('300')
                        ->imageResizeTargetHeight('300')
                        ->disabled()
                        ->columnSpan(2)
                        ->imagePreviewHeight('300')->directory('accountImages'),
                    TextInput::make('nama')->disabled(),
                    TextInput::make('email')->disabled(),
                    TextInput::make('alamat')->disabled(),
                    TextInput::make('nomor_hp')->disabled(),
                    TextInput::make('kecamatan')->disabled(),
                    TextInput::make('kabupaten')->disabled(),
                ]),

            ])->columnSpan(2),
        ];
    }
}
