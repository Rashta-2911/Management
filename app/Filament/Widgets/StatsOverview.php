<?php

namespace App\Filament\Widgets;

use App\Models\Kamar;
use App\Models\Pembayaran;
use App\Models\Penghuni;
use App\Models\Properti;
use App\Models\Sewa;
use App\Models\Tagihan;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $totalProperti    = Properti::count('id');
        $totalKamar       = Kamar::count('id');
        $kamarTersedia    = Kamar::where('status', '=', 'Tersedia', 'and')->count();
        $kamarTerisi      = Kamar::where('status', '=', 'Terisi', 'and')->count();
        $totalPenghuni    = Penghuni::count('id');
        $sewaAktif        = Sewa::where('status', '=', 'Aktif', 'and')->count();
        $tagihanTerlambat = Tagihan::where('status', '=', 'Terlambat', 'and')->count();
        $pendapatanBulanIni = Pembayaran::where('status', '=', 'Lunas', 'and')
            ->whereMonth('tanggal_pembayaran', now()->month)
            ->sum('jumlah');

        // Occupancy rate
        $occupancyRate = $totalKamar > 0
            ? round(($kamarTerisi / $totalKamar) * 100)
            : 0;

        return [
            Stat::make('Total Properti', $totalProperti)
                ->description('Jumlah semua properti')
                ->descriptionIcon('heroicon-m-building-office-2')
                ->color('primary')
                ->icon('heroicon-o-building-office-2')
                ->extraAttributes([
                    'class' => 'stat-card stat-card-properti',
                ]),

            Stat::make('Total Kamar', $totalKamar)
                ->description("Tersedia: {$kamarTersedia} · Terisi: {$kamarTerisi}")
                ->descriptionIcon('heroicon-m-key')
                ->color('primary')
                ->icon('heroicon-o-key')
                ->extraAttributes([
                    'class' => 'stat-card stat-card-kamar',
                ]),

            Stat::make('Tingkat Hunian', "{$occupancyRate}%")
                ->description("{$kamarTerisi} dari {$totalKamar} kamar terisi")
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color($occupancyRate >= 80 ? 'success' : ($occupancyRate >= 50 ? 'warning' : 'danger'))
                ->icon('heroicon-o-chart-bar')
                ->extraAttributes([
                    'class' => 'stat-card stat-card-hunian',
                ]),

            Stat::make('Penghuni Aktif', $totalPenghuni)
                ->description("{$sewaAktif} kontrak berjalan")
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info')
                ->icon('heroicon-o-user-group')
                ->extraAttributes([
                    'class' => 'stat-card stat-card-penghuni',
                ]),

            Stat::make('Tagihan Terlambat', $tagihanTerlambat)
                ->description('Melewati jatuh tempo')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('danger')
                ->icon('heroicon-o-exclamation-triangle')
                ->extraAttributes([
                    'class' => 'stat-card stat-card-terlambat',
                ]),

            Stat::make('Pendapatan Bulan Ini', 'Rp ' . number_format($pendapatanBulanIni, 0, ',', '.'))
                ->description('Total pembayaran lunas')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->icon('heroicon-o-banknotes')
                ->extraAttributes([
                    'class' => 'stat-card stat-card-pendapatan',
                ]),
        ];
    }
}