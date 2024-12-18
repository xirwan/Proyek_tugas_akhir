<x-user>
    <form method="POST" action="{{ route('member.storeChild') }}">
        @csrf
        <section class="card">
            <header class="card-header">   
                <h2 class="card-title">Daftarkan Anak</h2>
            </header>
            <div class="card-body">                
                <div class="row form-group">
                    <div class="col-lg-6">
                        <x-input-text name="firstname" id="inputnamadepan" label="Nama depan" placeholder="Masukan nama depan" :required="true" :errorMessage="$errors->first('firstname')"/>
                    </div>
                    <div class="col-lg-6">
                        <x-input-text name="lastname" id="inputnamabelakang" label="Nama belakang" placeholder="Masukan nama belakang" :required="true" :errorMessage="$errors->first('lastname')"/>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-6">
                        <x-date-picker label="Tanggal Lahir" name="dateofbirth" :required="true" max="{{ date('Y-m-d') }}"/>
                    </div>
                    <div class="col-lg-6">
                        <x-select-box label="Jenis Relasi" name="relation_id" :options="$relationoptions" placeholder="Pilih Relasi" :required="true" :selected="old('relation_id')" 
                        />
                    </div>
                </div>
            </div>
            <footer class="card-footer text-right">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="reset" class="btn btn-default">Reset</button>
                <a href="{{ route ('member.childrenList') }}" class="btn btn-success">Kembali</a>
            </footer>
        </section>
    </form>
</x-user>