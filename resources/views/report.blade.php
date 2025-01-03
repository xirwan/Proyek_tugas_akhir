<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Absensi Remaja</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        h1 {
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Laporan Absensi Remaja</h1>
    <p>Rentang Waktu: {{ $request->start_date }} - {{ $request->end_date }}</p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Waktu Scan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($attendances as $index => $attendance)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $attendance->member->firstname }} {{ $attendance->member->lastname }}</td>
                    <td>{{ \Carbon\Carbon::parse($attendance->scanned_at)->format('Y-m-d H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">Belum ada data absensi</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>