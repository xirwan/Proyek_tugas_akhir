<x-app-layout>
    <!-- Notifikasi Error -->
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- Form Filter -->
    <form method="GET" action="{{ route('admin.attendance.history') }}" class="form-horizontal form-bordered">
        @csrf
        <section class="card">
            <header class="card-header">
                <h2 class="card-title">Riwayat Absensi</h2>
            </header>
            <div class="card-body">
                <div class="row form-group">
                    <div class="col-lg-6">
                        <x-select-box 
                            label="Pilih Kelas" 
                            name="class_id" 
                            :options="$classes->pluck('name', 'id')->prepend('Semua Kelas', 'all')" 
                            placeholder="Pilih Kelas" 
                            :required="true"
                            :selected="$selectedClassId" 
                        />
                    </div>
                    <div class="col-lg-6">
                        <x-select-box 
                            label="Pilih Minggu" 
                            name="week_of" 
                            id="week_of" 
                            :options="$weeks" 
                            placeholder="Pilih Minggu" 
                            :required="false" 
                            :selected="$selectedWeek" 
                        />
                    </div>
                </div>
                <!-- Checkbox untuk menggunakan rentang tanggal -->
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="use_date_range" name="use_date_range" value="1" {{ request('use_date_range') ? 'checked' : '' }}>
                        <label class="form-check-label" for="use_date_range">Gunakan Rentang Tanggal</label>
                    </div>
                </div>
                <!-- Input Rentang Tanggal -->
                <div class="row form-group" id="date_range_fields" style="display: {{ request('use_date_range') ? 'flex' : 'none' }}">
                    <div class="col-lg-6">
                        <label for="start_date">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date') }}">
                    </div>
                    <div class="col-lg-6">
                        <label for="end_date">Tanggal Akhir</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date') }}">
                    </div>
                </div>
            </div>
            <footer class="card-footer text-right">
                <button type="submit" class="btn btn-primary">Tampilkan</button>
                <button type="button" class="btn btn-secondary" id="resetButton">Reset</button>
            </footer>            
        </section>
    </form>

    <!-- Tabel Data Absensi -->
    @if($presences->isNotEmpty())
        <section class="card mt-3">
            <header class="card-header">
                <h2 class="card-title">Daftar Absensi</h2>
            </header>
            <div class="card-body">
                <table class="table table-bordered">
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
                                <td>{{ $presences->firstItem() + $index }}</td>
                                <td>{{ $presence->member->firstname . ' ' . $presence->member->lastname }}</td>
                                <td>{{ $presence->member->sundaySchoolClasses->first()->name ?? 'N/A' }}</td>
                                <td>
                                    @if ($presence->check_in)
                                        {{ $presence->check_in }}
                                    @else
                                        Tidak Hadir
                                    @endif
                                </td>
                                <td>{{ $presence->week_of }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <footer class="card-footer">
                {{ $presences->links() }}

                <form method="POST" action="{{ route('admin.attendance.export') }}" target="_blank">
                    @csrf
                    <input type="hidden" name="class_id" value="{{ $selectedClassId }}">
                    <input type="hidden" name="week_of" value="{{ $selectedWeek }}">
                    <input type="hidden" name="start_date" value="{{ request('start_date') }}">
                    <input type="hidden" name="end_date" value="{{ request('end_date') }}">
                    <button type="submit" class="btn btn-success">Ekspor ke PDF</button>
                </form>
            </footer>
        </section>
    @else
        @if (request()->has('class_id') || request()->has('week_of') || request()->has('use_date_range'))
            <div class="alert alert-warning mt-3">
                Tidak ada data absensi untuk kriteria yang dipilih.
            </div>
        @endif
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const useDateRangeCheckbox = document.getElementById('use_date_range');
            const dateRangeFields = document.getElementById('date_range_fields');
            const weekOfField = document.getElementById('week_of');
            const resetButton = document.getElementById('resetButton');
            const form = document.querySelector('form');
    
            // Fungsi untuk toggle visibilitas rentang tanggal
            const toggleDateRangeFields = () => {
                if (useDateRangeCheckbox.checked) {
                    dateRangeFields.style.display = 'flex'; // Tampilkan rentang tanggal
                    weekOfField.setAttribute('disabled', 'disabled'); // Nonaktifkan pilihan minggu
                } else {
                    dateRangeFields.style.display = 'none'; // Sembunyikan rentang tanggal
                    weekOfField.removeAttribute('disabled'); // Aktifkan kembali pilihan minggu
                }
            };
    
            // Event listener untuk perubahan checkbox
            useDateRangeCheckbox.addEventListener('change', toggleDateRangeFields);
    
            // Event listener untuk tombol reset
            // Event listener untuk tombol reset
            resetButton.addEventListener('click', function () {
                form.reset(); // Reset semua input dalam form
                weekOfField.removeAttribute('disabled'); // Pastikan pilihan minggu aktif kembali
                dateRangeFields.style.display = 'none'; // Sembunyikan rentang tanggal
                useDateRangeCheckbox.checked = false; // Set checkbox menjadi unchecked
            });
            // Panggil fungsi saat halaman dimuat
            toggleDateRangeFields();
        });
    </script>    
</x-app-layout>