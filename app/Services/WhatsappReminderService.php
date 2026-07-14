<?php

namespace App\Services;

use App\Models\Tagihan;

class WhatsappReminderService
{
    public static function buatLinkReminder(Tagihan $tagihan): ?string
    {
        $penghuni = $tagihan->sewa->penghuni;
        if (!$penghuni || !$penghuni->hasValidNoHp()) {
            return null;
        }
        $kamar = $tagihan->sewa->kamar;
        $pesan = self::buatTeksPesan($tagihan, $penghuni, $kamar);
        return "https://wa.me/{$penghuni->no_hp_wa}?text=" . urlencode($pesan);
    }

    protected static function buatTeksPesan(Tagihan $tagihan, $penghuni, $kamar): string
    {
        $statusText = match ($tagihan->status) {
            'Terlambat' => 'Tagihan Anda sudah *melewati jatuh tempo*, mohon segera dilunasi.',
            'Belum Lunas' => 'Ini pengingat bahwa tagihan Anda akan segera jatuh tempo.',
            default => '',
        };

        $jatuhTempo = \Carbon\Carbon::parse($tagihan->tanggal_jatuh_tempo)->translatedFormat('d F Y');

        return "Halo {$penghuni->nama_penghuni},\n\n"
            . "{$statusText}\n\n"
            . "Detail Tagihan:\n"
            . "Kamar: {$kamar->nomor_kamar}\n"
            . "Jatuh tempo: {$jatuhTempo}\n"
            . "Jumlah: Rp " . number_format($tagihan->jumlah, 0, ',', '.') . "\n\n"
            . "Silakan lakukan pembayaran secepatnya. Terima kasih.";
    }
}