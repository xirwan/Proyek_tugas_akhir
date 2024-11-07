<x-app-layout>
    @if (session('success'))
        <div id="alert" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <x-card>
        <x-slot name="header">
            List Absensi {{ $class->name }}
        </x-slot>
        <form action="{{ route('attendance.manualCheckin', $class->id) }}" method="POST">
        @csrf
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Lengkap</th>
                        <th>Status Kehadiran</th>
                        <th>Checklist Manual</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $index => $student)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $student->firstname }} {{ $student->lastname }}</td>
                            <td>
                                @if (in_array($student->id, $presentStudentIds))
                                    ✔️ Hadir Minggu Ini
                                @else
                                    ❌ Tidak Hadir
                                @endif
                            </td>
                            <td>
                                @if (!in_array($student->id, $presentStudentIds))
                                    <input type="checkbox" name="manual_checkins[]" value="{{ $student->id }}" class="manual-checkin-checkbox">
                                @else
                                    ✔️ Sudah Hadir
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <button type="submit" class="btn btn-primary" id="submit-button" disabled>Simpan Checklist Manual</button>
        </form>
    </x-card>
    <script>
        // JavaScript untuk mengelola status tombol
        document.addEventListener('DOMContentLoaded', function () {
            const checkboxes = document.querySelectorAll('.manual-checkin-checkbox');
            const submitButton = document.getElementById('submit-button');

            // Fungsi untuk mengecek apakah ada checkbox yang dicentang
            function updateButtonStatus() {
                const anyChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
                submitButton.disabled = !anyChecked; // Nonaktifkan tombol jika tidak ada yang dicentang
            }

            // Tambahkan event listener ke semua checkbox
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateButtonStatus);
            });

            // Panggil fungsi untuk memeriksa status awal tombol
            updateButtonStatus();
        });
    </script>
</x-app-layout>