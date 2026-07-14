<x-filament-widgets::widget>
    <div class="reminder-widget space-y-5">

        {{-- ═══ Summary Cards ═══ --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            {{-- Overdue Count --}}
            <div class="reminder-summary-card reminder-summary-overdue group relative overflow-hidden rounded-2xl border border-red-200/60 bg-white p-5 shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-lg dark:border-red-500/15 dark:bg-gray-900/80">
                <div class="absolute inset-0 bg-gradient-to-br from-red-500/5 via-transparent to-transparent dark:from-red-500/10"></div>
                <div class="absolute -right-4 -top-4 h-24 w-24 rounded-full bg-red-500/5 transition-transform duration-500 group-hover:scale-125 dark:bg-red-500/10"></div>
                <div class="relative flex items-center gap-x-4">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-red-500 to-red-600 shadow-lg shadow-red-500/20">
                        <x-filament::icon icon="heroicon-o-exclamation-triangle" class="h-6 w-6 text-white" />
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-red-500/80 dark:text-red-400/80">Terlambat</p>
                        <p class="text-2xl font-extrabold tracking-tight text-gray-900 dark:text-white">{{ $overdue->count() }}</p>
                    </div>
                </div>
            </div>

            {{-- Upcoming Count --}}
            <div class="reminder-summary-card reminder-summary-upcoming group relative overflow-hidden rounded-2xl border border-amber-200/60 bg-white p-5 shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-lg dark:border-amber-500/15 dark:bg-gray-900/80">
                <div class="absolute inset-0 bg-gradient-to-br from-amber-500/5 via-transparent to-transparent dark:from-amber-500/10"></div>
                <div class="absolute -right-4 -top-4 h-24 w-24 rounded-full bg-amber-500/5 transition-transform duration-500 group-hover:scale-125 dark:bg-amber-500/10"></div>
                <div class="relative flex items-center gap-x-4">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-amber-400 to-amber-500 shadow-lg shadow-amber-500/20">
                        <x-filament::icon icon="heroicon-o-clock" class="h-6 w-6 text-white" />
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-amber-500/80 dark:text-amber-400/80">Jatuh Tempo 7 Hari</p>
                        <p class="text-2xl font-extrabold tracking-tight text-gray-900 dark:text-white">{{ $upcoming->count() }}</p>
                    </div>
                </div>
            </div>

            {{-- Status Card --}}
            <div class="reminder-summary-card reminder-summary-status group relative overflow-hidden rounded-2xl border bg-white p-5 shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-lg dark:bg-gray-900/80
                {{ ($overdue->count() + $upcoming->count()) === 0
                    ? 'border-emerald-200/60 dark:border-emerald-500/15'
                    : 'border-gray-200/60 dark:border-white/10' }}">
                <div class="absolute inset-0 bg-gradient-to-br {{ ($overdue->count() + $upcoming->count()) === 0 ? 'from-emerald-500/5' : 'from-blue-500/5' }} via-transparent to-transparent"></div>
                <div class="relative flex items-center gap-x-4">
                    @if (($overdue->count() + $upcoming->count()) === 0)
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-400 to-emerald-500 shadow-lg shadow-emerald-500/20">
                            <x-filament::icon icon="heroicon-o-check-circle" class="h-6 w-6 text-white" />
                        </div>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-emerald-500/80 dark:text-emerald-400/80">Status</p>
                            <p class="text-sm font-bold text-gray-900 dark:text-white">Semua Aman! 🎉</p>
                            <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">Tidak ada tagihan pending</p>
                        </div>
                    @else
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-blue-400 to-blue-500 shadow-lg shadow-blue-500/20">
                            <x-filament::icon icon="heroicon-o-bell-alert" class="h-6 w-6 text-white" />
                        </div>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-blue-500/80 dark:text-blue-400/80">Total Perlu Perhatian</p>
                            <p class="text-2xl font-extrabold tracking-tight text-gray-900 dark:text-white">{{ $overdue->count() + $upcoming->count() }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ═══ Overdue Section ═══ --}}
        @if ($overdue->isNotEmpty())
            <div class="reminder-section-overdue overflow-hidden rounded-2xl border border-red-200/40 bg-white shadow-sm dark:border-red-500/10 dark:bg-gray-900/60">
                {{-- Section Header --}}
                <div class="flex items-center justify-between border-b border-red-100/80 bg-gradient-to-r from-red-50 to-transparent px-5 py-3.5 dark:border-red-500/10 dark:from-red-500/5 dark:to-transparent">
                    <div class="flex items-center gap-x-2.5">
                        <span class="relative flex h-2.5 w-2.5">
                            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-red-400 opacity-75"></span>
                            <span class="relative inline-flex h-2.5 w-2.5 rounded-full bg-red-500"></span>
                        </span>
                        <h3 class="text-sm font-bold text-red-700 dark:text-red-400">
                            Tagihan Terlambat
                        </h3>
                        <span class="inline-flex items-center rounded-full bg-red-100 px-2 py-0.5 text-xs font-bold text-red-600 dark:bg-red-500/15 dark:text-red-400">
                            {{ $overdue->count() }}
                        </span>
                    </div>
                </div>

                {{-- Items --}}
                <div class="divide-y divide-red-100/60 dark:divide-red-500/10">
                    @foreach ($overdue as $tagihan)
                        @php
                            $jatuhTempo = \Carbon\Carbon::parse($tagihan->tanggal_jatuh_tempo)->startOfDay();
                            $linkReminder = $this->getLinkReminder($tagihan);
                            $daysLate = now()->startOfDay()->diffInDays($jatuhTempo);
                        @endphp
                        <div class="reminder-item group flex flex-col gap-y-3 px-5 py-4 transition-colors duration-200 hover:bg-red-50/50 dark:hover:bg-red-500/5 sm:flex-row sm:items-center sm:gap-x-5 sm:gap-y-0">
                            {{-- Icon + Info --}}
                            <div class="flex min-w-0 flex-1 items-center gap-x-3.5">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-red-100 ring-1 ring-red-200/60 transition-all group-hover:bg-red-200/80 dark:bg-red-500/15 dark:ring-red-500/20">
                                    <x-filament::icon icon="heroicon-o-user" class="h-5 w-5 text-red-600 dark:text-red-400" />
                                </div>
                                <div class="min-w-0">
                                    <h4 class="truncate text-sm font-semibold text-gray-900 dark:text-white">
                                        {{ $tagihan->sewa?->penghuni?->nama_penghuni ?? 'Tanpa Nama' }}
                                    </h4>
                                    <div class="mt-0.5 flex items-center gap-x-3 text-xs text-gray-500 dark:text-gray-400">
                                        <span class="inline-flex items-center gap-x-1">
                                            <x-filament::icon icon="heroicon-m-home" class="h-3.5 w-3.5" />
                                            {{ $tagihan->sewa?->kamar?->nomor_kamar ?? '-' }}
                                        </span>
                                        <span class="inline-flex items-center gap-x-1">
                                            <x-filament::icon icon="heroicon-m-calendar" class="h-3.5 w-3.5" />
                                            {{ $jatuhTempo->translatedFormat('d M Y') }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            {{-- Amount --}}
                            <div class="flex items-center gap-x-4 pl-14 sm:pl-0">
                                <div class="text-right">
                                    <p class="text-sm font-bold text-gray-900 dark:text-white">
                                        Rp {{ number_format($tagihan->jumlah, 0, ',', '.') }}
                                    </p>
                                    <div class="mt-1">
                                        @if ($jatuhTempo->isToday())
                                            <span class="inline-flex items-center gap-x-1 rounded-full bg-amber-100 px-2 py-0.5 text-xs font-bold text-amber-700 dark:bg-amber-500/15 dark:text-amber-400">
                                                <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                                Hari Ini
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-x-1 rounded-full bg-red-100 px-2 py-0.5 text-xs font-bold text-red-700 dark:bg-red-500/15 dark:text-red-400">
                                                <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                                                {{ $daysLate }} hari terlambat
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                {{-- WA Button --}}
                                <div class="shrink-0">
                                    @if ($linkReminder)
                                        <a href="{{ $linkReminder }}" target="_blank"
                                            class="inline-flex items-center gap-x-1.5 rounded-xl bg-gradient-to-r from-[#25D366] to-[#128C7E] px-3.5 py-2 text-xs font-bold text-white shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md hover:shadow-green-500/20">
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                            </svg>
                                            Kirim WA
                                        </a>
                                    @else
                                        <span class="inline-flex items-center gap-x-1.5 rounded-xl bg-gray-100 px-3.5 py-2 text-xs font-medium text-gray-400 dark:bg-gray-800 dark:text-gray-500">
                                            <x-filament::icon icon="heroicon-m-phone-x-mark" class="h-4 w-4" />
                                            No HP invalid
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- ═══ Upcoming Section ═══ --}}
        @if ($upcoming->isNotEmpty())
            <div class="reminder-section-upcoming overflow-hidden rounded-2xl border border-amber-200/40 bg-white shadow-sm dark:border-amber-500/10 dark:bg-gray-900/60">
                {{-- Section Header --}}
                <div class="flex items-center justify-between border-b border-amber-100/80 bg-gradient-to-r from-amber-50 to-transparent px-5 py-3.5 dark:border-amber-500/10 dark:from-amber-500/5 dark:to-transparent">
                    <div class="flex items-center gap-x-2.5">
                        <span class="relative flex h-2.5 w-2.5">
                            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-amber-400 opacity-75"></span>
                            <span class="relative inline-flex h-2.5 w-2.5 rounded-full bg-amber-500"></span>
                        </span>
                        <h3 class="text-sm font-bold text-amber-700 dark:text-amber-400">
                            Jatuh Tempo 7 Hari ke Depan
                        </h3>
                        <span class="inline-flex items-center rounded-full bg-amber-100 px-2 py-0.5 text-xs font-bold text-amber-600 dark:bg-amber-500/15 dark:text-amber-400">
                            {{ $upcoming->count() }}
                        </span>
                    </div>
                </div>

                {{-- Items --}}
                <div class="divide-y divide-amber-100/60 dark:divide-amber-500/10">
                    @foreach ($upcoming as $tagihan)
                        @php
                            $jatuhTempo = \Carbon\Carbon::parse($tagihan->tanggal_jatuh_tempo)->startOfDay();
                            $linkReminder = $this->getLinkReminder($tagihan);
                            $daysLeft = now()->startOfDay()->diffInDays($jatuhTempo);
                        @endphp
                        <div class="reminder-item group flex flex-col gap-y-3 px-5 py-4 transition-colors duration-200 hover:bg-amber-50/50 dark:hover:bg-amber-500/5 sm:flex-row sm:items-center sm:gap-x-5 sm:gap-y-0">
                            {{-- Icon + Info --}}
                            <div class="flex min-w-0 flex-1 items-center gap-x-3.5">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-amber-100 ring-1 ring-amber-200/60 transition-all group-hover:bg-amber-200/80 dark:bg-amber-500/15 dark:ring-amber-500/20">
                                    <x-filament::icon icon="heroicon-o-user" class="h-5 w-5 text-amber-600 dark:text-amber-400" />
                                </div>
                                <div class="min-w-0">
                                    <h4 class="truncate text-sm font-semibold text-gray-900 dark:text-white">
                                        {{ $tagihan->sewa?->penghuni?->nama_penghuni ?? 'Tanpa Nama' }}
                                    </h4>
                                    <div class="mt-0.5 flex items-center gap-x-3 text-xs text-gray-500 dark:text-gray-400">
                                        <span class="inline-flex items-center gap-x-1">
                                            <x-filament::icon icon="heroicon-m-home" class="h-3.5 w-3.5" />
                                            {{ $tagihan->sewa?->kamar?->nomor_kamar ?? '-' }}
                                        </span>
                                        <span class="inline-flex items-center gap-x-1">
                                            <x-filament::icon icon="heroicon-m-calendar" class="h-3.5 w-3.5" />
                                            {{ $jatuhTempo->translatedFormat('d M Y') }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            {{-- Amount --}}
                            <div class="flex items-center gap-x-4 pl-14 sm:pl-0">
                                <div class="text-right">
                                    <p class="text-sm font-bold text-gray-900 dark:text-white">
                                        Rp {{ number_format($tagihan->jumlah, 0, ',', '.') }}
                                    </p>
                                    <div class="mt-1">
                                        @if ($jatuhTempo->isToday())
                                            <span class="inline-flex items-center gap-x-1 rounded-full bg-amber-100 px-2 py-0.5 text-xs font-bold text-amber-700 dark:bg-amber-500/15 dark:text-amber-400">
                                                <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                                Hari Ini
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-x-1 rounded-full bg-blue-100 px-2 py-0.5 text-xs font-bold text-blue-700 dark:bg-blue-500/15 dark:text-blue-400">
                                                <span class="h-1.5 w-1.5 rounded-full bg-blue-500"></span>
                                                {{ $daysLeft }} hari lagi
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                {{-- WA Button --}}
                                <div class="shrink-0">
                                    @if ($linkReminder)
                                        <a href="{{ $linkReminder }}" target="_blank"
                                            class="inline-flex items-center gap-x-1.5 rounded-xl bg-gradient-to-r from-[#25D366] to-[#128C7E] px-3.5 py-2 text-xs font-bold text-white shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md hover:shadow-green-500/20">
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                            </svg>
                                            Kirim WA
                                        </a>
                                    @else
                                        <span class="inline-flex items-center gap-x-1.5 rounded-xl bg-gray-100 px-3.5 py-2 text-xs font-medium text-gray-400 dark:bg-gray-800 dark:text-gray-500">
                                            <x-filament::icon icon="heroicon-m-phone-x-mark" class="h-4 w-4" />
                                            No HP invalid
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- ═══ Empty State ═══ --}}
        @if ($overdue->isEmpty() && $upcoming->isEmpty())
            <div class="overflow-hidden rounded-2xl border border-emerald-200/40 bg-white shadow-sm dark:border-emerald-500/10 dark:bg-gray-900/60">
                <div class="flex flex-col items-center justify-center py-16 text-center">
                    <div class="mb-5 flex h-20 w-20 items-center justify-center rounded-2xl bg-gradient-to-br from-emerald-400 to-emerald-500 shadow-xl shadow-emerald-500/20">
                        <x-filament::icon icon="heroicon-o-check-circle" class="h-10 w-10 text-white" />
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Semua Aman! 🎉</h3>
                    <p class="mt-1.5 text-sm text-gray-500 dark:text-gray-400">
                        Tidak ada tagihan yang perlu diperhatikan saat ini.
                    </p>
                </div>
            </div>
        @endif

    </div>
</x-filament-widgets::widget>