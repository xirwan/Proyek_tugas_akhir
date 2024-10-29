<x-app-layout>
    <section class="card">
        <header class="card-header">   
            <h2 class="card-title">Detail Anggota</h2>
        </header>
        <form action="{{ route('member.update', encrypt($member->id)) }}" class="form-horizontal form-bordered" method="POST">
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
                <div class="row form-group">
                    <div class="col-lg-4">
                        {{-- <x-select-box 
                        label="Nama Role" 
                        name="role_id" 
                        :options="$roleoptions"
                        :selected="$member->role_id" 
                        placeholder="Pilih Role" 
                        :required="true" 
                        /> --}}
                        <x-select-box 
                        label="Nama Role" 
                        name="role_id" 
                        :options="$roleoptions"
                        :selected="$member->user->roles->pluck('id')->first()" 
                        placeholder="Pilih Role" 
                        :required="true" 
                        />
                    </div>
                    <div class="col-lg-4">
                        <x-select-box 
                        label="Nama Posisi" 
                        name="position_id" 
                        :options="$positionoptions" 
                        :selected="$member->position_id"
                        placeholder="Pilih Posisi" 
                        :required="true" 
                        />
                    </div>
                    <div class="col-lg-4">
                        <x-select-box 
                        label="Nama Cabang" 
                        name="branch_id" 
                        :options="$branchoptions"
                        :selected="$member->branch_id" 
                        placeholder="Pilih Cabang" 
                        :required="true" 
                        />
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-6">
                        <x-input-text name="firstname" id="inputnamadepan" label="Nama depan" placeholder="Masukan nama depan" :value="$member->firstname" :required="true" :errorMessage="$errors->first('firstname')"/>
                        <x-input-text name="lastname" id="inputnamabelakang" label="Nama belakang" placeholder="Masukan nama belakang" :value="$member->lastname" :required="true" :errorMessage="$errors->first('lastname')"/>
                        <x-date-picker label="Tanggal Lahir" name="dateofbirth" :value="$member->dateofbirth" :required="true" max="{{ date('Y-m-d') }}"/>
                    </div>
                    <div class="col-lg-6">
                        <x-input-text name="email" id="email" label="Email" placeholder="Masukan email" :required="true" :value="$member->user->email" :errorMessage="$errors->first('email')"/>
                        <x-input-password name="password" label="Password" placeholder="Perbaharui password (opsional)" :errorMessage="$errors->get('password')"/> 
                        <x-radio name="status" label="Status" :options="['Active' => 'Active', 'Inactive' => 'Inactive']" :value="$member->status" :required="true"/>
                    </div>
                </div>
                <div class="form-group">
                    <x-input-area name="address" id="inputalamat" label="Alamat" placeholder="Masukan alamat" :value="$member->address" :required="true"/>
                </div>
            </div>
            <footer class="card-footer text-right">
                <button type="submit" class="btn btn-success">Edit</button>
            </form>
            <form action="{{ route('member.destroy', encrypt($member->id)) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data posisi ini?');">Hapus</button>
            </form>
                <a href="{{ url()->previous() }}" class="btn btn-primary">Kembali</a>
            </footer>
    </section>
</x-app-layout>