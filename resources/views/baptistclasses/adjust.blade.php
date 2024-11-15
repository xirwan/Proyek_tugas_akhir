<x-app-layout>
    <form method="POST" action="{{ route('baptist-classes.adjustClass', encrypt($memberBaptist->id)) }}">
        @csrf
        <section class="card">
            <header class="card-header">
                <h2 class="card-title">Penyesuaian Kelas untuk: {{ $memberBaptist->member->firstname }} {{ $memberBaptist->member->lastname }}</h2>
            </header>
            <div class="card-body">
                <div class="form-group">
                    <label for="class_id">Pilih Kelas Baru</label>
                    <select name="class_id" id="class_id" class="form-control" required>
                        @foreach ($classes as $id => $formattedName)
                            <option value="{{ $id }}" {{ $id == $memberBaptist->id_baptist_class ? 'selected' : '' }}>
                                {{ $formattedName }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <footer class="card-footer text-right">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ url()->previous() }}" class="btn btn-success">Kembali</a>
            </footer>
        </section>
    </form>
</x-app-layout>
