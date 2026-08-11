<?php

namespace App\Filament\Widgets;

use App\Models\Pembayaran;
use App\Services\PropertiContext;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class PendapatanChart extends ChartWidget
{
    protected ?string $heading = 'Pendapatan 6 Bulan Terakhir';

    protected ?string $description = 'Grafik trend pendapatan pembayaran lunas';

    protected ?string $maxHeight = '300px';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $data = [];
        $labels = [];

        for ($i = 5; $i >= 0; $i--) {
            $bulan = Carbon::now()->subMonths($i);

            $labels[] = $bulan->format('M Y');

            $data[] = (float) Pembayaran::query()
                ->where('status', 'Lunas')
                ->whereMonth('tanggal_pembayaran', $bulan->month)
                ->whereYear('tanggal_pembayaran', $bulan->year)
                ->when(app(PropertiContext::class)->currentId(), fn ($q, $id) => $q->whereHas('sewa.kamar.tipeKamar', fn ($sq) => $sq->where('properti_id', $id))
                )
                ->sum('jumlah');
        }

        return [
            'datasets' => [
                [
                    'label' => 'Pendapatan',
                    'data' => $data,
                    'borderColor' => '#F5B731',           // Gold brand
                    'backgroundColor' => [
                        'rgba(245, 183, 49, 0.20)',               // Gradient fill start
                        'rgba(245, 183, 49, 0.12)',
                        'rgba(245, 183, 49, 0.06)',
                        'rgba(245, 183, 49, 0.02)',
                        'rgba(245, 183, 49, 0.00)',               // Gradient fill end
                    ],
                    'fill' => true,
                    'tension' => 0.4,
                    'pointRadius' => 5,
                    'pointHoverRadius' => 8,
                    'pointBackgroundColor' => '#F5B731',
                    'pointBorderColor' => '#FFFFFF',
                    'pointBorderWidth' => 2.5,
                    'pointHoverBorderWidth' => 3,
                    'borderWidth' => 2.5,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => ['display' => false],
                'tooltip' => [
                    'backgroundColor' => '#1E2A45',
                    'titleColor' => '#F5B731',
                    'bodyColor' => '#FFFFFF',
                    'borderColor' => 'rgba(245, 183, 49, 0.3)',
                    'borderWidth' => 1,
                    'cornerRadius' => 10,
                    'padding' => 12,
                    'displayColors' => false,
                ],
            ],
            'scales' => [
                'x' => [
                    'grid' => ['display' => false],
                    'ticks' => [
                        'font' => ['size' => 11, 'weight' => 500],
                    ],
                ],
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'font' => ['size' => 11],
                    ],
                    'grid' => [
                        'drawBorder' => false,
                        'color' => 'rgba(0, 0, 0, 0.04)',
                    ],
                ],
            ],
            'interaction' => [
                'intersect' => false,
                'mode' => 'index',
            ],
        ];
    }
}
