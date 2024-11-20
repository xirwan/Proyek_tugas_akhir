<x-user>
    <form method="POST" action="{{ route('member.storeChildAccount', encrypt($child->id)) }}">
        @csrf

        <section class="card">
            <header class="card-header">   
                <h2 class="card-title">Akun Anak</h2>
            </header>
            <div class="card-body">                
                <div class="row form-group d-flex justify-content-center align-items-center">
                    <div class="col-lg-9">
                        <x-input-text 
                            name="fullname" 
                            id="fullname" 
                            label="Nama Lengkap" 
                            placeholder="Nama Lengkap Anak" 
                            :value="$child->firstname . ' ' . $child->lastname" 
                            :readonly="true" 
                        />
                        <x-input-text name="email" id="email" label="Email" placeholder="Masukan email" :required="true" :errorMessage="$errors->first('email')"/>
                        <small class="form-text text-muted mt-2">
                            <i>Password akun anak akan mengikuti <b>tanggal lahir</b> dalam format: <b>YYYYMMDD</b>.</i>
                        </small>
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
