<x-app-layout>
    @if (session('success'))
    <div id="alert" class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
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
</x-app-layout>