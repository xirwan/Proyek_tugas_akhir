<!DOCTYPE html>
<html>
<head>
    <title>Laporan Absensi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
            font-size: 12px;
        }
        th {
            background-color: #f2f2f2;
        }
        h1, h2, p {
            text-align: center;
            margin: 0;
        }
        h1 {
            font-size: 20px;
            margin-bottom: 10px;
        }
        h2 {
            font-size: 18px;
            margin: 5px 0;
        }
        .info {
            margin-top: 10px;
        }
        .info p {
            margin: 5px 0;
            font-size: 14px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Laporan Absensi Sekolah Minggu</h1>
    <div class="info">
        <p><strong>Kelas:</strong> {{ $class ? $class->name : 'Semua Kelas' }}</p>
        <p><strong>Minggu:</strong> {{ $weekOf }}</p>
        <p><strong>Tanggal Cetak:</strong> {{ now()->format('d-m-Y H:i') }}</p>
    </div>

    @if ($presences->isNotEmpty())
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Murid</th>
                    <th>Kelas</th>
                    <th>Check-in</th>
                    <th>Minggu</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($presences as $index => $presence)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $presence->member->firstname . ' ' . $presence->member->lastname }}</td>
                        <td>{{ $presence->member->sundaySchoolClasses->first()->name ?? 'N/A' }}</td>
                        <td>{{ $presence->check_in ? $presence->check_in : 'Tidak Hadir' }}</td>
                        <td>{{ $presence->week_of }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p style="text-align: center; margin-top: 50px; font-size: 16px;">
            Tidak ada data absensi untuk filter yang dipilih.
        </p>
    @endif
</body>
</html>
