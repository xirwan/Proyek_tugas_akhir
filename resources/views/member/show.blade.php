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
                    <div class="col-lg-6">
                        <x-select-box 
                        label="Nama Posisi" 
                        name="position_id" 
                        :options="$positionoptions" 
                        :selected="$member->position_id"
                        placeholder="Pilih Posisi" 
                        :required="true" 
                        />
                    </div>
                    <div class="col-lg-6">
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
                        @if($member->user)
                            <x-input-text name="email" id="email" label="Email" placeholder="Masukan email" :required="true" :value="$member->user->email" :errorMessage="$errors->first('email')"/>
                            <x-input-password name="password" label="Password" placeholder="Perbaharui password (opsional)" :errorMessage="$errors->get('password')"/> 
                        @else
                            <x-input-text name="email" id="email" label="Email" placeholder="Masukan email" :required="true" :value="'Member ini belum memiliki akun. Email tidak bisa diubah'" :readonly="true" :errorMessage="$errors->first('email')"/>
                            <x-input-text 
                            name="warning" 
                            id="warning" 
                            label="Password" 
                            placeholder="Informasi" 
                            :value="'Member ini belum memiliki akun. Password tidak bisa diubah.'" 
                            :readonly="true" />
                        @endif
                        <x-radio name="status" label="Status" :options="['Active' => 'Active', 'Inactive' => 'Inactive']" :value="$member->status" :required="true"/>
                    </div>
                </div>
                <div class="form-group">
                    <x-input-area name="address" id="inputalamat" label="Alamat" placeholder="Masukan alamat" :value="$member->address" :required="true"/>
                </div>
            </div>
            <footer class="card-footer text-right">
                <button type="submit" class="btn btn-primary">Edit</button>
            </form>

            <!-- Tombol Nonaktifkan atau Aktifkan -->
            @if($member->status === 'Active')
                <form action="{{ route('member.destroy', encrypt($member->id)) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menonaktifkan data member ini?');">Nonaktifkan</button>
                </form>
            @else
                <form action="{{ route('member.active', encrypt($member->id)) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-secondary" onclick="return confirm('Apakah Anda yakin ingin mengaktifkan kembali data member ini?');">Aktifkan</button>
                </form>
            @endif

            <a href="{{ route('member.index') }}" class="btn btn-success">Kembali</a>
            </footer>
    </section>
</x-app-layout>