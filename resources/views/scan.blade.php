<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan QR Code - Absensi</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <!-- Notifikasi Sukses -->
        @if (session('success'))
            <div id="alert" class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Notifikasi Error -->
        @if ($errors->any())
            <div id="alert" class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="{{ route('portal') }}" class="btn btn-secondary">Kembali</a>
            <h2>Scan QR Code untuk Absensi</h2>
        </div>

        <div class="card">
            <div class="card-header">Kamera</div>
            <div class="card-body">
                <div id="qr-reader" style="width: 100%;"></div>
                <form id="checkin-form" action="{{ route ('attendance.checkin')}}" method="POST" style="display: none;">
                    @csrf
                    <input type="hidden" name="schedule_id" id="schedule-id">
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('admintemp/js/html5-qrcode.min.js') }}"></script>
    <script>
        // Fungsi saat QR code berhasil dipindai
        function onScanSuccess(decodedText) {
            document.getElementById("schedule-id").value = decodedText; // Set hasil QR ke input hidden
            document.getElementById("checkin-form").submit(); // Submit form
        }

        // Inisialisasi scanner QR code
        let html5QrcodeScanner = new Html5QrcodeScanner("qr-reader", {
            fps: 10,
            qrbox: { width: 250, height: 250 }
        });

        html5QrcodeScanner.render(onScanSuccess);
    </script>

    <!-- Script untuk Notifikasi -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const successAlert = document.getElementById('alert');
            if (successAlert) {
                setTimeout(function () {
                    successAlert.style.opacity = 0;
                    setTimeout(function () {
                        successAlert.remove();
                    }, 600);
                }, 3000);
            }

            const errorAlert = document.querySelector('.alert-danger');
            if (errorAlert) {
                setTimeout(function () {
                    errorAlert.style.opacity = 0;
                    setTimeout(function () {
                        errorAlert.remove();
                    }, 600);
                }, 3000);
            }
        });
    </script>
</body>
</html>