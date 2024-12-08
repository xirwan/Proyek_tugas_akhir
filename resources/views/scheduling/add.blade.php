<x-app-layout>
    <!-- Notifikasi Error -->
    @if ($errors->any())
        <div id="alert" class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}
            @endforeach
        </div>
    @endif

    <!-- Form Tambah Penjadwalan -->
    <form action="{{ route('scheduling.store')}}" class="form-horizontal form-bordered" method="POST">
        @csrf
        <section class="card">
            <header class="card-header">
                <h2 class="card-title">Tambah Penjadwalan Bulanan</h2>
            </header>
            <div class="card-body">
                <!-- Pilih Bulan -->
                <x-select-box 
                    label="Bulan" 
                    name="month" 
                    :options="$monthOptions" 
                    placeholder="Pilih Bulan" 
                    :required="true" 
                    :selected="old('month')" 
                />

                <!-- Pilih Tahun -->
                <x-input-text 
                    name="year" 
                    label="Tahun" 
                    placeholder="Masukkan Tahun" 
                    :required="true" 
                    :value="old('year', now()->year)" 
                />

                <!-- Penjadwalan Pembina -->
                        <!-- Row Jadwal Pembina -->
                        <div class="schedule-row mb-2">
                            <!-- Member ID -->
                            <x-select-box 
                                label="Member" 
                                name="member_id" 
                                :options="$memberOptions" 
                                placeholder="Pilih Member" 
                                :required="true" 
                            />
                            <!-- Schedule Sunday School Class ID -->
                            <x-select-box 
                                label="Kelas" 
                                name="class_id" 
                                :options="$scheduleClassOptions" 
                                placeholder="Pilih Kelas" 
                                :required="true" 
                            />
                        </div>                        
            </div>
            <footer class="card-footer text-right">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="reset" class="btn btn-default">Reset</button>
                <a href="{{ route('scheduling.index') }}" class="btn btn-success">Kembali</a>
            </footer>
        </section>
    </form>
</x-app-layout>