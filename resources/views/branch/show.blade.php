<x-app-layout>
    <section class="card">
        <header class="card-header">   
            <h2 class="card-title">Detail Cabang</h2>
        </header>
        <form action="{{ route('branch.update', encrypt($branch->id)) }}" class="form-horizontal form-bordered" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">

                    <x-input-text name="name" id="inputnama" label="Nama" :value="$branch->name" :required="true"/>

                    <x-input-area name="address" id="inputalamat" label="Alamat" :value="$branch->address" :required="true"/>

                    <x-radio name="status" label="Status" :options="['Active' => 'Active', 'Inactive' => 'Inactive']" :value="$branch->status" :required="true"/>

            </div>
            <footer class="card-footer text-right">
                <button type="submit" class="btn btn-success">Edit</button>
            </form>
            <form action="{{ route('branch.destroy', encrypt($branch->id)) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data cabang ini?');">Hapus</button>
            </form>
                <a href="{{ url()->previous() }}" class="btn btn-primary">Kembali</a>
            </footer>
    </section>
</x-app-layout>