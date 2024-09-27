<x-app-layout>
    <form action="{{ route('anggota.store') }}" class="form-horizontal form-bordered" method="POST">
        @csrf

        <section class="card">
            <header class="card-header">   
                <h2 class="card-title">Tambah Anggota</h2>
            </header>
            <div class="card-body">                
                <div class="row form-group">
                    <div class="col-lg-6">
                        <x-input-text name="namadepan" id="inputnamadepan" label="Nama depan" placeholder="Masukan nama depan" :required="true" :errorMessage="$errors->first('namadepan')"/>

                        <x-input-text name="namabelakang" id="inputnamabelakang" label="Nama belakang" placeholder="Masukan nama belakang" :required="true" :errorMessage="$errors->first('namabelakang')"/>

                        <x-date-picker label="Tanggal Lahir" name="tanggal_lahir" :required="true" max="{{ date('Y-m-d') }}"/>

                    </div>
                    <div class="col-lg-6">

                        <x-input-text name="nama" id="inputnama" label="Username" placeholder="Masukan username" :required="true"/>

                        <x-input-text name="email" id="email" label="Email" placeholder="Masukan email" :required="true" :errorMessage="$errors->first('email')"/>

                        <x-input-password name="password" label="Password" placeholder="Masukan password" :required="true" :errorMessage="$errors->get('password')"/>

                    </div>
                </div>
                <div class="form-group">
                    <x-input-area name="deskripsi" id="inputdeskripsi" label="Deskripsi" placeholder="Masukan deskripsi" :required="true"/> 
                </div>
                <div class="row form-group">
                    <div class="col-lg-4">

                        <x-select-box 
                        label="Nama Role" 
                        name="role_id" 
                        :options="$roleoptions" 
                        placeholder="Pilih Role" 
                        :required="true"
                        :selected="old('role_id')" 
                        />

                    </div>
                    <div class="col-lg-4">

                        <x-select-box 
                        label="Nama Posisi" 
                        name="posisi_id" 
                        :options="$positionoptions" 
                        placeholder="Pilih Posisi" 
                        :required="true" 
                        :selected="old('posisi_id')" 
                        />

                    </div>
                    <div class="col-lg-4">

                        <x-select-box 
                        label="Nama Cabang" 
                        name="cabang_id" 
                        :options="$cabangoptions" 
                        placeholder="Pilih Cabang" 
                        :required="true" 
                        :selected="old('cabang_id')" 
                        />

                    </div>
                </div>
                <div class="form-group">

                    <x-radio name="status" label="Status" :options="['Aktif' => 'Aktif', 'Tidak Aktif' => 'Tidak Aktif']" :required="true"/>
                        
                </div>
            </div>
            <footer class="card-footer text-right">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="reset" class="btn btn-default">Reset</button>
                <a href="{{ url()->previous() }}" class="btn btn-success">Kembali</a>
            </footer>
        </section>
    </form>
</x-app-layout>