<?php

namespace App\Mail;

use App\Models\Penggajian;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SlipGajiMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Penggajian $penggajian,
        public string $pdfPath,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Slip Gaji '.($this->penggajian->karyawan?->nama ?? 'Karyawan'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.slip-gaji',
            with: [
                'penggajian' => $this->penggajian,
            ],
        );
    }

    public function attachments(): array
    {
        return [
            Attachment::fromPath(storage_path('app/public/'.$this->pdfPath)),
        ];
    }
}
