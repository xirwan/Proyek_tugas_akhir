<x-user>

    @if (session('success'))
        <div id="alert" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (auth()->user()->hasRole('Jemaat'))
        <div class="row">
            <div class="col-md-12 mt-4">
                <section class="card card-featured-primary h-100">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Jadwal Ibadah</h4>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Nama Jadwal</th>
                                        <th>Tipe</th>
                                        <th>Kategori</th>
                                        <th>Hari</th>
                                        <th>Jam</th>
                                        <th>Deskripsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($schedules) && $schedules->count() > 0)
                                        @foreach($schedules as $schedule)
                                            <tr>
                                                <td>{{ $schedule->name ?? '-' }}</td>
                                                <td>{{ $schedule->type->name ?? '-' }}</td>
                                                <td>{{ $schedule->category->name ?? '-' }}</td>
                                                <td>{{ ucfirst($schedule->day) }}</td>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($schedule->start)->format('H:i') }} -
                                                    {{ \Carbon\Carbon::parse($schedule->end)->format('H:i') }}
                                                </td>
                                                <td>{{ $schedule->description ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center">Belum ada jadwal yang tersedia.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>        
    @endif
</x-user>