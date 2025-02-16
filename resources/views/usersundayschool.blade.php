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
                        <h4 class="card-title mb-3">Kelas Sekolah Minggu</h4>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Hari</th>
                                        <th>Jam</th>
                                        <th>Nama Kelas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($classes) && $classes->count() > 0)
                                      @foreach($classes as $class)
                                        @foreach($class->schedules as $schedule)
                                          <tr>
                                            {{-- Hari --}}
                                            <td>{{ ucfirst($schedule->day) }}</td>
                  
                                            {{-- Jam --}}
                                            <td>
                                              {{ \Carbon\Carbon::parse($schedule->start)->format('H:i') }}
                                              -
                                              {{ \Carbon\Carbon::parse($schedule->end)->format('H:i') }}
                                            </td>
                  
                                            {{-- Nama Kelas --}}
                                            <td>{{ $class->name }}</td>
                                          </tr>
                                        @endforeach
                                      @endforeach
                                    @else
                                      <tr>
                                        <td colspan="3" class="text-center">
                                          Belum ada jadwal sekolah minggu yang terdaftar.
                                        </td>
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