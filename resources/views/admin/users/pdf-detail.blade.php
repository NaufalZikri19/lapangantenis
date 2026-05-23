<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Laporan Booking - {{ $user->name }}</title>

    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.5;
        }

        .header {
            width: 100%;
            border-bottom: 2px solid #EAB308;
            padding-bottom: 15px;
            margin-bottom: 20px;
            text-align: center;
        }

        .header-title {
            font-size: 24px;
            font-weight: bold;
            color: #111827;
            margin: 0;
            text-transform: uppercase;
        }

        .header-subtitle {
            font-size: 14px;
            color: #4B5563;
            margin: 5px 0 0 0;
        }

        .info-container {
            width: 100%;
            margin-bottom: 25px;
        }

        .info-table {
            width: 100%;
            border: none;
        }

        .info-table td {
            padding: 3px 0;
            border: none;
            vertical-align: top;
        }

        .info-label {
            font-weight: bold;
            width: 120px;
            color: #4B5563;
        }

        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .main-table th,
        .main-table td {
            border: 1px solid #D1D5DB;
            padding: 10px 12px;
            text-align: left;
        }

        .main-table th {
            background-color: #F3F4F6;
            color: #374151;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 11px;
        }

        .main-table tbody tr:nth-child(even) {
            background-color: #F9FAFB;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-pending {
            background: #FEF3C7;
            color: #92400E;
        }

        .status-pending_payment {
            background: #FEF3C7;
            color: #92400E;
        }

        .status-pending_verification {
            background: #DBEAFE;
            color: #1E40AF;
        }

        .status-confirmed {
            background: #D1FAE5;
            color: #065F46;
        }

        .status-cancelled {
            background: #FEE2E2;
            color: #991B1B;
        }

        .status-expired {
            background: #F3F4F6;
            color: #374151;
        }

        .footer {
            margin-top: 40px;
            text-align: right;
        }

        .footer p {
            margin: 0 0 40px 0;
        }

        .signature-line {
            display: inline-block;
            width: 150px;
            border-bottom: 1px solid #000;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1 class="header-title">Gumbreg QuickBook</h1>
        <p class="header-subtitle">Laporan Riwayat Booking Lapangan Tenis</p>
    </div>

    <div class="info-container">
        <table class="info-table">
            <tr>
                <td style="width: 15%;" class="info-label">Nama Pelanggan</td>
                <td style="width: 2%;">:</td>
                <td style="width: 33%;">{{ $user->name }}</td>
                <td style="width: 15%;" class="info-label">Tanggal Cetak</td>
                <td style="width: 2%;">:</td>
                <td style="width: 33%;">{{ now()->format('d F Y') }}</td>
            </tr>
            <tr>
                <td class="info-label">Email</td>
                <td>:</td>
                <td>{{ $user->email }}</td>
                <td class="info-label">Total Booking</td>
                <td>:</td>
                <td>{{ $bookings->count() }}</td>
            </tr>
            <tr>
                <td class="info-label">Nomor HP</td>
                <td>:</td>
                <td>{{ $user->phone ?? '-' }}</td>
                <td colspan="3"></td>
            </tr>
        </table>
    </div>

    <table class="main-table">
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="25%">Lapangan</th>
                <th width="20%">Tanggal</th>
                <th width="30%">Waktu</th>
                <th width="20%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bookings as $index => $booking)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $booking->court->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($booking->date)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} -
                            {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}
                        </td>
                        <td>
                @php
                    $statusClass = 'status-' . strtolower($booking->status);
                    $statusText = match (strtolower($booking->status)) {
                        'pending_payment' => 'Menunggu Pembayaran',
                        'pending_verification' => 'Menunggu Verifikasi',
                        'confirmed' => 'Terkonfirmasi',
                        'cancelled' => 'Dibatalkan',
                        'expired' => 'Kedaluwarsa',
                        default => ucfirst($booking->status)
                    };
                @endphp
                            <span class="status-badge {{ $statusClass }}">
                                {{ $statusText }}
                            </span>
                        </td>
                    </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center" style="padding: 20px;">Tidak ada riwayat booking untuk pengguna ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Admin Gumbreg QuickBook</p>
        <br>
        <span class="signature-line"></span>
    </div>

</body>

</html>