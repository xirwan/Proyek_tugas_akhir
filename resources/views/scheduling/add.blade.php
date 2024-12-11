<x-app-layout>
    <!-- Notifikasi Error -->
    @if ($errors->any())
        <div id="alert" class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}
            @endforeach
        </div>
    @endif

    @if(session('error'))
        <div id="alert" class="alert alert-danger">
            {{ session('error') }}
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
                <div class="row form-group">
                    <div class="col-lg-6">
                        <x-input-text 
                            name="year" 
                            label="Tahun" 
                            placeholder="Masukkan Tahun" 
                            :required="true" 
                            :value="request('year', now()->year)"  
                        />
                    </div>
                    <div class="col-lg-6">
                        @if($monthOptions->isNotEmpty())
                            <!-- Pilih Bulan -->
                            <x-select-box 
                                label="Bulan" 
                                name="month" 
                                :options="$monthOptions" 
                                placeholder="Pilih Bulan" 
                                :required="true" 
                                :selected="$selectedMonth" 
                            />
                        @else
                            <div class="form-group">
                                <label for="month">Bulan</label>
                                <select name="month" id="month" class="form-control" disabled>
                                    <option value="">Tidak ada bulan yang tersedia</option>
                                </select>
                            </div>
                        @endif
                    </div>
                </div>
                <!-- Penjadwalan Pembina -->
                <div class="schedule-row mb-2">
                    <x-select-box-ver 
                        label="Member" 
                        name="member_id" 
                        :options="$memberOptions" 
                        placeholder="Pilih Member" 
                        :required="true" 
                    />
                    <x-select-box-ver
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const yearInput = document.querySelector('input[name="year"]');
            const monthSelect = document.querySelector('select[name="month"]');

            if (yearInput) {
                yearInput.addEventListener('change', function() {
                    const year = this.value;
                    const url = new URL(window.location.href);
                    url.searchParams.set('year', year);  // Menambahkan tahun yang dipilih ke URL
                    url.searchParams.delete('month');    // Menghapus bulan saat tahun diubah
                    window.location.href = url.toString();  // Melakukan redirect ke URL yang baru
                });
            }

            if (monthSelect) {
                monthSelect.addEventListener('change', function() {
                    const month = this.value;
                    const year = document.querySelector('input[name="year"]').value;
                    const url = new URL(window.location.href);
                    url.searchParams.set('month', month);  // Menambahkan bulan yang dipilih ke URL
                    url.searchParams.set('year', year);    // Menambahkan tahun yang dipilih ke URL
                    window.location.href = url.toString();  // Melakukan redirect ke URL yang baru
                });
            }
        });
    </script>
</x-app-layout>
