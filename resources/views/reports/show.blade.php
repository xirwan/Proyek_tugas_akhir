<x-app-layout>
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}
            @endforeach
        </div>
    @endif

    <form action="{{ route('admin.reports.update', $report->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <section class="card">
            <header class="card-header">
                <h2 class="card-title">Edit Laporan Kegiatan Sekolah Minggu</h2>
            </header>
            <div class="card-body">
                <div class="row form-group">
                    <!-- Kelas -->
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label">Kelas</label>
                            <p class="form-control-plaintext">{{ $report->sundaySchoolClass->name }}</p>
                        </div>
                    </div>
                    <!-- Minggu -->
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label">Minggu</label>
                            <p class="form-control-plaintext">{{ $report->week_of }}</p>
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <!-- Judul -->
                    <div class="col-lg-6">
                        <x-input-text 
                            name="title" 
                            label="Judul Laporan" 
                            placeholder="Masukkan judul" 
                            :value="$report->title" 
                            :required="true" 
                        />
                    </div>
                    <!-- Deskripsi -->
                    <div class="col-lg-6">
                        <x-input-area 
                            name="description" 
                            label="Deskripsi Laporan" 
                            placeholder="Masukkan deskripsi kegiatan (opsional)" 
                            :value="$report->description" 
                        />
                    </div>
                </div>
                <!-- File -->
                <div class="form-group">
                    <x-input-file 
                        name="file" 
                        label="Upload File Laporan (Max: 2 MB)" 
                        accept=".pdf,.doc,.docx,.jpg,.png" 
                    />
                    @if($report->file_path)
                        <p>File Saat Ini: 
                            <a href="{{ route('admin.reports.download', $report->id) }}" target="_blank">
                                {{ basename($report->file_path) }}
                            </a>
                        </p>
                    @endif
                </div>
            </div>
            <footer class="card-footer text-right">
                <button type="submit" class="btn btn-primary">Perbarui</button>
                <a href="{{ route('admin.reports.index') }}" class="btn btn-success">Kembali</a>
            </footer>
        </section>
    </form>
</x-app-layout>
