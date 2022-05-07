<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExpenseResource\Pages;
use App\Filament\Resources\ExpenseResource\RelationManagers;
use App\Models\Expense;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

class ExpenseResource extends Resource
{
    protected static ?string $model = Expense::class;
    protected static ?string $label = 'Pengeluaran';
    protected static ?string $pluralLabel = 'Pengeluaran';
    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $navigationGroup = 'Pencatatan Keuangan';
    // protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    Grid::make()->schema([
                        DatePicker::make('tanggal')
                            ->required()
                            ->maxDate(now())
                            ->default(now()),
                        TextInput::make('jumlah_pengeluaran')
                            ->required()
                            ->numeric()
                            ->mask(fn (TextInput\Mask $mask) => $mask
                                ->numeric()
                                ->integer()
                                ->minValue(1)
                                ->thousandsSeparator('.'),),
                        Textarea::make('keterangan')
                            ->maxLength(65535)
                            ->columnSpan(2),
                    ])
                ])->columnSpan(2),
                Card::make([
                    Placeholder::make('created_at')
                        ->label('Dibuat')
                        ->content(fn (?Expense $record): string => $record ? $record->created_at->diffForHumans() : '-'),
                    Placeholder::make('updated_at')
                        ->label('Terakhir diubah')
                        ->content(fn (?Expense $record): string => $record ? $record->updated_at->diffForHumans() : '-'),
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
                TextColumn::make('tanggal')
                    ->sortable()
                    ->searchable()
                    ->date(),
                TextColumn::make('jumlah_pengeluaran')
                    ->sortable()
                    ->searchable()
                    ->money('idr', true),
                TextColumn::make('keterangan')
                    ->searchable()
                    ->limit(),
                TextColumn::make('user.nama')
                    ->sortable()
                    ->searchable()
                    ->label('Admin'),
                TextColumn::make('created_at')
                    ->sortable()
                    ->label('Dibuat')
                    ->dateTime(),
                TextColumn::make('updated_at')
                    ->sortable()
                    ->label('Terakhir diubah')
                    ->dateTime(),
            ])
            ->filters([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExpenses::route('/'),
            'create' => Pages\CreateExpense::route('/create'),
            'edit' => Pages\EditExpense::route('/{record}/edit'),
        ];
    }
}
