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
                            :required="false"
                            :selected="$selectedClassId" 
                        />
                    </div>
                    <div class="col-lg-6">
                        <x-select-box 
                            label="Pilih Minggu" 
                            name="week_of" 
                            :options="$weeks" 
                            placeholder="Pilih Minggu" 
                            :required="true" 
                            :selected="$selectedWeek" 
                        />
                    </div>
                </div>
            </div>
            <footer class="card-footer text-right">
                <button type="submit" class="btn btn-primary">Tampilkan</button>
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
                                <td>{{ $presence->check_in }}</td>
                                <td>{{ $presence->week_of }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <footer class="card-footer d-flex justify-content-between">
                <!-- Pagination Links -->
                {{ $presences->links() }}

                <!-- Export to PDF -->
                <form method="POST" action="{{ route('admin.attendance.export') }}">
                    @csrf
                    <input type="hidden" name="class_id" value="{{ $selectedClassId }}">
                    <input type="hidden" name="week_of" value="{{ $selectedWeek }}">
                    <button type="submit" class="btn btn-success">Ekspor ke PDF</button>
                </form>
            </footer>
        </section>
    @else
        @if (!is_null($selectedClassId) && !is_null($selectedWeek))
            <div class="alert alert-warning mt-3">
                Tidak ada data absensi untuk minggu dan kelas yang dipilih.
            </div>
        @endif
    @endif
</x-app-layout>