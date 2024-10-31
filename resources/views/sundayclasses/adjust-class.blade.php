<x-app-layout>
    <form method="POST" action="{{ route ('sundayschoolclass.adjustClass', encrypt($child->id)) }}">
        @csrf
        <section class="card">
            <header class="card-header">   
                <h2 class="card-title">Penyesuaian Kelas untuk: {{ $child->firstname }} {{ $child->lastname }}</h2>
            </header>
            <div class="card-body">                
                <div class="row form-group d-flex justify-content-center align-items-center">
                    <div class="col-lg-9">
                        <x-select-box 
                        label="Pilih Kelas Baru" 
                        name="class_id" 
                        :options="$classes" 
                        placeholder="Pilih Kelas" 
                        :required="true" 
                        :selected="$child->sundaySchoolClasses->first()->id ?? ''" 
                        />
                    </div>
                </div>
            </div>
            <footer class="card-footer text-right">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="reset" class="btn btn-default">Reset</button>
                <a href="{{ url()->previous() }}" class="btn btn-success">Kembali</a>
            </footer>
        </section>
    </form>
    {{-- <x-card>
        <x-slot name="header">
            Penyesuaian Kelas untuk: {{ $child->firstname }} {{ $child->lastname }}
        </x-slot>
    </x-card>
    <form action="{{ route('sundayschoolclass.adjustClass', $child->id) }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="class_id">Pilih Kelas Baru</label>
            <select name="class_id" id="class_id" class="form-control" required>
                @foreach ($classes as $class)
                    <option value="{{ $class->id }}" {{ $child->sundaySchoolClasses->contains($class->id) ? 'selected' : '' }}>
                        {{ $class->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Simpan Perubahan</button>
    </form>

    <a href="{{ route('sundayschoolclass.viewClassStudents', encrypt($child->sundaySchoolClasses->first()->id ?? 1)) }}" class="btn btn-secondary mt-3">Kembali</a> --}}
</x-app-layout>
