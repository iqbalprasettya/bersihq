<?php

namespace App\Exports;

use App\Models\Order;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TransactionsExport implements FromCollection, WithMapping, WithColumnWidths, WithTitle, WithEvents
{
    protected $startDate;
    protected $endDate;
    protected $status;
    protected $summary;

    public function __construct($startDate = null, $endDate = null, $status = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->status = $status;
        $this->summary = $this->getSummary();
    }

    protected function getSummary()
    {
        $query = Order::query();

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
        }

        // Hitung total pendapatan untuk semua filter yang diterapkan - Ini akan digunakan untuk summary di atas
        $totalRevenueSummary = $query->sum('total_harga');

        // Hanya hitung summary per status jika filter status ALL atau NULL/kosong
        if (empty($this->status)) {
            $summary = $query->select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                ->pluck('total', 'status')
                ->toArray();

            $totalAll = array_sum($summary);

            $formattedSummary = [
                'Total Keseluruhan Transaksi' => $totalAll,
                // 'Total Pendapatan' => $totalRevenueSummary, // Menggunakan total pendapatan untuk summary atas
                'Transaksi Diterima' => $summary['diterima'] ?? 0,
                'Transaksi Diproses' => $summary['diproses'] ?? 0,
                'Transaksi Siap Diambil' => $summary['siap_diambil'] ?? 0,
                'Transaksi Selesai' => $summary['selesai'] ?? 0,
            ];

            // Tambahkan rentang tanggal ke summary jika ada
            if ($this->startDate && $this->endDate) {
                $formattedSummary = ['Rentang Tanggal' => $this->startDate->format('d/m/Y') . ' - ' . $this->endDate->format('d/m/Y')] + $formattedSummary;
            }

            return $formattedSummary;
        } else {
            // Jika filter status spesifik, summary hanya menampilkan total untuk status tersebut
            $total = $query->where('status', $this->status)->count();
            $formattedSummary = [
                'Status yang dipilih' => ucfirst(str_replace('_', ' ', $this->status)),
                'Total Transaksi' => $total,
                // 'Total Pendapatan' => $totalRevenueSummary // Menggunakan total pendapatan untuk summary atas
            ];

            if ($this->startDate && $this->endDate) {
                $formattedSummary = ['Rentang Tanggal' => $this->startDate->format('d/m/Y') . ' - ' . $this->endDate->format('d/m/Y')] + $formattedSummary;
            }
            return $formattedSummary;
        }
    }

    public function collection()
    {
        $query = Order::with(['customer', 'service']);

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
        }

        if ($this->status) {
            $query->where('status', $this->status);
        }

        return $query->latest()->get();
    }

    public function map($transaction): array
    {
        return [
            '#' . str_pad($transaction->id, 5, '0', STR_PAD_LEFT),
            $transaction->created_at->format('d/m/Y H:i'),
            $transaction->customer->nama,
            $transaction->service->nama_layanan,
            $transaction->total_harga, // Menggunakan nilai numerik untuk formatting Excel
            ucfirst(str_replace('_', ' ', $transaction->status)), // Tetap kirim teks status aslinya
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15, // No. Order
            'B' => 20, // Tanggal
            'C' => 30, // Pelanggan
            'D' => 25, // Layanan
            'E' => 20, // Total
            'F' => 15, // Status
        ];
    }

    public function title(): string
    {
        return 'Laporan Transaksi';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $summary = $this->summary;

                // Define row numbers based on content
                $titleRow = 1;
                $summaryStartRow = 2;
                $summaryEndRow = $summaryStartRow + count($summary) - 1;
                $blankRow = $summaryEndRow + 1;
                $headerRow = $blankRow + 1;
                $dataStartRow = $headerRow + 1;

                // Insert rows for title, summary, blank row, and header
                // Need to insert headerRow rows before the first data row (which is initially row 1)
                $sheet->insertNewRowBefore(1, $headerRow);

                // Write title
                $sheet->getCell('A' . $titleRow)->setValue($this->title());
                $sheet->getStyle('A' . $titleRow)->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 16,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);
                $sheet->mergeCells('A' . $titleRow . ':F' . $titleRow);
                $sheet->getRowDimension($titleRow)->setRowHeight(30); // Set height for title row

                // Write summary
                $currentRow = $summaryStartRow;
                foreach ($summary as $key => $value) {
                    $sheet->setCellValue('A' . $currentRow, $key . ':');
                    // Format Total Pendapatan as currency
                    if ($key === 'Total Pendapatan') {
                        $sheet->setCellValue('B' . $currentRow, (float) $value);
                        $sheet->getStyle('B' . $currentRow)->getNumberFormat()->setFormatCode('Rp #,##0');
                    } else {
                        $sheet->setCellValue('B' . $currentRow, $value);
                    }

                    $sheet->getStyle('A' . $currentRow)->applyFromArray([
                        'font' => [
                            'bold' => true,
                        ],
                        'alignment' => [
                            'horizontal' => Alignment::HORIZONTAL_RIGHT,
                        ],
                    ]);
                    $sheet->getStyle('B' . $currentRow)->applyFromArray([
                        'alignment' => [
                            'horizontal' => Alignment::HORIZONTAL_LEFT,
                        ],
                    ]);
                    $sheet->getRowDimension($currentRow)->setRowHeight(20); // Set height for summary row
                    $currentRow++;
                }

                // Set height for blank row
                $sheet->getRowDimension($blankRow)->setRowHeight(15); // Set height for blank row

                // Write and style Header (Now at $headerRow)
                $headers = [
                    'No. Order',
                    'Tanggal',
                    'Pelanggan',
                    'Layanan',
                    'Total',
                    'Status',
                ];
                $sheet->fromArray($headers, null, 'A' . $headerRow);

                $sheet->getStyle('A' . $headerRow . ':F' . $headerRow)->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 12, // Meningkatkan ukuran font header
                        'color' => ['rgb' => 'FFFFFF'],
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '059669'], // Warna hijau
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                        ],
                    ],
                ]);
                $sheet->getRowDimension($headerRow)->setRowHeight(30); // Set tinggi baris header

                // Apply styles to Data (Starting from $dataStartRow)
                $lastRow = $sheet->getHighestRow();

                // Apply general data styles (borders, vertical alignment)
                if ($lastRow >= $dataStartRow) {
                    $sheet->getStyle('A' . $dataStartRow . ':F' . $lastRow)->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                            ],
                        ],
                        'alignment' => [
                            'vertical' => Alignment::VERTICAL_CENTER,
                        ],
                    ]);

                    // Style dan format kolom tanggal dan total
                    $sheet->getStyle('B' . $dataStartRow . ':B' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    // $sheet->getStyle('E' . $dataStartRow . ':E' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT); // Already handled by currency format
                    // Format kolom Total sebagai mata uang
                    $sheet->getStyle('E' . $dataStartRow . ':E' . $lastRow)->getNumberFormat()->setFormatCode('Rp #,##0');

                    // Set tinggi baris data
                    for ($i = $dataStartRow; $i <= $lastRow; $i++) {
                        $sheet->getRowDimension($i)->setRowHeight(25);
                    }

                    // Apply color to Status column based on value
                    for ($row = $dataStartRow; $row <= $lastRow; $row++) {
                        $statusValue = strtolower(str_replace(' ', '_', $sheet->getCell('F' . $row)->getValue())); // Get status value and format to lowercase_with_underscore
                        $color = null;
                        $fontColor = '000000'; // Default font color (black)

                        switch ($statusValue) {
                            case 'diterima':
                                $color = 'FEF3C7'; // Light yellow
                                $fontColor = '92400E'; // Dark yellow for text
                                break;
                            case 'diproses':
                                $color = 'DBEAFE'; // Light blue
                                $fontColor = '1E40AF'; // Dark blue for text
                                break;
                            case 'siap_diambil':
                                $color = 'D1FAe5'; // Light green
                                $fontColor = '065F46'; // Dark green for text
                                break;
                            case 'selesai':
                                $color = 'F3F4F6'; // Light gray
                                $fontColor = '374151'; // Dark gray for text
                                break;
                        }

                        if ($color) {
                            $sheet->getStyle('F' . $row)->getFill()->setFillType(Fill::FILL_SOLID)->setStartColor(new Color($color));
                            $sheet->getStyle('F' . $row)->getFont()->setColor(new Color($fontColor));
                            $sheet->getStyle('F' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Center text in colored cell
                        }
                    }
                }

                // --- Add Total Row at the bottom of the data table ---
                $totalRow = $lastRow + 1; // Row after the last data row
                $sheet->setCellValue('D' . $totalRow, 'Total Pendapatan Seluruh Transaksi:'); // Label in column D

                // Calculate total sum from the collection data
                $totalSum = $this->collection()->sum('total_harga');
                $sheet->setCellValue('E' . $totalRow, (float) $totalSum); // Total value in column E

                // Apply styling to the label cell (D)
                $sheet->getStyle('D' . $totalRow)->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_RIGHT, // Align label to the right
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                        ],
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'E5E7EB'], // Light gray background
                    ],
                ]);

                // Apply styling to the total value cell (E)
                $sheet->getStyle('E' . $totalRow)->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                        ],
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'E5E7EB'], // Match background
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_RIGHT, // Align total value to the right
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // Format total sum as currency
                $sheet->getStyle('E' . $totalRow)->getNumberFormat()->setFormatCode('Rp #,##0');

                $sheet->getRowDimension($totalRow)->setRowHeight(25); // Set height for total row

                // Auto size columns
                foreach (range('A', 'F') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }

                // Optional: Freeze header row
                $sheet->freezePane('A' . ($headerRow + 1));
            },
        ];
    }
}
