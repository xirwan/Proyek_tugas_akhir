<x-app-layout>
    <form action="{{ route('anggota.store') }}" class="form-horizontal form-bordered" method="POST">
        @csrf
        <section class="card">
            <header class="card-header">   
                <h2 class="card-title">Tambah Anggota</h2>
            </header>
            <div class="card-body">            
                
                <x-input-text name="namadepan" id="inputnamadepan" label="Nama Depan" placeholder="Masukan nama depan" :required="true"/>

                <x-input-text name="namabelakang" id="inputnamabelakang" label="Nama Belakang" placeholder="Masukan nama belakang" :required="true"/>
                
                <x-date-picker label="Tanggal Lahir" name="tanggal_lahir" :required="true" max="{{ date('Y-m-d') }}"/>

                <x-radio name="status" label="Status" :options="['Aktif' => 'Aktif', 'Tidak Aktif' => 'Tidak Aktif']" :required="true"/>

                <x-input-area name="deskripsi" id="inputdeskripsi" label="Deskripsi" placeholder="Masukan deskripsi" :required="true"/>

                <x-select-box 
                label="Nama Role" 
                name="role_id" 
                :options="$rolesoptions" 
                placeholder="Pilih Roles" 
                :required="true" 
                />

                <x-select-box 
                label="Nama Cabang" 
                name="cabang_id" 
                :options="$cabangoptions" 
                placeholder="Pilih Cabang" 
                :required="true" 
                />

                <x-input-text name="nama" id="inputnama" label="Username" placeholder="Masukan username" :required="true"/>

                <x-input-text name="email" id="inputnamabelakang" label="Email" placeholder="Masukan email" :required="true"/>

                <x-input-password label="Password" name="password" placeholder="Masukkan password" :required="true" />

            </div>

            <footer class="card-footer text-right">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="reset" class="btn btn-default">Reset</button>
                <a href="{{ url()->previous() }}" class="btn btn-success">Kembali</a>
            </footer>

        </section>
    </form>
</x-app-layout>