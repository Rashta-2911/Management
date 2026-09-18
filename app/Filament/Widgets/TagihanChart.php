<?php

namespace App\Filament\Widgets;

use App\Models\Tagihan;
use App\Services\PropertiContext;
use Filament\Widgets\ChartWidget;

class TagihanChart extends ChartWidget
{
    protected ?string $heading = 'Status Tagihan';

    protected ?string $description = 'Distribusi status seluruh tagihan';

    protected ?string $maxHeight = '300px';

    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $propertiId = app(PropertiContext::class)->currentId();
        $qTagihan = Tagihan::query()->when($propertiId !== null, function ($query) use ($propertiId) {
            $query->whereHas('sewa.kamar.tipeKamar', fn ($sq) => $sq->where('properti_id', $propertiId));
        });

        $lunas = (clone $qTagihan)->where('status', '=', 'Lunas')->count();
        $belumLunas = (clone $qTagihan)->where('status', '=', 'Belum lunas')->count();
        $terlambat = (clone $qTagihan)->where('status', '=', 'Terlambat')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Tagihan',
                    'data' => [$lunas, $belumLunas, $terlambat],
                    'backgroundColor' => [
                        '#00d492',  // Gold — Lunas
                        '#FFBD00',  // Navy — Belum Lunas
                        '#BC5C5C',  // Brick — Terlambat
                    ],
                    'hoverBackgroundColor' => [
                        '#D9A229',  // Darker Gold
                        '#2A3A5C',  // Lighter Navy
                        '#8B4726',  // Darker Brick
                    ],
                    'borderWidth' => 0,
                    'borderRadius' => 8,
                    'borderSkipped' => false,
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
                        'font' => ['size' => 11],
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
