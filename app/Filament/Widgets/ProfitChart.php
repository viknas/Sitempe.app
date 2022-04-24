<?php

namespace App\Filament\Widgets;

use App\Models\Income;
use Filament\Widgets\LineChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class ProfitChart extends LineChartWidget
{
    protected int | string | array $columnSpan = 'full';

    public ?string $filter = 'today';

    protected function getFilters(): ?array
    {
        return [
            'today' => 'Hari ini',
            'week' => 'Minggu ini',
            'month' => 'Bulan ini',
            'year' => 'Tahun ini',
        ];
    }


    private function determineDate()
    {
        if ($this->filter == 'today') {
            return [now()->startOfDay(), now()->endOfDay()];
        } else if ($this->filter == 'week') {
            return [now()->startOfWeek(), now()->endOfWeek()];
        } else if ($this->filter == 'month') {
            return [now()->startOfMonth(), now()->endOfMonth()];
        } else if ($this->filter == 'year') {
            return [now()->startOfYear(), now()->endOfYear()];
        }
    }

    private function determineTrend()
    {

        $date = $this->determineDate();
        $data = null;

        if ($this->filter == 'today') {
            return $data = Trend::model(Income::class)
                ->between(start: $date[0], end: $date[1])
                ->perHour()
                ->sum('harga');
        } else if ($this->filter == 'week') {
            return  $data = Trend::model(Income::class)
                ->between(start: $date[0], end: $date[1])
                ->perDay()
                ->sum('harga');
        } else if ($this->filter == 'month') {
            return  $data = Trend::model(Income::class)
                ->between(start: $date[0], end: $date[1])
                ->perMonth()
                ->sum('harga');
        } else if ($this->filter == 'year') {
            return  $data = Trend::model(Income::class)
                ->between(start: $date[0], end: $date[1])
                ->perYear()
                ->sum('harga');
        }

        return $data;
    }

    protected function getData(): array
    {
        $data = $this->determineTrend();

        return [
            'datasets' => [
                [
                    'label' => 'Pendapatan',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }
}
