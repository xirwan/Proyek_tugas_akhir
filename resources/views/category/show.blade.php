<x-app-layout>
    @if(session('error'))
        <div id="alert" class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    
    <section class="card">
        <header class="card-header">   
            <h2 class="card-title">Detail Kategori jadwal</h2>
        </header>
        <form action="{{ route('category.update', encrypt($category->id)) }}" class="form-horizontal form-bordered" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                    <x-input-text name="name" id="inputnama" label="Nama" :value="$category->name" :required="true"/>
                    <x-input-area name="description" id="inputdeskripsi" label="Deskripsi" :value="$category->description" :required="true"/>
                    <x-radio name="status" label="Status" :options="['Active' => 'Active', 'Inactive' => 'Inactive']" :value="$category->status" :required="true"/>
            </div>
            <footer class="card-footer text-right">
                <button type="submit" class="btn btn-primary">Edit</button>
            </form>
                @if($category->status === 'Active')
                    <form action="{{ route('category.destroy', encrypt($category->id)) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menonaktifkan data kategori jadwal ini?');">Nonaktifkan</button>
                    </form>
                @else
                    <form action="{{ route('category.activate', encrypt($category->id)) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-secondary" onclick="return confirm('Apakah Anda yakin ingin mengaktifkan kembali data kategori jadwal ini?');">Aktifkan</button>
                    </form>
                @endif
                <a href="{{ url()->previous() }}" class="btn btn-success">Kembali</a>
            </footer>
    </section>
</x-app-layout>