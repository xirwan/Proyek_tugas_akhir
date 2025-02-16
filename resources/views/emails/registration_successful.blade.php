<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Kegiatan Berhasil</title>
    <style>
        /* Reset beberapa style default */
        body, h1, p {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
        }

        /* Styling untuk email container */
        .email-container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #f4f4f4;
            padding: 20px;
            border-radius: 8px;
        }

        /* Styling untuk header */
        .email-header {
            text-align: center;
            padding: 20px 0;
        }

        /* Styling untuk logo */
        .email-logo img {
            max-width: 100px;
            border-radius: 50%;
        }

        /* Styling untuk email content */
        .email-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
        }

        .email-content h1 {
            color: #2c3e50;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .email-content p {
            font-size: 16px;
            color: #34495e;
            line-height: 1.6;
        }

        .email-footer {
            text-align: center;
            font-size: 12px;
            color: #7f8c8d;
            margin-top: 30px;
        }

        .email-footer p {
            margin-top: 10px;
        }

        /* Styling untuk button */
        .cta-button {
            display: inline-block;
            background-color: #2980b9;
            color: #fff;
            padding: 12px 20px;
            text-decoration: none;
            font-weight: bold;
            border-radius: 4px;
            margin-top: 20px;
        }

        .cta-button:hover {
            background-color: #1c5985;
        }
    </style>
</head>
<body>

    <div class="email-container">
        <!-- Header dengan logo organisasi -->
        <div class="email-header">
            <div class="email-logo">
                <img src="{{ $message->embed(public_path() . "/admintemp/img/logo.png") }}" alt="Logo Organisasi">
            </div>
        </div>

        <!-- Konten email -->
        <div class="email-content">
            <h1>Pendaftaran Kegiatan Berhasil</h1>
            <p>Selamat! Anda telah berhasil mendaftar untuk kegiatan <strong>{{ $activity->title }}</strong>.</p>
            <p>Harap segera melakukan pembayaran untuk melanjutkan proses pendaftaran. Berikut adalah detail kegiatan Anda:</p>

            <ul>
                <li><strong>Nama Kegiatan:</strong> {{ $activity->title }}</li>
                <li><strong>Deskripsi:</strong> {{ $activity->description }}</li>
                <li><strong>Tanggal Mulai:</strong> {{ \Carbon\Carbon::parse($activity->start_date)->format('d-m-Y') }}</li>
                <li><strong>Tanggal Batas Pembayaran:</strong> {{ \Carbon\Carbon::parse($activity->payment_deadline)->format('d-m-Y') }}</li>
            </ul>
        </div>

        <!-- Footer email -->
        <div class="email-footer">
            <p>Jika Anda memiliki pertanyaan, jangan ragu untuk menghubungi kami di <strong>gbi.sungaiyordan.tamanratuindah@gmail.com</strong>.</p>
            <p>&copy; {{ date('Y') }} GBI Sungai Yordan. All rights reserved.</p>
        </div>
    </div>

</body>
</html>
