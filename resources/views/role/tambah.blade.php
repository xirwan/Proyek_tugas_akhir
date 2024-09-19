<x-app-layout>
    @if ($errors->any())
    <div id="alert" class="alert alert-danger">
            @foreach ($errors->all() as $error)
                Nama role sudah ada
            @endforeach
    </div>
    @endif
    <form action="{{ route('role.store') }}" class="form-horizontal form-bordered" method="POST">
        @csrf
        <section class="card">
            <header class="card-header">   
                <h2 class="card-title">Tambah Role</h2>
            </header>
            <div class="card-body">

                <x-input-text name="name" id="inputnama" label="Nama" placeholder="Masukan nama role" :required="true"/>

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
                                        <input name="permissions[]" class="permissioncheckbox" class="rounded-md border" type="checkbox" value="{{ $permission->id }}">
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
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="reset" class="btn btn-default">Reset</button>
                <a href="{{ url()->previous() }}" class="btn btn-success">Kembali</a>
            </footer>

        </section>
    </form>
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