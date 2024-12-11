<x-user>
    <form method="POST" action="{{ route('member.updateChild', $child->id) }}">
        @csrf
        @method('PATCH')
        <section class="card">
            <header class="card-header">   
                <h2 class="card-title">Update Data Anak</h2>
            </header>
            <div class="card-body">                
                <div class="row form-group">
                    <div class="col-lg-6">
                        <x-input-text 
                            name="firstname" 
                            id="inputnamadepan" 
                            label="Nama depan" 
                            placeholder="Masukan nama depan" 
                            :value="old('firstname', $child->firstname)" 
                            :required="true" 
                            :errorMessage="$errors->first('firstname')"
                        />
                    </div>
                    <div class="col-lg-6">
                        <x-input-text 
                            name="lastname" 
                            id="inputnamabelakang" 
                            label="Nama belakang" 
                            placeholder="Masukan nama belakang" 
                            :value="old('lastname', $child->lastname)" 
                            :required="true" 
                            :errorMessage="$errors->first('lastname')"
                        />
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-6">
                        <x-input-text 
                            name="address" 
                            id="inputalamat" 
                            label="Alamat" 
                            placeholder="Masukan alamat" 
                            :value="old('address', $child->address)" 
                            :required="true" 
                            :errorMessage="$errors->first('address')"
                        />
                    </div>
                    <div class="col-lg-6">
                        <x-date-picker 
                            label="Tanggal Lahir" 
                            name="dateofbirth" 
                            :value="old('dateofbirth', $child->dateofbirth)" 
                            :required="true" 
                            max="{{ date('Y-m-d') }}"
                        />
                    </div>
                </div>
                <x-select-box label="Jenis Relasi" name="relation_id" :options="$relationoptions" placeholder="Pilih Relasi" :required="true" :selected="old('relation_id', $relationId)" />
            </div>
            <footer class="card-footer text-right">
                <button type="submit" class="btn btn-primary">Update</button>
                <button type="reset" class="btn btn-default">Reset</button>
                <a href="{{ route ('member.childrenList') }}" class="btn btn-success">Kembali</a>
            </footer>
        </section>
    </form>
</x-user>
