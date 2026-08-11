<?php

namespace Tests\Unit;

use App\Mail\SlipGajiMail;
use App\Models\Karyawan;
use App\Models\Penggajian;
use App\Services\SlipGajiService;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SlipGajiServiceTest extends TestCase
{
    public function test_it_can_send_salary_slip_via_email(): void
    {
        Mail::fake();

        $karyawan = new Karyawan([
            'nama' => 'Budi',
            'email' => 'budi@example.com',
        ]);

        $penggajian = new Penggajian([
            'id' => 'GJ-0001',
            'bulan' => 7,
            'tahun' => 2026,
            'nominal_gaji' => 5000000,
            'status' => 'Sudah Dibayar',
        ]);

        $penggajian->setRelation('karyawan', $karyawan);

        $result = SlipGajiService::kirimSlipEmail($penggajian);

        $this->assertTrue($result);
        Mail::assertSent(SlipGajiMail::class, function (SlipGajiMail $mail) use ($penggajian): bool {
            return $mail->hasTo($penggajian->karyawan->email);
        });
    }
}
