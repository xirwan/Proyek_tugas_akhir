<x-app-layout>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <section class="card">
                <header class="card-header">
                    <h2 class="card-title">List Cabang</h2>
                </header>
                <div class="card-body">
                    <a href="{{ route('cabang.create') }}" class="btn btn-md btn-success mb-3">Tambah Cabang</a>
                    <!-- Modal HTML -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Tambah Cabang</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- akhir pop up --}} 
                        <table class="table table-responsive-md mb-0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Deskripsi</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cabangs as $index => $cabang)
                                    <tr>
                                        <td>{{ $cabangs->firstItem() + $index }}</td>
                                        <td>{{ $cabang->nama }}</td>
                                        <td>{{ $cabang->deskripsi }}</td>
                                        <td>{{ $cabang->status }}</td>
                                        <td class="actions">
                                            <a href=""><i class="fas fa-pencil-alt"></i></a>
                                            <a href="" class="delete-row"><i class="far fa-trash-alt"></i></a>
                                        </td>
                                    </tr>
                                @empty
                                <div class="alert alert-danger">
                                    Data Cabang belum tersedia.
                                </div>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="mt-5">
                            {{ $cabangs->links() }}
                        </div>
                </div>
            </section>
        </div>
    </div>
    {{-- <script>
        //message with sweetalert
        @if(session('success'))
            Swal.fire({
                icon: "success",
                title: "BERHASIL",
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000
            });
        @elseif(session('error'))
            Swal.fire({
                icon: "error",
                title: "GAGAL!",
                text: "{{ session('error') }}",
                showConfirmButton: false,
                timer: 2000
            });
        @endif

    </script> --}}
</x-app-layout>
