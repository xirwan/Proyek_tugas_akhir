<x-app-layout>
    <section class="card">
        <header class="card-header">   
            <h2 class="card-title">Detail Anggota</h2>
        </header>
        <form action="{{ route('anggota.update', encrypt($anggotas->id)) }}" class="form-horizontal form-bordered" method="POST">
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

                <x-input-text name="namadepan" id="inputnamadepan" label="Nama Depan" placeholder="Masukan nama depan" :value="$anggotas->nama_depan" :required="true"/>

                <x-input-text name="namabelakang" id="inputnamabelakang" label="Nama Belakang" placeholder="Masukan nama belakang" :value="$anggotas->nama_belakang" :required="true"/>
                
                <x-date-picker label="Tanggal Lahir" name="tanggal_lahir" :value="$anggotas->tanggal_lahir" :required="true" max="{{ date('Y-m-d') }}"/>

                <x-radio name="status" label="Status" :options="['Aktif' => 'Aktif', 'Tidak Aktif' => 'Tidak Aktif']" :value="$anggotas->status" :required="true"/>

                <x-input-area name="deskripsi" id="inputdeskripsi" label="Deskripsi" placeholder="Masukan deskripsi" :value="$anggotas->deskripsi" :required="true"/>

                <x-select-box 
                label="Nama Role" 
                name="role_id" 
                :options="$roleoptions"
                :selected="$anggotas->roles_id" 
                placeholder="Pilih Role" 
                :required="true" 
                />

                <x-select-box 
                label="Nama Posisi" 
                name="posisi_id" 
                :options="$positionoptions" 
                :selected="$anggotas->positions_id"
                placeholder="Pilih Posisi" 
                :required="true" 
                />
                    
                <x-select-box 
                label="Nama Cabang" 
                name="cabang_id" 
                :options="$cabangoptions"
                :selected="$anggotas->cabang_id" 
                placeholder="Pilih Cabang" 
                :required="true" 
                />

                <x-input-text name="nama" id="inputnama" label="Username" placeholder="Masukan username" :value="$anggotas->user->name" :required="true"/>

                <x-input-text name="email" id="inputnamabelakang" label="Email" placeholder="Masukan email" :value="$anggotas->user->email" :required="true"/>
                
                <x-input-password name="password" label="Password"  placeholder="Perbaharui password (opsional)"/>

            </div>
            <footer class="card-footer text-right">
                <button type="submit" class="btn btn-success">Edit</button>
            </form>
            <form action="{{ route('anggota.destroy', encrypt($anggotas->id)) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data posisi ini?');">Hapus</button>
            </form>
                <a href="{{ url()->previous() }}" class="btn btn-primary">Kembali</a>
            </footer>
    </section>
</x-app-layout>