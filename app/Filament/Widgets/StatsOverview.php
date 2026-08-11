<?php

namespace App\Filament\Widgets;

use App\Models\Kamar;
use App\Models\Pembayaran;
use App\Models\Penghuni;
use App\Models\Sewa;
use App\Models\Tagihan;
use App\Services\PropertiContext;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $propertiId = app(PropertiContext::class)->currentId();

        $qKamar = Kamar::query()->when($propertiId !== null, function ($query) use ($propertiId) {
            $query->whereHas('tipeKamar', fn ($sq) => $sq->where('properti_id', $propertiId));
        });
        $qPenghuni = Penghuni::query()->when($propertiId !== null, function ($query) use ($propertiId) {
            $query->whereHas('kamar.tipeKamar', fn ($sq) => $sq->where('properti_id', $propertiId));
        });
        $qSewa = Sewa::query()->when($propertiId !== null, function ($query) use ($propertiId) {
            $query->whereHas('kamar.tipeKamar', fn ($sq) => $sq->where('properti_id', $propertiId));
        });
        $qTagihan = Tagihan::query()->when($propertiId !== null, function ($query) use ($propertiId) {
            $query->whereHas('sewa.kamar.tipeKamar', fn ($sq) => $sq->where('properti_id', $propertiId));
        });
        $qPembayaran = Pembayaran::query()->when($propertiId !== null, function ($query) use ($propertiId) {
            $query->whereHas('sewa.kamar.tipeKamar', fn ($sq) => $sq->where('properti_id', $propertiId));
        });

        $totalProperti = app(PropertiContext::class)->availableFor(Auth::user())->count();
        $activePropertiName = app(PropertiContext::class)->current()?->nama_properti ?? 'Semua';

        $totalKamar = (clone $qKamar)->count('id');
        $kamarTersedia = (clone $qKamar)->where('status', '=', 'Tersedia')->count();
        $kamarTerisi = (clone $qKamar)->where('status', '=', 'Terisi')->count();
        $totalPenghuni = (clone $qPenghuni)->count('id');
        $sewaAktif = (clone $qSewa)->where('status', '=', 'Aktif')->count();
        $tagihanTerlambat = (clone $qTagihan)->where('status', '=', 'Terlambat')->count();
        $pendapatanBulanIni = (clone $qPembayaran)->where('status', '=', 'Lunas')
            ->whereMonth('tanggal_pembayaran', now()->month)
            ->sum('jumlah');

        $occupancyRate = $totalKamar > 0
            ? round(($kamarTerisi / $totalKamar) * 100)
            : 0;

        return [
            Stat::make('Properti Aktif', $activePropertiName)
                ->description("Dari {$totalProperti} properti yang Anda kelola")
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

            Stat::make('Pendapatan Bulan Ini', 'Rp '.number_format($pendapatanBulanIni, 0, ',', '.'))
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
