<x-app-layout>
    <section class="card">
        <header class="card-header">   
            <h2 class="card-title">Detail Kelas Sekolah Minggu</h2>
        </header>
        <form action="{{ route('sunday-classes.update', encrypt($class->id)) }}" class="form-horizontal form-bordered" method="POST">
            @csrf
            @method('PUT')
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="card-body">                
                <div class="row form-group d-flex justify-content-center align-items-center">
                    <div class="col-lg-9">
                        <x-input-text name="name" id="inputnama" label="Nama kelas sekolah minggu" placeholder="Masukan nama kelas sekolah minggu" :value="$class->name" :required="true" :errorMessage="$errors->first('name')"/>
                        <x-input-area name="description" id="inputdeskripsi" label="Deskripsi" placeholder="Masukan deskripsi" :value="$class->description" :required="true"/>
                        <x-radio name="status" label="Status" :options="['Active' => 'Active', 'Inactive' => 'Inactive']" :value="$class->status" :required="true"/> 
                    </div>
                </div>
            </div>
            <footer class="card-footer text-right">
                <button type="submit" class="btn btn-success">Edit</button>
            </form>
                <a href="{{ url()->previous() }}" class="btn btn-primary">Kembali</a>
            </footer>
    </section>
</x-app-layout>