<x-user>
    @if (session('success'))
        <div id="alert" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="row">
        <div class="col-lg-6">
            <x-card>
                <x-slot name="header">
                    Profile Update Email
                </x-slot>
                <form action="{{ route('userprofile.update') }}" class="form-horizontal form-bordered" method="POST">
                    @csrf
                    @method('patch')
                    <div class="card-body">
                        <x-input-text name="name" id="inputnama" label="Nama" placeholder="Masukan nama" :required="true" :value="$user->name" :errorMessage="$errors->first('name')"/>
                        <x-input-text name="email" id="inputemail" label="Email" placeholder="Masukan email" :required="true" :value="$user->email" :errorMessage="$errors->first('email')"/>
                    </div>
                    <footer class="card-footer text-right">
                        <button type="submit" class="btn btn-success">Edit</button>
                    </footer>
                </form>
            </x-card>
        </div>
        <div class="col-lg-6">
            <x-card>
                <x-slot name="header">
                    Profile Update Password
                </x-slot>
                <form action="{{ route('password.update') }}" class="form-horizontal form-bordered" method="POST">
                    @csrf
                    @method('put')
                    <div class="card-body">
                        <x-input-password name="current_password" label="Password saat ini" placeholder="Masukan password saat ini" :errorMessage="$errors->updatePassword->get('current_password')"/>
                        <x-input-error :messages="$errors->updatePassword->get('current_password')"/> 
                        <x-input-password name="password" label="Password baru" placeholder="Masukan password baru"/> 
                        <x-input-error :messages="$errors->updatePassword->get('password')"/>
                        <x-input-password name="password_confirmation" label="Konfirmasi password" placeholder="Masukan konfirmasi password"/> 
                        <x-input-error :messages="$errors->updatePassword->get('password_confirmation')"/>
                    </div>
                    <footer class="card-footer text-right">
                        <button type="submit" class="btn btn-success">Edit</button>
                    </footer>
                </form>
                {{-- @include('profile.partials.update-password-form') --}}
            </x-card>
        </div>
    </div>
</x-user>

{{-- @include('profile.partials.update-profile-information-form')
@include('profile.partials.delete-user-form') --}}

{{-- <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
            </div>
        </div>

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
            </div>
        </div>

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
            </div>
        </div>
    </div>
</div> --}}