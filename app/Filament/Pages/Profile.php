<?php

namespace App\Filament\Pages;

use App\Models\District;
use App\Models\Regency;
use App\Models\User;
use Closure;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;
use RyanChandler\FilamentProfile\Pages\Profile as BaseProfile;

class Profile extends BaseProfile implements HasForms
{

    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    // protected static string $view = 'filament.pages.profile';
    protected static string $view = 'filament-profile::filament.pages.profile';
    protected static ?string $title = 'Profil';
    protected static ?string $slug = 'profile';

    protected static ?string $navigationGroup = 'Akun';

    public $nama;
    public $email;
    public $nomor_hp;
    public $alamat;
    public $foto_profil;


    public $current_password;
    public $new_password;
    public $new_password_confirmation;

    public function mount()
    {
        $this->form->fill([
            'nama' => auth()->user()->nama,
            'email' => auth()->user()->email,
            'nomor_hp' => auth()->user()->nomor_hp,
            'alamat' => auth()->user()->alamat,
            'foto_profil' => auth()->user()->foto_profil
        ]);
    }

    protected function getFormModel(): User
    {
        return auth()->user();
    }

    public function submit()
    {
        $this->form->getState();

        $state = array_filter([
            'nama' => $this->nama,
            'email' => $this->email,
            'nomor_hp' => $this->nomor_hp,
            'alamat' => $this->alamat,
            'foto_profil' => array_values($this->foto_profil)[0] ?? null,
            'password' => $this->new_password ? Hash::make($this->new_password) : null,
        ]);

        auth()->user()->update($state);

        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
        $this->notify('success', 'Profil anda berhasil diubah.');
    }

    public function getCancelButtonUrlProperty()
    {
        return static::getUrl();
    }

    protected function getBreadcrumbs(): array
    {
        return [
            url()->current() => 'Profil',
        ];
    }

    protected function getFormSchema(): array
    {

        return [
            Section::make('Umum')
                ->columns(2)
                ->schema([
                    FileUpload::make('foto_profil')
                        ->image()
                        ->avatar()
                        ->imageCropAspectRatio('1:1')
                        ->imageResizeTargetWidth('300')
                        ->imageResizeTargetHeight('300')
                        ->columnSpan(2)
                        ->imagePreviewHeight('300')
                        ->directory('accountImages'),
                    TextInput::make('nama')
                        ->required(),
                    TextInput::make('email')
                        ->label('Alamat Email')
                        ->required(),
                    TextInput::make('alamat')
                        ->label('Alamat'),
                    TextInput::make('nomor_hp')
                        ->label('No HP'),
                    BelongsToSelect::make('regency_id')
                        ->relationship(
                            'regency',
                            'name',
                            fn (Builder $query) =>
                            $query->where('province_id', '=', 35)
                        )
                        ->label('Kabupaten')
                        ->required()
                        ->reactive(),
                    BelongsToSelect::make('district_id')
                        ->relationship(
                            'district',
                            'name',
                            fn (Builder $query, Closure $get) =>
                            $query->where('regency_id', '=', $get('regency_id'))
                        )
                        ->label('Kecamatan')
                        ->required()
                        ->disabled(fn (Closure $get) => $get('regency_id') == null)
                ]),
            Section::make('Ubah Kata Sandi')
                ->columns(2)
                ->schema([
                    TextInput::make('current_password')
                        ->label('Password Sekarang')
                        ->password()
                        ->rules(['required_with:new_password'])
                        ->currentPassword()
                        ->autocomplete('off')
                        ->columnSpan(1),
                    Grid::make()
                        ->schema([
                            TextInput::make('new_password')
                                ->label('Password Baru')
                                ->password()
                                ->rules(['confirmed'])
                                ->autocomplete('new-password'),
                            TextInput::make('new_password_confirmation')
                                ->label('Verifikasi Password')
                                ->password()
                                ->rules([
                                    'required_with:new_password',
                                ])
                                ->autocomplete('new-password'),
                        ]),
                ]),
        ];
    }
}
