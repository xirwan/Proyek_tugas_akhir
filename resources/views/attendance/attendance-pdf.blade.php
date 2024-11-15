<!DOCTYPE html>
<html>
<head>
    <title>Laporan Absensi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        h1 {
            text-align: center;
        }
        p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <h1>Laporan Absensi</h1>
    <p><strong>Kelas:</strong> {{ $class ? $class->name : 'Semua Kelas' }}</p>
    <p><strong>Minggu:</strong> {{ $weekOf }}</p>

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
                    <td>{{ $presence->check_in }}</td>
                    <td>{{ $presence->week_of }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>