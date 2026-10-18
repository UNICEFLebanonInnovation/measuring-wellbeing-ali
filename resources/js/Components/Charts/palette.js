// Brand blue first (Inter-Agency Coordination Lebanon, Pantone 300), then a
// restrained set of distinguishable hues for additional series.
export const PALETTE = ['#1b75bc', '#f28e2b', '#59a14f', '#e15759', '#76b7b2', '#b07aa1', '#edc948', '#9c755f', '#bab0ac', '#4e79a7'];

export const colorAt = (i) => PALETTE[i % PALETTE.length];

export const baseOptions = (rtl) => ({
    responsive: true,
    maintainAspectRatio: false,
    locale: rtl ? 'ar' : 'en',
    plugins: {
        legend: { position: 'bottom', rtl, textDirection: rtl ? 'rtl' : 'ltr', labels: { boxWidth: 12 } },
        tooltip: { rtl, textDirection: rtl ? 'rtl' : 'ltr' },
    },
});
