<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RequestDetailResource\RelationManagers\DetailsRelationManager;
use App\Filament\Resources\RequestResource\Pages;
use App\Filament\Resources\RequestResource\RelationManagers;
use App\Models\Request;
use App\Models\RequestDetail;
use Filament\Forms;
use Filament\Forms\Components\HasManyRepeater;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Livewire\Component;

class RequestResource extends Resource
{
    protected static ?string $model = Request::class;
    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $label = 'Permintaan produk';
    protected static ?string $pluralLabel = 'Permintaan produk';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\Grid::make()->schema([
                        Forms\Components\DatePicker::make('tanggal')
                            ->required(),
                        Forms\Components\Select::make('status')->options([
                            'MENUNGGU KONFIRMASI' => 'Menunggu Konfirmasi',
                            'DIKONFIRMASI' => 'Dikonfirmasi',
                            'SELESAI' => 'Selesai',
                        ])
                            ->required()->default('MENUNGGU KONFIRMASI')
                            ->disabled(fn (Component $livewire): bool => $livewire instanceof Pages\CreateRequest),
                    ]),
                    HasManyRepeater::make('details')
                        ->relationship('details')
                        ->label('Detail')
                        ->schema([
                            Forms\Components\Grid::make()->schema([
                                Forms\Components\BelongsToSelect::make('id_produk')->label('Produk')->searchable()
                                ->relationship('product', 'nama_produk'),
                                Forms\Components\TextInput::make('jumlah_produk')->numeric()->required(),
                                Forms\Components\TextInput::make('harga')->numeric()->required()
                            ])->columns(3)
                        ])->minItems(1)
                ])->columnSpan(2),
                Forms\Components\Card::make([
                    Forms\Components\Placeholder::make('created_at')
                        ->label('Dibuat')
                        ->content(fn (?Request $record): string => $record ? $record->created_at->diffForHumans() : '-'),
                    Forms\Components\Placeholder::make('updated_at')
                        ->label('Terakhir diubah')
                        ->content(fn (?Request $record): string => $record ? $record->updated_at->diffForHumans() : '-'),
                ])->columnSpan(1)

            ])->columns([
                'sm' => 3,
                'lg' => null,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.nama')->label('Admin'),
                Tables\Columns\TextColumn::make('tanggal')->date(),
                Tables\Columns\TextColumn::make('created_at')->label('Dibuat')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')->label('Terakhir diubah')
                    ->dateTime(),
            ])
            ->filters([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRequests::route('/'),
            'create' => Pages\CreateRequest::route('/create'),
            'edit' => Pages\EditRequest::route('/{record}/edit'),
        ];
    }
}
