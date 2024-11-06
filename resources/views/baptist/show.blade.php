<x-app-layout>
    <section class="card">
        <header class="card-header">   
            <h2 class="card-title">Detail Jadwal Pembaptisan</h2>
        </header>
        <form action="{{ route('baptist.update', encrypt($baptist->id)) }}" class="form-horizontal form-bordered" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <x-date-picker label="Jadwal Pembaptisan" name="date" :value="$baptist->date" :required="true" min="{{ date('Y-m-d') }}"/>
                <x-input-area name="description" id="inputdeskripsi" label="Deskripsi" :value="$baptist->description" :required="false"/>
                <x-radio name="status" label="Status" :options="['Active' => 'Active', 'Inactive' => 'Inactive']" :value="$baptist->status" :required="true"/>
            </div>
            <footer class="card-footer text-right">
                <button type="submit" class="btn btn-success">Edit</button>
                <a href="{{ url()->previous() }}" class="btn btn-primary">Kembali</a>
            </footer>
        </form>
    </section>
</x-app-layout>