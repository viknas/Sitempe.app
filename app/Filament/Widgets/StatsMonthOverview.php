<?php

namespace App\Filament\Widgets;

use Akaunting\Money\Money;
use App\Models\Expense;
use App\Models\Income;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsMonthOverview extends BaseWidget
{
    public string $monthIncome;
    public string $monthExpense;

    public function mount()
    {
        $startOfMonth = Carbon::now()->startOfMonth()->format('Y-m-d');
        $endOfMonth = Carbon::now()->endOfMonth()->format('Y-m-d');

        $monthIncome = Income::whereBetween('tanggal', [$startOfMonth, $endOfMonth])
            ->selectRaw("SUM(total_harga) AS total_harga, MONTH(tanggal) as date")
            ->groupBy('date')->get();

        $monthExpense = Expense::whereBetween('tanggal', [$startOfMonth, $endOfMonth])
            ->selectRaw("SUM(jumlah_pengeluaran) AS jumlah_pengeluaran, MONTH(tanggal) as date")
            ->groupBy('date')->get();

        $this->monthExpense = Money::IDR($monthExpense[0]['jumlah_pengeluaran']  ?? 0, true);
        $this->monthIncome = Money::IDR($monthIncome[0]['total_harga'] ?? 0, true);
    }

    protected function getCards(): array
    {
        return [
            Card::make('Pendapatan bulan ini', $this->monthIncome),
            Card::make('Pengeluaran bulan ini', $this->monthExpense),
        ];
    }
}
