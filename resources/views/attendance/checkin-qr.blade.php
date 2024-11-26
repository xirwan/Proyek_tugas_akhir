{{-- <x-app-layout>
    @if (session('success'))
    <div id="alert" class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
        </div>
    @endif
    <x-card>
        <x-slot name="header">
            Absensi Kelas {{ $class->name }}
            <p>Scan QR Code murid untuk mencatat kehadiran.</p>
        </x-slot>
        <div style="display: flex; justify-content: center; align-items: center;">
            <!-- Div untuk menampilkan hasil scan QR -->
            <div id="qr-reader" style="width: 500px"></div>
            <div id="qr-reader-results"></div>
        
            <!-- Form untuk mengirim hasil scan QR -->
            <form id="checkin-form" action="{{ route('attendance.checkinByClass', $class->id) }}" method="POST" style="display: none;">
                @csrf
                <input type="hidden" name="member_id" id="member-id">
            </form>
        </div>
    </x-card>
    <!-- Script untuk menjalankan pemindaian QR code -->
    <script>
        function onScanSuccess(decodedText, decodedResult) {
            // Tampilkan hasil scan di console
            console.log(`QR Code scanned: ${decodedText}`);
            
            // Set hasil scan ke input hidden dan submit form
            document.getElementById("member-id").value = decodedText;
            document.getElementById("checkin-form").submit();
        }
    
        function onScanFailure(error) {
            // Fungsi ini berjalan ketika scan QR gagal
            console.warn(`Scan failed: ${error}`);
        }
    
        // Inisialisasi Html5QrcodeScanner
        let html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-reader", { fps: 10, qrbox: { width: 250, height: 250 } });

        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    </script>
</x-app-layout> --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Kelas {{ $class->name }}</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    {{-- <script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script> --}}
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
            <a href="{{ route ('attendance.classList') }}" class="btn btn-secondary">Kembali</a>
            <h2>Absensi Kelas {{ $class->name }} ({{ count($absentStudents) }}/{{ count($students) }})</h2>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Scan QR Code</div>
                    <div class="card-body">
                        <div id="qr-reader" style="width: 100%;"></div>
                        <form id="checkin-form" action="{{ route('attendance.checkinByClass', $class->id) }}" method="POST" style="display: none;">
                            @csrf
                            <input type="hidden" name="member_id" id="member-id">
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Daftar Murid yang Sudah Absen</div>
                    <div class="card-body">
                        <ul class="list-group">
                            @forelse ($absentStudents as $student)
                                <li class="list-group-item">{{ $student->firstname }} {{ $student->lastname }}</li>
                            @empty
                                <li class="list-group-item">Belum ada murid yang absen.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{asset('admintemp/js/html5-qrcode.min.js')}}"></script>
    <script>
        function onScanSuccess(decodedText) {
            document.getElementById("member-id").value = decodedText;
            document.getElementById("checkin-form").submit();
        }

        let html5QrcodeScanner = new Html5QrcodeScanner("qr-reader", { fps: 10, qrbox: { width: 250, height: 250 } });
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