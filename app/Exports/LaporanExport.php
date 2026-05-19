<?php

namespace App\Exports;

use App\Models\Booking;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LaporanExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Booking::with(['user', 'package'])->latest()->get();
    }

    public function headings(): array
    {
        return [
            'No', 'Nama Customer', 'Email', 'Paket',
            'Tipe', 'Tanggal', 'Status', 'Status Bayar', 'Total (Rp)'
        ];
    }

    public function map($row): array
    {
        static $no = 0;
        $no++;
        return [
            $no,
            $row->name,
            $row->email,
            $row->package->name ?? '-',
            ucfirst($row->type),
            $row->booking_date,
            ucfirst($row->status),
            ucfirst($row->payment_status),
            number_format($row->total_price, 0, ',', '.'),
        ];
    }
}