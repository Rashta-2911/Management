// resources/js/Widgets/chart-darkmode.js
// Dynamically updates Chart.js defaults based on Filament's dark/light theme.

(function () {
    'use strict';

    const LIGHT_COLORS = {
        tickColor: '#64748B',      // slate-500 — visible on light bg
        gridColor: 'rgba(0, 0, 0, 0.06)',
        legendColor: '#334155',    // slate-700
        tooltipBg: '#1E293B',
        tooltipText: '#F8FAFC',
        pointBorder: '#FFFFFF',
    };

    const DARK_COLORS = {
        tickColor: '#FFFFFF',      // slate-50 — very bright on dark bg
        gridColor: 'rgba(255, 255, 255, 0.2)', // Increased opacity for better grid visibility
        legendColor: '#FFFFFF',    // slate-50 — very bright on dark bg
        tooltipBg: '#334155',
        tooltipText: '#F8FAFC',
        pointBorder: '#1E293B',
    };

    function isDarkMode() {
        return document.documentElement.classList.contains('dark');
    }

    function applyChartDefaults() {
        if (typeof Chart === 'undefined') return;

        const colors = isDarkMode() ? DARK_COLORS : LIGHT_COLORS;

        // Global defaults for Chart.js
        Chart.defaults.color = colors.tickColor;
        Chart.defaults.borderColor = colors.gridColor;

        // Scale defaults
        if (Chart.defaults.scales && Chart.defaults.scales.linear) {
            Chart.defaults.scales.linear.grid = Chart.defaults.scales.linear.grid || {};
            Chart.defaults.scales.linear.grid.color = colors.gridColor;
            Chart.defaults.scales.linear.ticks = Chart.defaults.scales.linear.ticks || {};
            Chart.defaults.scales.linear.ticks.color = colors.tickColor;
        }

        if (Chart.defaults.scales && Chart.defaults.scales.category) {
            Chart.defaults.scales.category.grid = Chart.defaults.scales.category.grid || {};
            Chart.defaults.scales.category.grid.color = colors.gridColor;
            Chart.defaults.scales.category.ticks = Chart.defaults.scales.category.ticks || {};
            Chart.defaults.scales.category.ticks.color = colors.tickColor;
        }

        // Legend defaults
        if (Chart.defaults.plugins && Chart.defaults.plugins.legend) {
            Chart.defaults.plugins.legend.labels = Chart.defaults.plugins.legend.labels || {};
            Chart.defaults.plugins.legend.labels.color = colors.legendColor;
        }

        // Tooltip defaults
        if (Chart.defaults.plugins && Chart.defaults.plugins.tooltip) {
            Chart.defaults.plugins.tooltip.backgroundColor = colors.tooltipBg;
            Chart.defaults.plugins.tooltip.titleColor = colors.tooltipText;
            Chart.defaults.plugins.tooltip.bodyColor = colors.tooltipText;
        }
    }

    function updateExistingCharts() {
        if (typeof Chart === 'undefined') return;

        const colors = isDarkMode() ? DARK_COLORS : LIGHT_COLORS;

        // Update all active chart instances
        Object.values(Chart.instances || {}).forEach(function (chart) {
            if (!chart || !chart.options) return;

            // Update scales
            if (chart.options.scales) {
                Object.keys(chart.options.scales).forEach(function (scaleKey) {
                    var scale = chart.options.scales[scaleKey];
                    if (scale) {
                        scale.ticks = scale.ticks || {};
                        scale.ticks.color = colors.tickColor;
                        scale.grid = scale.grid || {};
                        scale.grid.color = colors.gridColor;
                    }
                });
            }

            // Update legend
            if (chart.options.plugins && chart.options.plugins.legend) {
                chart.options.plugins.legend.labels = chart.options.plugins.legend.labels || {};
                chart.options.plugins.legend.labels.color = colors.legendColor;
            }

            // Update tooltip
            if (chart.options.plugins && chart.options.plugins.tooltip) {
                chart.options.plugins.tooltip.backgroundColor = colors.tooltipBg;
                chart.options.plugins.tooltip.titleColor = colors.tooltipText;
                chart.options.plugins.tooltip.bodyColor = colors.tooltipText;
            }

            // Update point border color for line charts
            if (chart.config && chart.config.data && chart.config.data.datasets) {
                chart.config.data.datasets.forEach(function (ds) {
                    if (ds.pointBorderColor) {
                        ds.pointBorderColor = colors.pointBorder;
                    }
                });
            }

            chart.update('none'); // 'none' = no animation for smoother transition
        });
    }

    // Wait for Chart.js to be available, then apply defaults
    function init() {
        applyChartDefaults();
        updateExistingCharts();
    }

    // Apply on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () {
            // Small delay to ensure Chart.js is loaded
            setTimeout(init, 300);
        });
    } else {
        setTimeout(init, 300);
    }

    // Watch for dark/light mode toggle (Filament toggles 'dark' class on <html>)
    new MutationObserver(function () {
        applyChartDefaults();
        // Slight delay to allow Filament's UI to settle
        setTimeout(updateExistingCharts, 100);
    }).observe(document.documentElement, { attributeFilter: ['class'] });

    // Also handle Livewire navigation (charts re-rendered)
    document.addEventListener('livewire:navigated', function () {
        setTimeout(init, 500);
    });
})();