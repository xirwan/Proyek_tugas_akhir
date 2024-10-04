<x-app-layout>
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
                <button type="submit" class="btn btn-success">Edit</button>
            </form>
            <form action="{{ route('category.destroy', encrypt($category->id)) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data kategori jadwal ini?');">Hapus</button>
            </form>
                <a href="{{ url()->previous() }}" class="btn btn-primary">Kembali</a>
            </footer>
    </section>
</x-app-layout>