<x-app-layout>
    @if ($errors->any())
        <div id="alert" class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif  
    <form action="{{ route('baptist-class-detail.store', encrypt($baptist->id)) }}" class="form-horizontal form-bordered" method="POST">
        @csrf
        <section class="card">
            <header class="card-header">
                <h2 class="card-title">Buat Detail Pertemuan Pembaptisan</h2>
            </header>
            <div class="card-body">
                <!-- Informasi tentang Tanggal Baptis -->
                <div class="form-group">
                    <label for="baptist_date_info">Tanggal Baptis:</label>
                    <p id="baptist_date_info"><strong>{{ $baptist->date }}</strong></p>
                </div>

                <!-- Input Tanggal Pertemuan -->
                <div class="form-group">
                    <label for="date">Tanggal Pertemuan</label>
                    <input type="date" id="date" name="start_date" class="form-control" required placeholder="Pilih Tanggal Pertemuan">
                    @error('date')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <footer class="card-footer text-right">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="reset" class="btn btn-default">Reset</button>
                <a href="{{ url()->previous() }}" class="btn btn-success">Kembali</a>
            </footer>
        </section>
    </form>
</x-app-layout>