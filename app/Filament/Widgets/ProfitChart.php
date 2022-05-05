<?php

namespace App\Filament\Widgets;

use App\Models\Income;
use App\Models\Profit;
use App\Models\Sale;
use Filament\Widgets\LineChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class ProfitChart extends LineChartWidget
{
    protected int | string | array $columnSpan = 'full';

    public ?string $filter = 'month';

    protected function getFilters(): ?array
    {
        return [
            'month' => 'per Bulan',
            'year' => 'per Tahun',
        ];
    }


    private function determineTrend()
    {

        $query = Trend::model(Profit::class)
            ->between(now()->startOfYear(), end: now()->endOfYear())->dateColumn('tanggal');

        if ($this->filter == 'month') {
            return $query->perMonth()
                ->sum('keuntungan');
        } else if ($this->filter == 'year') {
            return $query->perYear()
                ->sum('keuntungan');
        }
    }

    protected function getData(): array
    {
        $data = $this->determineTrend();

        return [
            'datasets' => [
                [
                    'label' => 'Keuntungan',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }
}
