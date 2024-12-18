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
            <h2 class="card-title">Detail Cabang</h2>
        </header>
        <form action="{{ route('branch.update', encrypt($branch->id)) }}" class="form-horizontal form-bordered" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">

                <x-input-text 
                    name="name" 
                    id="inputnama" 
                    label="Nama" 
                    :value="$branch->name" 
                    :required="true"
                />

                <x-input-area 
                    name="address" 
                    id="inputalamat" 
                    label="Alamat" 
                    :value="$branch->address" 
                    :required="true"
                />

                <x-radio 
                    name="status" 
                    label="Status" 
                    :options="['Active' => 'Active', 'Inactive' => 'Inactive']" 
                    :value="$branch->status" 
                    :required="true"
                />

            </div>
            <footer class="card-footer text-right">
                <button type="submit" class="btn btn-primary">Edit</button>
        </form>
                @if($branch->status === 'Active')
                    <form action="{{ route('branch.destroy', encrypt($branch->id)) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menonaktikan data cabang ini?');">Nonaktifkan</button>
                    </form>
                @else
                    <form action="{{ route('branch.activate', encrypt($branch->id)) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-secondary" onclick="return confirm('Apakah Anda yakin ingin mengaktifkan kembali data cabang ini?');">Aktifkan</button>
                    </form>
                @endif
                <a href="{{ url()->previous() }}" class="btn btn-success">Kembali</a>
            </footer>
    </section>
</x-app-layout>