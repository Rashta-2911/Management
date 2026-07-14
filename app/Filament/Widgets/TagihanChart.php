<?php

namespace App\Filament\Widgets;

use App\Models\Tagihan;
use Filament\Widgets\ChartWidget;

class TagihanChart extends ChartWidget
{
    protected ?string $heading = 'Status Tagihan';
    protected ?string $description = 'Distribusi status seluruh tagihan';
    protected ?string $maxHeight = '300px';
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $lunas      = Tagihan::where('status', '=', 'Lunas', 'and')->count();
        $belumLunas = Tagihan::where('status', '=', 'Belum lunas', 'and')->count();
        $terlambat  = Tagihan::where('status', '=', 'Terlambat', 'and')->count();

        return [
            'datasets' => [
                [
                    'label'           => 'Jumlah Tagihan',
                    'data'            => [$lunas, $belumLunas, $terlambat],
                    'backgroundColor' => [
                        '#F5B731',  // Gold — Lunas
                        '#1E2A45',  // Navy — Belum Lunas
                        '#A0522D',  // Brick — Terlambat
                    ],
                    'hoverBackgroundColor' => [
                        '#D9A229',  // Darker Gold
                        '#2A3A5C',  // Lighter Navy
                        '#8B4726',  // Darker Brick
                    ],
                    'borderWidth'     => 0,
                    'borderRadius'    => 8,
                    'borderSkipped'   => false,
                ],
            ],
            'labels' => ['Lunas', 'Belum Lunas', 'Terlambat'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
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
                    'displayColors' => true,
                    'callbacks' => [
                        'label' => "function(context) {
                            return ' ' + context.raw + ' tagihan';
                        }",
                    ],
                ],
            ],
            'scales' => [
                'x' => [
                    'grid' => ['display' => false],
                    'ticks' => [
                        'font' => ['size' => 12, 'weight' => 600],
                    ],
                ],
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'stepSize' => 1,
                        'font'     => ['size' => 11],
                    ],
                    'grid' => [
                        'drawBorder' => false,
                        'color' => 'rgba(0, 0, 0, 0.04)',
                    ],
                ],
            ],
        ];
    }
}