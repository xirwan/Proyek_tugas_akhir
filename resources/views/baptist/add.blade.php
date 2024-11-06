<x-app-layout>
    <form action="{{ route('baptist.store') }}" class="form-horizontal form-bordered" method="POST">
        @csrf
        <section class="card">
            <header class="card-header">   
                <h2 class="card-title">Tambah Jadwal Pembaptisan</h2>
            </header>
            <div class="card-body">
                <x-date-picker label="Jadwal Pembaptisan" name="date" :required="true" min="{{ date('Y-m-d') }}"/>
                <x-input-area name="description" id="inputdeskripsi" label="Deskripsi" placeholder="Masukan deskripsi Pembaptisan" :required="false"/>
            </div>
            <footer class="card-footer text-right">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="reset" class="btn btn-default">Reset</button>
                <a href="{{ url()->previous() }}" class="btn btn-success">Kembali</a>
            </footer>
        </section>
    </form>
</x-app-layout>