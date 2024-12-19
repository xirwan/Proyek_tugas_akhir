<x-app-layout>
    <form action="{{ route('member.store') }}" class="form-horizontal form-bordered" method="POST">
        @csrf
        <section class="card">
            <header class="card-header">   
                <h2 class="card-title">Tambah Anggota</h2>
            </header>
            <div class="card-body">                
                <div class="row form-group">
                    {{-- <div class="col-lg-4">
                        <x-select-box 
                        label="Nama Role" 
                        name="role_id" 
                        :options="$roleoptions" 
                        placeholder="Pilih Role" 
                        :required="true"
                        :selected="old('role_id')" 
                        />
                    </div> --}}
                    <div class="col-lg-6">
                        <x-select-box 
                        label="Nama Posisi" 
                        name="position_id" 
                        :options="$positionoptions" 
                        placeholder="Pilih Posisi" 
                        :required="true" 
                        :selected="old('posisi_id')" 
                        />
                    </div>
                    <div class="col-lg-6">
                        <x-select-box 
                        label="Nama Cabang" 
                        name="branch_id" 
                        :options="$branchoptions" 
                        placeholder="Pilih Cabang" 
                        :required="true" 
                        :selected="old('cabang_id')" 
                        />
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-6">
                        <x-input-text name="firstname" id="inputnamadepan" label="Nama depan" placeholder="Masukan nama depan" :required="true" :errorMessage="$errors->first('firstname')"/>
                        <x-input-text name="lastname" id="inputnamabelakang" label="Nama belakang" placeholder="Masukan nama belakang" :required="true" :errorMessage="$errors->first('lastname')"/>
                        <x-date-picker label="Tanggal Lahir" name="dateofbirth" :required="true" max="{{ date('Y-m-d') }}"/>
                    </div>
                    <div class="col-lg-6">
                        <x-input-text name="email" id="email" label="Email" placeholder="Masukan email" :required="true" :errorMessage="$errors->first('email')"/>
                        <x-input-password name="password" label="Password" placeholder="Masukan password" :required="true" :errorMessage="$errors->get('password')"/>
                        <x-input-area name="address" id="inputalamat" label="Alamat" placeholder="Masukan alamat" :required="true"/> 
                    </div>
                </div>
            </div>
            <footer class="card-footer text-right">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="reset" class="btn btn-default">Reset</button>
                <a href="{{ route ('member.index') }}" class="btn btn-success">Kembali</a>
            </footer>
        </section>
    </form>
</x-app-layout>