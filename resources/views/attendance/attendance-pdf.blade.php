<!DOCTYPE html>
<html>
<head>
    <title>Laporan Absensi</title>
    <style>
        @page {
            margin-top: 150px;
        }
        header{
            position: fixed;
            left: 0px;
            right: 0px;
            height: 150px;
            margin-top: -150px;
        }
        body {
            font-family: "Times New Roman", Times, serif;
            margin: 0;
            padding: 20px;
        }
        .header {
            overflow: hidden; /* Mencegah masalah float */
            margin-bottom: 20px;
            font-size: 12px;
            border-bottom: 2px solid #036cb3;
            padding-bottom: 10px;
            color: #036cb3; /* Warna biru muda untuk semua teks di header */
        }
        .header img {
            height: 110px;
            float: left; /* Memindahkan logo ke kiri */
            margin-right: 15px;
        }
        .header .text {
            text-align: center;
        }
        .header h1 {
            font-size: 16px;
            margin: 5px 0;
        }
        .header h1.italic {
            font-style: italic; /* Membuat teks italic */
        }
        .header p {
            margin: 2px 0;
            font-size: 10px;
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
        .clear {
            clear: both; /* Menghindari masalah float */
        }
    </style>
</head>
<body>
    <header>
        <div class="header">
            <img src="{{ public_path('admintemp/img/logo.png') }}" alt="Logo">
            <h1>GEREJA BETHEL INDONESIA</h1>
            <p>Badan Hukum Gereja: SK Dirjen Bimas Kristen / Protestan Departemen Agama R.I. No. 41 Tahun 1972 dan SK Dirjen Bimas (Kristen) Protestan Depertemen Agama R.I. No. 211 Tahun 1989 Tgl. 25 November 1989</p>
            <h1 class="italic">Jemaat SUNGAI YORDAN TAMAN RATU INDAH</h1> <!-- Menambahkan class italic -->
            <p>Jl. Taman Ratu Indah Blok D7 No. 1, Taman Ratu Indah, Duri Kepa, Kebon Jeruk, Jakarta 11510</p>
            <p>Telp: 021-56960098 | Email: gbi.sungaiyordan.tamanratuindah@gmail.com</p>
        </div>
    </header>
    <div class="content">
        <h1>Laporan Absensi GBI Sungai Yordan</h1>
        <div class="info">
            <p><strong>Kelas:</strong> {{ $class ? $class->name : 'Semua Kelas' }}</p>
            <p><strong>Minggu:</strong> {{ $weekOf }}</p>
            @if ($mentor)
                <p><strong>Pembina:</strong> {{ $mentor->firstname . ' ' . $mentor->lastname }}</p>
            @endif
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
            @if ($attendanceCountPerChild->isNotEmpty())
                <br>
                <h2>Jumlah Absensi per Anak</h2>
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Murid</th>
                            <th>Jumlah Kehadiran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($attendanceCountPerChild as $memberId => $attendanceCount)
                            @php
                                $member = $presences->firstWhere('member_id', $memberId)->member;
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $member->firstname . ' ' . $member->lastname }}</td>
                                <td>{{ $attendanceCount }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        @else
            <p style="text-align: center; margin-top: 50px; font-size: 16px;">
                Tidak ada data absensi untuk filter yang dipilih.
            </p>
        @endif
    </div>
</body>
</html>