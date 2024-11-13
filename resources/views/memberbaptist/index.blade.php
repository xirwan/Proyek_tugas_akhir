{{-- resources/views/memberbaptist/index.blade.php --}}

<x-user>
    <!-- Notifikasi Pendaftaran -->
    @if ($isAlreadyRegistered)
        <x-card>
            <x-slot name="header">
                Informasi
            </x-slot>    
            Anda sudah mendaftar di kelas pembaptisan.
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
                    {{-- Pilih Baptist --}}
                    <div class="form-group">
                        <label for="baptist_id" class="form-label">Pilih Baptist</label>
                        <select name="baptist_id" id="baptist_id" class="form-control" required onchange="displayBaptistClasses(this)">
                            <option value="" disabled selected>Pilih Baptist</option>
                            @foreach($baptists as $baptist)
                                <option value="{{ $baptist->id }}">{{ $baptist->date }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Pilih Kelas Baptist (akan diisi berdasarkan pilihan Baptist) --}}
                    <div class="form-group">
                        <label for="baptist_class_id" class="form-label">Pilih Kelas Baptist</label>
                        <select name="baptist_class_id" id="baptist_class_id" class="form-control" required>
                            <option value="" disabled selected>Pilih Kelas Baptist</option>
                        </select>
                    </div>
                </div>

                <footer class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">Daftar</button>
                    <button type="reset" class="btn btn-default">Reset</button>
                    <a href="{{ url()->previous() }}" class="btn btn-success">Kembali</a>
                </footer>
            </section>
        </form>
    @endif

        {{-- Menambahkan data pendaftaran kelas yang sudah diambil oleh pengguna ke JavaScript --}}
        <script>
            // Data kelas Baptist dari Blade ke JavaScript
            const baptistData = @json($baptists);
            // Daftar kelas yang sudah didaftarkan oleh pengguna yang sedang login
            const registeredClasses = @json($registeredClasses);

            function displayBaptistClasses(selectElement) {
                const baptistId = selectElement.value;
                const classSelect = document.getElementById('baptist_class_id');
                
                // Kosongkan pilihan kelas
                classSelect.innerHTML = '<option value="">Pilih Kelas Baptist</option>';

                // Cari data Baptist yang dipilih dan isi opsi kelas
                const selectedBaptist = baptistData.find(baptist => baptist.id == baptistId);
                if (selectedBaptist) {
                    selectedBaptist.classes.forEach(classItem => {
                        const option = document.createElement('option');
                        option.value = classItem.id;

                        // Format nama kelas dengan hari dan waktu
                        const timeInfo = `(${classItem.start} - ${classItem.end})`;
                        option.textContent = `${classItem.day} ${timeInfo}`;

                        // Cek apakah kelas ini sudah didaftarkan, jika ya, disable option
                        if (registeredClasses.includes(classItem.id)) {
                            option.disabled = true;
                        }

                        classSelect.appendChild(option);
                    });
                }   
            }
        </script>
</x-user>
