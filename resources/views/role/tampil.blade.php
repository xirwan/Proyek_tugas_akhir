<x-app-layout>

    {{-- <div class="ml-4 mt-16 w-9/12">
        <form action="{{route('role.update', encrypt($role->id))}}" method="POST">
            @csrf
            @method('PUT')
            <h1 class="text-3xl mt-4 mb-8"> Update Role </h1>

            <div class="mb-6">
                <label for="text" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Role Name</label>
                <input type="text" value="{{old('name',$role->name ?? '')}}" name="name" id="email" class="bg-gray-50 w-80 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 " placeholder="Wedding, Kitty kat, parties, lol deaths haha" >
                
                @foreach ($errors->get('name') as $error)
                    <p class="text-red-600">{{$error}}</p>
                @endforeach
            </div>

            <table class="permissionTable border rounded-md bg-white overflow-hidden shadow-lg my-4 p-4">
                <th class="px-4 py-4">
                    {{__('Section')}}
                </th>

                <th class="px-4 py-4">
                    <label>
                        <input class="grand_selectall" type="checkbox">
                        {{__('Select All') }}
                    </label>
                </th>

                <th class="px-4 py-4">
                    {{__("Available permissions")}}
                </th>



                <tbody>
                @foreach($permissions as $key => $group)
                    <tr class="py-8">
                        <td class="p-6">
                            <b>{{ ucfirst($key) }}</b>
                        </td>
                        <td class="p-6" width="30%">
                            <label>
                                <input class="selectall" type="checkbox">
                                {{__('Select All') }}
                            </label>
                        </td>
                        <td class="p-6">

                            @forelse($group as $permission)

                            <label style="width: 30%" class="">
                                <input  {{ $role->permissions->contains('id',$permission->id) ? "checked" : "" }} name="permissions[]" class="permissioncheckbox" class="rounded-md border" type="checkbox" value="{{ $permission->id }}">
                                {{$permission->name}} &nbsp;&nbsp;
                            </label>

                            @empty
                                {{ __("No permission in this group !") }}
                            @endforelse

                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>


            <button type="submit" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 ">
                Update Role
            </button>
        </form>
    </div> --}}

    {{-- <section class="card">
        <header class="card-header">   
            <h2 class="card-title">Detail Role</h2>
        </header>
        <form action="{{ route('role.update', encrypt($role->id)) }}" class="form-horizontal form-bordered" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">

                    <x-input-text name="nama" id="inputnama" label="Nama" :value="$role->name" :required="true"/>

            </div>
            <footer class="card-footer text-right">
                <button type="submit" class="btn btn-success">Edit</button>
            </form>
            <form action="{{ route('role.destroy', encrypt($role->id)) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data role ini?');">Hapus</button>
            </form>
                <a href="{{ url()->previous() }}" class="btn btn-primary">Kembali</a>
            </footer>
    </section> --}}

        @if ($errors->any())
        <div id="alert" class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    Nama role sudah ada
                @endforeach
        </div>
        @endif
        <form action="{{ route('role.update', encrypt($role->id)) }}" class="form-horizontal form-bordered" method="POST">
            @csrf
            @method('PUT') <!-- Method PUT untuk update data -->
    
            <section class="card">
                <header class="card-header">   
                    <h2 class="card-title">Edit Role</h2>
                </header>
    
                <div class="card-body">
                    <!-- Input text untuk nama role -->
                    <x-input-text name="name" id="inputnama" label="Nama" placeholder="Masukan nama role" :value="$role->name" :required="true"/>
                </div>
    
                <div class="card-body">
                    <table class="table table-responsive-md mb-0 text-center">
                        <thead>
                            <tr>
                                <th>Kategori</th>
                                <th>Pilih semua</th>
                                <th>Daftar akses</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($permissions as $key => $group)
                                <tr>
                                    <td>
                                        <b>{{ ucfirst($key) }}</b>
                                    </td>
                                    <td>
                                        <label>
                                            <input class="selectall" type="checkbox">
                                            {{__('Pilih semua') }}
                                        </label>
                                    </td>
                                    <td>
                                        @forelse($group as $permission)
                
                                        <label>
                                            <!-- Checkbox permission yang sudah dicentang jika role memiliki permission tersebut -->
                                            <input name="permissions[]" class="permissioncheckbox" type="checkbox" value="{{ $permission->id }}"
                                            {{ $role->permissions->contains($permission) ? 'checked' : '' }}>
                                            {{$permission->name}} &nbsp;&nbsp;
                                        </label>
                
                                        @empty
                                            {{ __("No permission in this group !") }}
                                        @endforelse
                
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
    
                <footer class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">Edit</button>
                </form>
                <form action="{{ route('role.destroy', encrypt($role->id)) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data role ini?');">Hapus</button>
                </form>
                <a href="{{ route('role.index') }}" class="btn btn-default">Kembali</a>
            </footer>
    
            </section>
    
        <script>
            // Event listener untuk checkbox "Pilih Semua"
            document.querySelectorAll('.selectall').forEach(selectAllCheckbox => {
                selectAllCheckbox.addEventListener('change', function() {
                    // Dapatkan semua checkbox permission pada baris yang sama
                    let parentRow = this.closest('tr');
                    let permissionCheckboxes = parentRow.querySelectorAll('.permissioncheckbox');
        
                    // Jika "Pilih Semua" dicentang, centang semua permission checkbox
                    permissionCheckboxes.forEach(checkbox => {
                        checkbox.checked = this.checked;
                    });
                });
            });
        </script>
    

</x-app-layout>