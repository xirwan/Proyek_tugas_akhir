<x-user>
    <form method="POST" action="{{ route('member.storeChild') }}">
        @csrf
        <section class="card">
            <header class="card-header">   
                <h2 class="card-title">Tambah Anak</h2>
            </header>
            <div class="card-body">                
                <div class="row form-group d-flex justify-content-center align-items-center">
                    <div class="col-lg-9">
                        <x-input-text name="firstname" id="inputnamadepan" label="Nama depan" placeholder="Masukan nama depan" :required="true" :errorMessage="$errors->first('firstname')"/>
                        <x-input-text name="lastname" id="inputnamabelakang" label="Nama belakang" placeholder="Masukan nama belakang" :required="true" :errorMessage="$errors->first('lastname')"/>
                        <x-date-picker label="Tanggal Lahir" name="dateofbirth" :required="true" max="{{ date('Y-m-d') }}"/>
                        <x-select-box label="Jenis Relasi" name="relation_id" :options="$relationoptions" placeholder="Pilih Relasi" :required="true" :selected="old('relation_id')" 
                        />
                    </div>
                </div>
            </div>
            <footer class="card-footer text-right">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="reset" class="btn btn-default">Reset</button>
                <a href="{{ url()->previous() }}" class="btn btn-success">Kembali</a>
            </footer>
        </section>
    </form>
</x-user>