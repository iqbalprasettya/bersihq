<!-- Litepicker -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" />
<script src="https://cdn.jsdelivr.net/npm/litepicker/dist/litepicker.js"></script>
<script src="https://cdn.jsdelivr.net/npm/litepicker/dist/plugins/ranges.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const picker = new Litepicker({
            element: document.getElementById('daterange'),
            singleMode: false,
            numberOfMonths: 2,
            numberOfColumns: 2,
            showTooltip: true,
            lang: 'id-ID',
            format: 'DD/MM/YYYY',
            plugins: ['ranges'],
            ranges: {
                'Hari Ini': [new Date(), new Date()],
                '7 Hari Terakhir': [new Date(new Date().setDate(new Date().getDate() - 6)), new Date()],
                '30 Hari Terakhir': [new Date(new Date().setDate(new Date().getDate() - 29)),
                    new Date()
                ],
                'Bulan Ini': [new Date(new Date().setDate(1)), new Date()],
                'Bulan Lalu': [new Date(new Date().setMonth(new Date().getMonth() - 1, 1)), new Date(
                    new Date().setDate(0))]
            },
            buttonText: {
                apply: 'Terapkan',
                cancel: 'Batal',
                previousMonth: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" /></svg>',
                nextMonth: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>'
            },
            tooltipText: {
                one: 'hari',
                other: 'hari'
            },
            setup: (picker) => {
                picker.on('selected', (date1, date2) => {
                    document.getElementById('daterange').value =
                        date1.format('DD/MM/YYYY') + ' - ' + date2.format('DD/MM/YYYY');
                });
            }
        });
    });
</script>

<!-- Custom Style untuk Litepicker -->
<style>
    .litepicker {
        --litepicker-is-start-color: rgb(22 163 74) !important;
        --litepicker-is-end-color: rgb(22 163 74) !important;
        --litepicker-is-in-range-color: rgb(187 247 208) !important;
        --litepicker-button-prev-month-color: rgb(22 163 74) !important;
        --litepicker-button-next-month-color: rgb(22 163 74) !important;
        --litepicker-day-color-hover: rgb(22 163 74) !important;
        font-family: inherit !important;
    }

    .litepicker .container__months {
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1) !important;
        border-radius: 0.5rem !important;
    }

    .litepicker .container__months .month-item-header {
        padding: 1rem 0;
        font-weight: 600;
        color: #1f2937;
    }

    .litepicker .container__months .month-item-weekdays-row {
        color: #6b7280;
        font-size: 0.875rem;
    }

    .litepicker .container__days .day-item {
        color: #374151;
        font-size: 0.875rem;
        font-weight: 500;
        border-radius: 0.75rem;
        height: var(--litepicker-day-height);
        width: var(--litepicker-day-width);
        transition: all 0.2s;
    }

    .litepicker .container__days .day-item:hover {
        box-shadow: none;
        background-color: #f3f4f6;
        color: #1f2937;
    }

    .litepicker .container__days .day-item.is-start-date,
    .litepicker .container__days .day-item.is-end-date {
        background-color: #059669;
        color: #ffffff;
    }

    .litepicker .container__days .day-item.is-in-range {
        background-color: #d1fae5;
        color: #059669;
    }

    .litepicker .container__days .day-item.is-today {
        color: #059669;
        font-weight: 600;
    }

    .litepicker .container__days .day-item.is-locked {
        color: #9ca3af;
    }

    .litepicker .container__days .day-item.is-disabled {
        color: #e5e7eb;
        text-decoration: none;
        background-color: transparent;
    }

    .litepicker .button-previous-month,
    .litepicker .button-next-month {
        color: #6b7280;
        transition: all 0.2s;
    }

    .litepicker .button-previous-month:hover,
    .litepicker .button-next-month:hover {
        color: #1f2937;
    }

    .litepicker .button-previous-month svg,
    .litepicker .button-next-month svg {
        width: 1.5rem;
        height: 1.5rem;
    }

    /* Custom input style */
    .date-range-input {
        @apply block w-full rounded-xl bg-gray-50 border-2 border-gray-200 focus:border-green-500 focus:bg-white focus:ring-0 transition-all duration-200 text-sm pl-12 pr-10 py-3 cursor-pointer hover:border-gray-300;
    }

    /* Reset button style */
    .litepicker .container__tooltip {
        background-color: #1f2937;
        border-radius: 0.5rem;
    }

    .litepicker .container__tooltip .tooltip-text {
        color: #ffffff;
        font-size: 0.75rem;
    }

    /* Footer style */
    .litepicker .container__footer {
        padding: 1rem;
        background-color: #ffffff;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .litepicker-custom-ranges {
        display: flex;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-top: 1px solid #e5e7eb;
    }

    .litepicker-custom-ranges button {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
        border-radius: 0.5rem;
        background-color: #f3f4f6;
        color: #374151;
        font-weight: 500;
        transition: all 0.2s;
    }

    .litepicker-custom-ranges button:hover {
        background-color: #059669;
        color: #ffffff;
    }
</style>
