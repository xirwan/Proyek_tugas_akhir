<!DOCTYPE html>
<html>
<head>
    <title>Sertifikat</title>
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
        <h1>SERTIFIKAT</h1>
        <p>Dengan ini diberikan kepada:</p>
        <h2>{{ $participantName }}</h2>
        <p>Atas partisipasinya dalam seminar:</p>
        <h3>{{ $seminarName }}</h3>
        <p>Pada tanggal: {{ \Carbon\Carbon::parse($eventDate)->format('d M Y') }}</p>
    </div>
</body>
</html>