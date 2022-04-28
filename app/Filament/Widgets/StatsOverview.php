<?php

namespace App\Filament\Widgets;

use Akaunting\Money\Money;
use App\Models\Expense;
use App\Models\Income;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    public string $todayIncome;
    public string $todayExpense;

    public function mount()
    {

        $todayIncome = Income::whereDate('tanggal', Carbon::now())
            ->selectRaw("SUM(total_harga) AS total_harga, DATE(tanggal) as date")
            ->groupBy('date')->get();

        $todayExpense = Expense::whereDate('tanggal', Carbon::now())
            ->selectRaw("SUM(jumlah_pengeluaran) AS jumlah_pengeluaran, DATE(tanggal) as date")
            ->groupBy('date')->get();

        $this->todayExpense = Money::IDR($todayExpense[0]['jumlah_pengeluaran']  ?? 0, true);
        $this->todayIncome = Money::IDR($todayIncome[0]['total_harga'] ?? 0, true);
    }

    protected function getCards(): array
    {
        return [
            Card::make('Pendapatan hari ini', $this->todayIncome),
            Card::make('Pengeluaran hari ini', $this->todayExpense),
        ];
    }
}
