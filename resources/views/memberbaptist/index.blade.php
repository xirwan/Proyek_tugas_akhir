<x-user>
    <!-- Notifikasi Pendaftaran -->
    @if ($isAlreadyRegistered)
        <x-card>
            <x-slot name="header">
                Informasi
            </x-slot>    
            Anda sudah mendaftar di jadwal pembaptisan.
        </x-card>
    @else
        <!-- Notifikasi Error -->
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>  
        @endif
        <form action="{{ route('memberbaptist.register') }}" class="form-horizontal form-bordered" method="POST">
            @csrf
            <section class="card">
                <header class="card-header">
                    <h2 class="card-title">Pendaftaran Baptis</h2>
                </header>
                <div class="card-body">
                    {{-- Pilih Jadwal Baptis --}}
                    <div class="form-group">
                        <label for="baptist_id" class="form-label">Pilih Tanggal Pembaptisan</label>
                        <select name="baptist_id" id="baptist_id" class="form-control" required onchange="displayBaptistDetails(this)">
                            <option value="" disabled selected>Pilih Tanggal Pembaptisan</option>
                            @foreach($baptists as $baptist)
                                <option value="{{ $baptist->id }}">{{ $baptist->date }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Pilih Detail Pertemuan (akan diisi berdasarkan pilihan Baptis) --}}
                    <div class="form-group">
                        <label for="baptist_detail_id" class="form-label">Pilih Detail Pertemuan</label>
                        <select name="baptist_detail_id" id="baptist_detail_id" class="form-control" required>
                            <option value="" disabled selected>Pilih Detail Pertemuan</option>
                        </select>
                    </div>
                </div>

                <footer class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">Daftar</button>
                    <button type="reset" class="btn btn-default">Reset</button>
                    <a href="{{ route ('portal') }}" class="btn btn-success">Kembali</a>
                </footer>
            </section>
        </form>
    @endif

    {{-- JavaScript untuk Mengisi Detail Pertemuan --}}
    <script>
        const baptistData = @json($baptists);
        const registeredDetails = @json($registeredDetails);

        function displayBaptistDetails(selectElement) {
            const baptistId = selectElement.value;
            const detailSelect = document.getElementById('baptist_detail_id');

            // Kosongkan opsi detail
            detailSelect.innerHTML = '<option value="" disabled selected>Pilih Detail Pertemuan</option>';

            // Cari data baptist yang dipilih dan isi opsi detail
            const selectedBaptist = baptistData.find(baptist => baptist.id == baptistId);
            if (selectedBaptist) {
                selectedBaptist.details.forEach(detail => {
                    const option = document.createElement('option');
                    option.value = detail.id;
                    option.textContent = `Tanggal: ${detail.date}`;

                    // Disable jika sudah terdaftar
                    if (registeredDetails.includes(detail.id)) {
                        option.disabled = true;
                    }

                    detailSelect.appendChild(option);
                });
            }
        }
    </script>
</x-user>
