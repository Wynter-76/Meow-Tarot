<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Meow Tarot</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 11px; color: #333; }

        .header { text-align: center; padding: 20px 0 15px; border-bottom: 2px solid #333; margin-bottom: 20px; }
        .header h1 { font-size: 20px; font-weight: bold; }
        .header p  { font-size: 11px; color: #666; margin-top: 4px; }

        .summary { display: flex; gap: 10px; margin-bottom: 20px; }
        .summary-box {
            flex: 1; border: 1px solid #ddd; border-radius: 6px;
            padding: 10px 14px; text-align: center;
        }
        .summary-box .label { font-size: 9px; color: #888; text-transform: uppercase; letter-spacing: 1px; }
        .summary-box .value { font-size: 15px; font-weight: bold; margin-top: 4px; }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        thead tr { background: #1a1a2e; color: #fff; }
        th { padding: 8px 6px; text-align: left; font-size: 10px; }
        td { padding: 7px 6px; font-size: 10px; border-bottom: 1px solid #eee; }
        tr:nth-child(even) td { background: #f9f9f9; }

        .badge { padding: 2px 8px; border-radius: 10px; font-size: 9px; font-weight: bold; }
        .badge-success { background: #d4edda; color: #155724; }
        .badge-warning { background: #fff3cd; color: #856404; }
        .badge-danger  { background: #f8d7da; color: #721c24; }
        .badge-info    { background: #d1ecf1; color: #0c5460; }
        .badge-secondary { background: #e2e3e5; color: #383d41; }

        tfoot td { font-weight: bold; border-top: 2px solid #333; background: #f0f0f0; }
        .footer { margin-top: 30px; font-size: 10px; color: #aaa; text-align: right; }
    </style>
</head>
<body>

    <div class="header">
        <h1>LAPORAN TRANSAKSI — MEOW TAROT</h1>
        <p>Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i') }} WIB</p>
    </div>

    <table style="width:100%; margin-bottom:20px; border:none;">
        <tr>
            <td style="width:25%; border:1px solid #ddd; border-radius:6px; padding:10px; text-align:center;">
                <div style="font-size:9px;color:#888;text-transform:uppercase;">Total Transaksi</div>
                <div style="font-size:16px;font-weight:bold;">{{ $bookings->count() }}</div>
            </td>
            <td style="width:5%;"></td>
            <td style="width:25%; border:1px solid #ddd; border-radius:6px; padding:10px; text-align:center;">
                <div style="font-size:9px;color:#888;text-transform:uppercase;">Total Revenue</div>
                <div style="font-size:14px;font-weight:bold;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
            </td>
            <td style="width:5%;"></td>
            <td style="width:25%; border:1px solid #ddd; border-radius:6px; padding:10px; text-align:center;">
                <div style="font-size:9px;color:#888;text-transform:uppercase;">Lunas</div>
                <div style="font-size:16px;font-weight:bold;">{{ $bookings->where('payment_status','paid')->count() }}</div>
            </td>
            <td style="width:5%;"></td>
            <td style="width:25%; border:1px solid #ddd; border-radius:6px; padding:10px; text-align:center;">
                <div style="font-size:9px;color:#888;text-transform:uppercase;">Pending</div>
                <div style="font-size:16px;font-weight:bold;">{{ $bookings->where('payment_status','pending')->count() }}</div>
            </td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Customer</th>
                <th>Email</th>
                <th>Paket</th>
                <th>Tipe</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Status Bayar</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bookings as $i => $b)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $b->name }}</td>
                <td>{{ $b->email }}</td>
                <td>{{ $b->package->name ?? '-' }}</td>
                <td>{{ ucfirst($b->type) }}</td>
                <td>{{ $b->booking_date }}</td>
                <td>
                    @php
                        $sc = match($b->status) {
                            'pending'   => 'warning',
                            'scheduled' => 'info',
                            'done'      => 'success',
                            'cancelled' => 'danger',
                            default     => 'secondary'
                        };
                    @endphp
                    <span class="badge badge-{{ $sc }}">{{ ucfirst($b->status) }}</span>
                </td>
                <td>
                    @php
                        $pc = match($b->payment_status) {
                            'paid'    => 'success',
                            'pending' => 'warning',
                            'failed'  => 'danger',
                            default   => 'secondary'
                        };
                    @endphp
                    <span class="badge badge-{{ $pc }}">{{ ucfirst($b->payment_status) }}</span>
                </td>
                <td>Rp {{ number_format($b->total_price, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="9" style="text-align:center; color:#aaa;">Belum ada transaksi</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="8" style="text-align:right;">Total Revenue (Paid):</td>
                <td>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">Meow Tarot &copy; {{ date('Y') }} — Dokumen ini dibuat secara otomatis oleh sistem.</div>

</body>
</html>