<x-app-layout>
    <form method="POST" action="{{ route('admin.storeChild') }}">
        @csrf
        <section class="card">
            <header class="card-header">   
                <h2 class="card-title">Daftarkan Anak</h2>
            </header>
            <div class="card-body">
                <!-- Pilih Orang Tua -->
                <div class="row form-group">
                    <div class="col-lg-12">
                        <x-select-box 
                            label="Pilih Orang Tua" 
                            name="parent_id" 
                            :options="$parents" 
                            :required="true" 
                            placeholder="Pilih Orang Tua (Nama & Email)"
                            :selected="old('parent_id')" 
                        />
                        @error('parent_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                
                <!-- Nama Depan dan Nama Belakang -->
                <div class="row form-group">
                    <div class="col-lg-6">
                        <x-input-text name="firstname" id="inputnamadepan" label="Nama Depan" placeholder="Masukkan Nama Depan" :required="true" :errorMessage="$errors->first('firstname')" />
                    </div>
                    <div class="col-lg-6">
                        <x-input-text name="lastname" id="inputnamabelakang" label="Nama Belakang" placeholder="Masukkan Nama Belakang" :required="true" :errorMessage="$errors->first('lastname')" />
                    </div>
                </div>

                <!-- Tanggal Lahir -->
                <div class="row form-group">
                    <div class="col-lg-6">
                        <x-date-picker 
                            label="Tanggal Lahir" 
                            name="dateofbirth" 
                            :required="true" 
                            max="{{ date('Y-m-d') }}" 
                        />
                    </div>
                    
                    <!-- Pilih Relasi -->
                    <div class="col-lg-6">
                        <x-select-box 
                            label="Jenis Relasi" 
                            name="relation_id" 
                            :options="$relationOptions" 
                            placeholder="Pilih Relasi" 
                            :required="true" 
                            :selected="old('relation_id')" 
                        />
                        @error('relation_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <footer class="card-footer text-right">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="reset" class="btn btn-default">Reset</button>
                <a href="{{ route('qr-code.children.list') }}" class="btn btn-success">Kembali</a>
            </footer>
        </section>
    </form>
</x-app-layout>