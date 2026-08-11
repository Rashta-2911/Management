<?php

namespace App\Filament\Widgets;

use App\Models\Tagihan;
use App\Services\PropertiContext;
use App\Services\WhatsappReminderService;
use Filament\Widgets\Widget;

class ReminderPembayaranWidget extends Widget
{
    protected string $view = 'filament.widgets.reminder-pembayaran-widget';

    protected static ?int $sort = -1;

    protected int|string|array $columnSpan = 'full';

    public function getViewData(): array
    {
        $propertiId = app(PropertiContext::class)->currentId();
        $baseQuery = Tagihan::query()
            ->when($propertiId, fn ($q, $id) => $q->whereHas('sewa.kamar.tipeKamar', fn ($sq) => $sq->where('properti_id', $id)))
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
            'overdue' => $overdue,
            'upcoming' => $upcoming,
        ];
    }

    public function getLinkReminder(Tagihan $tagihan): ?string
    {
        return WhatsappReminderService::buatLinkReminder($tagihan);
    }
}
