<?php

namespace App\Filament\Resources\Pembayaran\Schemas;

use Filament\Actions\Action;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;

class PembayaranInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Ringkasan Pembayaran')
                    ->description('Jumlah, status, metode, dan tanggal pembayaran')
                    ->icon('heroicon-o-banknotes')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('jumlah')
                            ->label('Jumlah Pembayaran')
                            ->icon('heroicon-o-banknotes')
                            ->money('IDR')
                            ->weight(FontWeight::ExtraBold)
                            ->size('lg')
                            ->color('success'),

                        TextEntry::make('status')
                            ->label('Status')
                            ->icon(fn (?string $state): string => match ($state) {
                                'Terverifikasi', 'Berhasil' => 'heroicon-o-check-circle',
                                'Pending', 'Menunggu Verifikasi' => 'heroicon-o-clock',
                                'Ditolak', 'Gagal' => 'heroicon-o-x-circle',
                                default => 'heroicon-o-question-mark-circle',
                            })
                            ->badge()
                            ->size('lg')
                            ->color(fn (?string $state): string => match ($state) {
                                'Terverifikasi', 'Berhasil' => 'success',
                                'Pending', 'Menunggu Verifikasi' => 'warning',
                                'Ditolak', 'Gagal' => 'danger',
                                default => 'gray',
                            }),

                        TextEntry::make('metode_pembayaran')
                            ->label('Metode Pembayaran')
                            ->icon(fn (?string $state): string => match ($state) {
                                'Transfer Bank', 'Transfer' => 'heroicon-o-building-library',
                                'Tunai', 'Cash' => 'heroicon-o-banknotes',
                                'E-Wallet', 'QRIS' => 'heroicon-o-device-phone-mobile',
                                default => 'heroicon-o-credit-card',
                            })
                            ->badge()
                            ->color('gray'),

                        TextEntry::make('tanggal_pembayaran')
                            ->label('Tanggal Pembayaran')
                            ->icon('heroicon-o-calendar')
                            ->dateTime('d F Y')
                            ->weight(FontWeight::Medium)
                            ->placeholder('-'),
                    ]),

                Section::make('Bukti Pembayaran')
                    ->description('Foto atau dokumen bukti transfer/pembayaran')
                    ->icon('heroicon-o-photo')
                    ->columnSpanFull()
                    ->headerActions([
                        Action::make('lihat_bukti_penuh')
                            ->label('Lihat Ukuran Penuh')
                            ->icon('heroicon-o-arrows-pointing-out')
                            ->color('gray')
                            ->url(function ($record) {
                                if (! $record->bukti_pembayaran) {
                                    return null;
                                }

                                /** @var FilesystemAdapter $disk */
                                $disk = Storage::disk('public');

                                return $disk->url($record->bukti_pembayaran);
                            })
                            ->openUrlInNewTab()
                            ->visible(fn ($record) => filled($record->bukti_pembayaran)),
                    ])
                    ->schema([
                        ImageEntry::make('bukti_pembayaran')
                            ->label('')
                            ->disk('public')
                            ->visibility('public')
                            ->height(320)
                            ->extraImgAttributes([
                                'class' => 'rounded-xl border border-gray-200 shadow-sm object-contain hover:shadow-md transition-shadow',
                            ])
                            ->placeholder('Tidak ada bukti pembayaran diunggah')
                            ->columnSpanFull(),
                    ]),

                Section::make('Referensi ID')
                    ->description('ID pembayaran dan data terkait untuk keperluan pelacakan')
                    ->icon('heroicon-o-identification')
                    ->columns(3)
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('id')
                            ->label('ID Pembayaran')
                            ->icon('heroicon-o-identification')
                            ->color('gray')
                            ->copyable(),

                        TextEntry::make('sewa.id')
                            ->label('ID Sewa')
                            ->icon('heroicon-o-identification')
                            ->color('gray')
                            ->copyable()
                            ->placeholder('-'),

                        TextEntry::make('tagihan.id')
                            ->label('ID Tagihan')
                            ->icon('heroicon-o-identification')
                            ->color('gray')
                            ->copyable()
                            ->placeholder('Tidak ada'),
                    ]),
            ]);
    }
}
