<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExpenseResource\Pages;
use App\Filament\Resources\ExpenseResource\RelationManagers;
use App\Models\Expense;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

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
                Forms\Components\Card::make()->schema([
                    Forms\Components\Grid::make()->schema([
                        Forms\Components\DatePicker::make('tanggal')
                            ->required()->default(now()),
                        Forms\Components\TextInput::make('jumlah_pengeluaran')
                            ->required()->numeric()->mask(fn (TextInput\Mask $mask) => $mask
                                ->numeric()
                                ->integer()
                                ->minValue(1)
                                ->thousandsSeparator('.'),),
                        Forms\Components\Textarea::make('keterangan')
                            ->maxLength(65535)->columnSpan(2),
                    ])
                ])->columnSpan(2),
                Forms\Components\Card::make([
                    Forms\Components\Placeholder::make('created_at')
                        ->label('Dibuat')
                        ->content(fn (?Expense $record): string => $record ? $record->created_at->diffForHumans() : '-'),
                    Forms\Components\Placeholder::make('updated_at')
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
                Tables\Columns\TextColumn::make('tanggal')->date(),
                Tables\Columns\TextColumn::make('jumlah_pengeluaran')->money('idr', true),
                Tables\Columns\TextColumn::make('keterangan')->limit(),
                Tables\Columns\TextColumn::make('user.nama')->label('Admin'),
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
