<?php

namespace App\Services;

use App\Models\Penggajian;
use Dompdf\Dompdf;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SlipGajiService
{
    public static function buatDanSimpanPdf(Penggajian $penggajian): string
    {
        // Pastikan relasi karyawan dan properti sudah di-load
        $penggajian->loadMissing('karyawan.properti');

        $fileName = 'slip-gaji-'.Str::slug($penggajian->karyawan?->nama ?? 'karyawan').'-'.$penggajian->bulan.'-'.$penggajian->tahun.'.pdf';
        $path = 'slip-gaji/'.$fileName;

        $dompdf = new Dompdf(['isRemoteEnabled' => true]);
        $html = view('pdf.slip-gaji', [
            'penggajian' => $penggajian,
            'karyawan' => $penggajian->karyawan,
        ])->render();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('a4', 'portrait');
        $dompdf->render();

        Storage::disk('public')->put($path, $dompdf->output());

        return $path;
    }

    public static function buatLinkWa(Penggajian $penggajian): ?string
    {
        $nomor = $penggajian->karyawan?->no_telepon;

        if (! $nomor) {
            return null;
        }

        // Bersihkan nomor dari karakter non-digit
        $nomor = preg_replace('/[^0-9]/', '', $nomor);
        if ($nomor === '') {
            return null;
        }

        // Konversi nomor lokal (08xx) ke format internasional (628xx)
        if (str_starts_with($nomor, '0')) {
            $nomor = '62'.substr($nomor, 1);
        }

        $path = self::buatDanSimpanPdf($penggajian);
        $url = asset('storage/'.$path);

        $bulanNama = Carbon::create($penggajian->tahun, $penggajian->bulan, 1)
            ->translatedFormat('F Y');

        $pesan = "Halo {$penggajian->karyawan?->nama},\n\n"
            ."Berikut slip gaji Anda untuk periode *{$bulanNama}*:\n"
            .'Nominal: Rp '.number_format($penggajian->nominal_gaji, 0, ',', '.')."\n\n"
            ."Download slip gaji:\n{$url}\n\n"
            .'Terima kasih.';

        // wa.me hanya mendukung parameter ?text=, parameter &media= tidak valid
        $whatsappUrl = 'https://wa.me/'.$nomor.'?text='.rawurlencode($pesan);

        // Tandai slip sebagai sudah dikirim
        $penggajian->update([
            'dikirim_at' => now(),
            'dikirim_via' => 'whatsapp',
        ]);

        return $whatsappUrl;
    }
}
