<?php

namespace App\Console\Commands;

use App\Models\Tagihan;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:update-status-tagihan')]
#[Description('Command description')]
class UpdateStatusTagihan extends Command
{
    protected $signature = 'tagihan:update-status';

    protected $description = 'Ubah status tagihan yang melewati jatuh tempo menjadi Terlambat';

    public function handle(): void
    {
        $updated = Tagihan::where('status', '=', 'Belum Lunas', 'and')
            ->whereDate('tanggal_jatuh_tempo', '<', now())
            ->update(['status' => 'Terlambat']);

        $this->info("{$updated} tagihan diperbarui ke status Terlambat.");
    }
}
