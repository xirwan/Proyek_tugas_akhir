<x-user>
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}
            @endforeach
        </div>
    @endif
    @if (session('success'))
        <div id="alert" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <section class="card">
        <header class="card-header">
            <h2 class="card-title">Unggah Sertifikat</h2>
        </header>
        <div class="card-body">
            {{-- Tampilkan status berdasarkan kondisi --}}
            @if ($certification)
                @if ($certification->seminar_certified && $certification->baptism_certified)
                    <div class="alert alert-success">
                        Status Keanggotaan: Telah Diverifikasi.
                    </div>
                @elseif ($certification->rejection_reason)
                    <div class="alert alert-danger">
                        Verifikasi Ditolak: {{ $certification->rejection_reason }}.<br>
                        Silakan unggah ulang sertifikat.
                    </div>
                @else
                    <div class="alert alert-info">
                        Status Keanggotaan: Dalam Proses Verifikasi.                        
                    </div>
                @endif
            @endif

            {{-- Form upload hanya jika tidak dalam proses verifikasi --}}
            @if (!$certification || $certification->rejection_reason)
                <form action="{{ route('certifications.upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{-- Input untuk Sertifikat Seminar --}}
                    <x-input-file 
                        name="seminar_file" 
                        label="Upload Sertifikat Seminar (Max: 2 MB)" 
                        accept=".pdf,.jpg,.png" 
                        :required="!$certification"
                    />

                    {{-- Input untuk Sertifikat Baptis --}}
                    <x-input-file 
                        name="baptism_file" 
                        label="Upload Sertifikat Baptis (Max: 2 MB)" 
                        accept=".pdf,.jpg,.png" 
                        :required="!$certification"
                    />

                    <footer class="card-footer text-right">
                        <button type="submit" class="btn btn-primary">Unggah</button>
                        <button type="reset" class="btn btn-default">Reset</button>
                        <a href="{{ url()->previous() }}" class="btn btn-success">Kembali</a>
                    </footer>
                </form>
            @endif
        </div>
    </section>
</x-user>