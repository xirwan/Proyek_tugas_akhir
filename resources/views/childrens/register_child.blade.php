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
                    </div>
                </div>
            </div>
            <footer class="card-footer text-right">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="reset" class="btn btn-default">Reset</button>
                <a href="{{ url()->previous() }}" class="btn btn-success">Kembali</a>
            </footer>
        </section>
        
        {{-- <!-- Nama Depan Anak -->
        <div class="mt-4">
            <x-input-label for="firstname" :value="__('Nama Depan Anak')" />
            <x-text-input id="firstname" class="block mt-1 w-full" type="text" name="firstname" :value="old('firstname')" required autofocus />
            <x-input-error :messages="$errors->get('firstname')" class="mt-2" />
        </div>

        <!-- Nama Belakang Anak -->
        <div class="mt-4">
            <x-input-label for="lastname" :value="__('Nama Belakang Anak')" />
            <x-text-input id="lastname" class="block mt-1 w-full" type="text" name="lastname" :value="old('lastname')" required />
            <x-input-error :messages="$errors->get('lastname')" class="mt-2" />
        </div>

        <!-- Tanggal Lahir Anak -->
        <div class="mt-4">
            <x-input-label for="dateofbirth" :value="__('Tanggal Lahir')" />
            <x-text-input id="dateofbirth" class="block mt-1 w-full" type="date" name="dateofbirth" :value="old('dateofbirth')" max="{{ date('Y-m-d') }}" required />
            <x-input-error :messages="$errors->get('dateofbirth')" class="mt-2" />
        </div>

        <!-- Alamat Anak -->
        <div class="mt-4">
            <x-input-label for="address" :value="__('Alamat')" />
            <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" required />
            <x-input-error :messages="$errors->get('address')" class="mt-2" />
        </div>

        <!-- Pilih Cabang -->
        <div class="mt-4">
            <x-input-label for="branch_id" :value="__('Cabang')" />
            <select name="branch_id" id="branch_id" class="block mt-1 w-full" required>
                <option value="">{{ __('Pilih Cabang') }}</option>
                @foreach ($branchoptions as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('branch_id')" class="mt-2" />
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ml-4">
                {{ __('Daftarkan Anak') }}
            </x-primary-button>
        </div> --}}
    </form>
</x-user>
