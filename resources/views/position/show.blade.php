<x-app-layout>
    @if(session('error'))
        <div id="alert" class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div id="alert" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <section class="card">
        <header class="card-header">   
            <h2 class="card-title">Detail Posisi</h2>
        </header>
        <form action="{{ route('position.update', encrypt($positions->id)) }}" class="form-horizontal form-bordered" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">

                <x-input-text 
                    name="name" 
                    id="inputnama" 
                    label="Nama" 
                    :value="$positions->name" 
                    :required="true"
                />

                <x-input-area 
                    name="description" 
                    id="inputdeskripsi" 
                    label="Deskripsi" 
                    :value="$positions->description" 
                    :required="true"
                />

                <x-radio 
                    name="status" 
                    label="Status" 
                    :options="['Active' => 'Active', 'Inactive' => 'Inactive']" 
                    :value="$positions->status" 
                    :required="true"
                />

            </div>
            <footer class="card-footer text-right">
                <button type="submit" class="btn btn-primary" onclick="return confirm('Apakah Anda yakin ingin mengubah data posisi ini?');">Edit</button>
        </form>

                @if($positions->status === 'Active')
                    <form action="{{ route('position.destroy', encrypt($positions->id)) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menonaktifkan data posisi ini?');">Nonaktifkan</button>
                    </form>
                @else
                    <form action="{{ route('position.activate', encrypt($positions->id)) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-secondary" onclick="return confirm('Apakah Anda yakin ingin mengaktifkan kembali data posisi ini?');">Aktifkan</button>
                    </form>
                @endif

                <a href="{{ route ('position.index') }}" class="btn btn-success">Kembali</a>
            </footer>
    </section>
</x-app-layout>