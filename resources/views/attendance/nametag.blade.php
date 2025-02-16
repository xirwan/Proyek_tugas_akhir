<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Name Tag</title>
    <style>
        /* Body Styling */
        @font-face {
        font-family: 'Patrick Hand';
        font-style: normal;
        font-weight: 400;
        src: url({{ public_path('storage/fonts/PatrickHand.ttf')}}) format("truetype");
        }

        body {
            margin: 0;
            padding: 0;
            text-align: center;
        }

        /* Header Styling */
        .header {
            display: flex;
            justify-content: space-between;
            width: 100%;
            padding: 2px 0;
            border-bottom: 2px solid #000;
        }

        .header img {
            width: 50px;
            height: 50px;
        }

        .title {
            font-family: 'Patrick Hand';
            flex-grow: 1;
            font-size: 16px;
            color: #3498db;
            text-align: center;
            display: inline-block;
        }

        /* Content Styling */
        .content {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .name {
            font-family: 'Patrick Hand';
            font-size: 18px;
        }

        .class {
            font-family: 'Patrick Hand';
            font-size: 16px;
            margin-bottom: 10px;
        }

        /* QR Code Styling */
        .qr-code img {
            width: 120px;
            height: 120px;
        }
    </style>
</head>
<body>
    <div class="header">
        <!-- Logo Gereja di Kiri -->
        <img src="{{ $logoPath }}" alt="Logo Gereja">
        
        <!-- Tulisan di Tengah -->
        <div class="title">Sekolah Minggu <br> GBI Sungai Yordan</div>
        
        <!-- Gambar Anak di Kanan -->
        <img src="{{ $childImage }}" alt="Child Icon">
    </div>

    <div class="content">
        <div class="name">{{ $child->firstname }} {{ $child->lastname }} </div>
        <div class="class">{{ $child->sundaySchoolClasses->first()->name ?? 'Tidak Ada Kelas' }}</div>
    </div>
    
    <div class="qr-code">
        <img src="{{ $qrCodePath }}" alt="QR Code">
    </div>
</body>
</html>
