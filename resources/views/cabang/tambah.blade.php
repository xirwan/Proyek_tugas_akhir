<x-app-layout>
    <div class="row">
        <div class="col">
            <form action="{{ route('cabang.store') }}" class="form-horizontal form-bordered" method="POST">
                @csrf
                <section class="card">
                    <header class="card-header">   
                        <h2 class="card-title">Tambah Cabang</h2>
                    </header>
                    <div class="card-body">

                            <div class="form-group row col-lg-6">
                                <label class="col-lg-3 control-label text-lg-right pt-2" for="inputnama">Nama</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" name="nama" placeholder="Masukan nama cabang" id="inputnama" value="{{ old ('nama') }}" required>
                                </div>
                            </div>
        
                            <div class="form-group row col-lg-6">
                                <label class="col-lg-3 control-label text-lg-right pt-2" for="inputalamat">Alamat</label>
                                <div class="col-lg-9">
                                    <textarea class="form-control" rows="3" name="alamat" id="inputalamat" placeholder="Masukan alamat cabang" required>{{ old ('alamat') }}</textarea>
                                </div>
                            </div>

                            <div class="form-group row col-lg-6">
                                <label class="col-lg-3 control-label text-lg-right pt-2" for="inputstatus">Status</label>
                                <div class="col-lg-9">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="status" id="inputstatus" value="Aktif" {{ old('status') == 'Aktif' ? 'checked' : ''}}>
                                            Aktif
                                        </label>
                                    </div>
        
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="status" id="inputstatus1" value="Tidak Aktif" {{ old('status') == 'Tidak Aktif' ? 'checked' : ''}}>
                                            Tidak Aktif
                                        </label>
                                    </div>
                                </div>
                            </div>
                    </div>

                    <footer class="card-footer text-right">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="reset" class="btn btn-default">Reset</button>
                    </footer>

                </section>
            </form>
        </div>
    </div>
</x-app-layout>