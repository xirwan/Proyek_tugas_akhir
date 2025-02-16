<!-- pdf.member-report.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Laporan Anggota</title>
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
    <h1>Laporan Anggota</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Depan</th>
                <th>Nama Belakang</th>
                <th>Tanggal Lahir</th>
                <th>Email</th>
                <th>Posisi</th>
                <th>Status</th>
                <th>Alamat</th>
                <th>Nama Orang Tua</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($members as $index => $member)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $member->firstname }}</td>
                    <td>{{ $member->lastname }}</td>
                    <td>{{ $member->dateofbirth }}</td>
                    <td>{{ $member->user->email ?? 'N/A' }}</td>
                    <td>{{ $member->position->name }}</td>
                    <td>{{ $member->status }}</td>
                    <td>{{ $member->address }}</td>
                    <!-- Menampilkan nama orang tua jika anggota adalah anak -->
                    <td>
                        @if($member->parents->isNotEmpty())
                            {{ $member->parents->first()->firstname }} {{ $member->parents->first()->lastname }}
                        @else
                            N/A
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
