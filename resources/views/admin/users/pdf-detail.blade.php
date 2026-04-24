<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Laporan Booking</title>

    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 5px;
        }

        p {
            text-align: center;
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 6px;
            text-align: center;
        }

        th {
            background: #f3f3f3;
        }
    </style>
</head>

<body>

    <h2>LAPORAN BOOKING USER</h2>
    <p>{{ $user->name }}</p>
    <p>Tanggal: {{ now()->format('d M Y') }}</p>
    <p>Total Booking: {{ $bookings->count() }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Lapangan</th>
                <th>Tanggal</th>
                <th>Jam</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            @forelse($bookings as $index => $booking)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $booking->court->name }}</td>
                    <td>{{ $booking->date }}</td>
                    <td>{{ $booking->start_time }} - {{ $booking->end_time }}</td>
                    <td>{{ ucfirst($booking->status) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Tidak ada data booking</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>

</html>