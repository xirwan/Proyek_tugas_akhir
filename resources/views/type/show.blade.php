<x-app-layout>
    @if ($errors->any())
        <div id="alert" class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}
            @endforeach
        </div>
    @endif

    @if(session('success'))
        <div id="alert" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <section class="card">
        <header class="card-header">   
            <h2 class="card-title">Detail Tipe Jadwal</h2>
        </header>
        <form action="{{ route('type.update', encrypt($type->id)) }}" class="form-horizontal form-bordered" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">

                <x-input-text 
                    name="name" 
                    id="inputnama" 
                    label="Nama" 
                    :value="$type->name" 
                    :required="true"
                />

                <x-input-area 
                    name="description" 
                    id="inputdeskripsi" 
                    label="Deskripsi" 
                    :value="$type->description" 
                    :required="true"
                />

                <x-radio 
                    name="status" 
                    label="Status" 
                    :options="['Active' => 'Active', 'Inactive' => 'Inactive']" 
                    :value="$type->status" 
                    :required="true"
                />

            </div>
            <footer class="card-footer text-right">
                <button type="submit" class="btn btn-primary">Edit</button>
        </form>

                @if($type->status === 'Active')
                    <form action="{{ route('type.destroy', encrypt($type->id)) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menonaktifkan data tipe jadwal ini?');">Nonaktifkan</button>
                    </form>
                @else
                    <form action="{{ route('type.activate', encrypt($type->id)) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-secondary" onclick="return confirm('Apakah Anda yakin ingin mengaktifkan kembali data tipe jadwal ini?');">Aktifkan</button>
                    </form>
                @endif

                <a href="{{ url()->previous() }}" class="btn btn-success">Kembali</a>
            </footer>
    </section>
</x-app-layout>