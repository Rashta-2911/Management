(function () {
    'use strict';

    // Definisikan warna Bar
    const BAR_COLORS = {
        light: ['#16A34A', '#F5B731', '#DC2626'],
        dark:  ['#4ADE80', '#FBBF24', '#F87171'],
    };

    // Definisikan warna Teks
    const TEXT_COLORS = {
        light: '#334155', // Warna gelap untuk Light Mode
        dark:  '#FFFFFF', // Warna terang (Slate 200) untuk Dark Mode agar nyaman dibaca
    };

    function updateTagihanChartColors() {
        const isDark = document.documentElement.classList.contains('dark');
        const barColors = isDark ? BAR_COLORS.dark : BAR_COLORS.light;
        const textColor = isDark ? TEXT_COLORS.dark : TEXT_COLORS.light;

        document.querySelectorAll('canvas').forEach(canvas => {
            const root = canvas.closest('[x-data]');
            if (!root || !window.Alpine) return;

            const data = window.Alpine.$data(root);
            const chart = data?.chart;

            // Pastikan chart ada dan ini adalah chart Tagihan yang benar
            if (chart && chart.data?.labels?.includes('Lunas')) {
                // 1. Ubah warna Bar
                chart.data.datasets[0].backgroundColor = barColors;

                // 2. Ubah warna Teks Sumbu X & Y
                if (chart.options.scales?.x?.ticks) {
                    chart.options.scales.x.ticks.color = textColor;
                }
                if (chart.options.scales?.y?.ticks) {
                    chart.options.scales.y.ticks.color = textColor;
                }

                // Update diagram tanpa animasi
                chart.update('none');
            }
        });
    }

    function initListeners() {
        // Pantau klik tombol Dark Mode
        window.addEventListener('theme-changed', () => {
            setTimeout(updateTagihanChartColors, 100);
        });

        // Pantau perubahan class pada <html>
        new MutationObserver(updateTagihanChartColors).observe(document.documentElement, { 
            attributeFilter: ['class'] 
        });

        // Hook Livewire: Terapkan ulang jika komponen dirender ulang oleh PHP
        if (window.Livewire) {
            Livewire.hook('morph.updated', () => {
                setTimeout(updateTagihanChartColors, 50);
            });
        }

        // Jalankan saat inisialisasi awal
        setTimeout(updateTagihanChartColors, 200);
    }

    document.addEventListener('alpine:initialized', initListeners);
    document.addEventListener('DOMContentLoaded', () => {
        setTimeout(updateTagihanChartColors, 500); 
    });
})();