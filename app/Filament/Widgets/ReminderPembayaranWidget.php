<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\Tagihan;
use App\Services\WhatsappReminderService;

class ReminderPembayaranWidget extends Widget
{
    protected string $view = 'filament.widgets.reminder-pembayaran-widget';

    protected static ?int $sort = -1;

    protected int|string|array $columnSpan = 'full';

    public function getViewData(): array
    {
        $baseQuery = Tagihan::query()
            ->whereIn('status', ['Belum Lunas', 'Terlambat'], 'and', false)
            ->with(['sewa.penghuni', 'sewa.kamar']);



        $overdue = (clone $baseQuery)
            ->whereDate('tanggal_jatuh_tempo', '<', now())
            ->orderBy('tanggal_jatuh_tempo')
            ->get();

        $upcoming = (clone $baseQuery)
            ->whereDate('tanggal_jatuh_tempo', '>=', now())
            ->whereDate('tanggal_jatuh_tempo', '<=', now()->addDays(7))
            ->orderBy('tanggal_jatuh_tempo')
            ->get();

        return [
            'overdue'  => $overdue,
            'upcoming' => $upcoming,
        ];
    }

    public function getLinkReminder(Tagihan $tagihan): ?string
    {
        return WhatsappReminderService::buatLinkReminder($tagihan);
    }
}