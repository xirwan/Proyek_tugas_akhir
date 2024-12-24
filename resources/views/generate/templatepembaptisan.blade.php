<!DOCTYPE html>
<html>
<head>
    <title>Sertifikat Pembaptisan</title>
    <style>
        @page {
            size: A4 landscape; /* Mengatur ukuran halaman menjadi A4 landscape */
            margin: 0;
        }
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 50px;
        }
        .certificate {
            border: 5px solid #000;
            padding: 20px;
            width: 90%; /* Sesuaikan lebar agar terlihat proporsional di landscape */
            margin: auto;
            transform: rotate(0deg);
        }
        .certificate h1 {
            font-size: 3rem;
        }
        .certificate p {
            font-size: 1.2rem;
        }
    </style>
</head>
<body>
    <div class="certificate">
        <h1>SERTIFIKAT PEMBAPTISAN</h1>
        <p>Dengan ini diberikan kepada:</p>
        <h2>{{ $participantName }}</h2>
        <p>Atas partisipasinya dalam pembaptisan:</p>
        <h3>Pada tanggal: {{ \Carbon\Carbon::parse($baptistDate)->format('d M Y') }}</h3>
    </div>
</body>
</html>
