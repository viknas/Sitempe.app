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
    public User $user;

    public function mount(User $record)
    {
        $this->user = $record;

        $this->form->fill([
            'foto_profil' => $this->user->foto_profil
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
                    Placeholder::make('Nama')->content($this->user->nama),
                    Placeholder::make('Email')->content($this->user->email),
                    Placeholder::make('Alamat')->content($this->user->alamat ?? '-'),
                    Placeholder::make('Nomor HP')->label('Nomor HP')->content($this->user->nomor_hp ?? '-'),
                    Placeholder::make('Kabupaten')->content($this->user->regency->name),
                    Placeholder::make('Kecamatan')->content($this->user->district->name),
                ]),

            ])->columnSpan(2),
        ];
    }
}
