    @php
        use Illuminate\Support\Facades\Auth;
        use Carbon\Carbon;
        use App\Models\Activity;

        $user = Auth::user()->load('member.children');
        $firstname = $user->member->firstname ?? 'Nama Depan';
        $lastname = $user->member->lastname ?? 'Nama Belakang';

        $activitiesCount = Activity::where('status', 'Approved')
            ->whereDate('start_date', '>=', Carbon::now()->toDateString())
            ->count();

        $hour = Carbon::now()->format('H');

        if ($hour < 12) {
            $greeting = "Selamat Pagi";
        } elseif ($hour < 15) {
            $greeting = "Selamat Siang";
        } elseif ($hour < 18) {
            $greeting = "Selamat Sore";
        } else {
            $greeting = "Selamat Malam";
        }
    @endphp
<x-user>

    @if (session('success'))
        <div id="alert" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Title & Description -->

    <div class="text-black mb-4">
        <h3>{{ $greeting }}, <span class="text-primary">{{ $firstname }} {{ $lastname }}!</span></h3>
    </div>
    @if (auth()->user()->hasRole('Jemaat'))
        <div class="row">
            <div class="col-md-6 mt-2">
                <section class="card card-featured-left card-featured-primary h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="widget-summary">
                            <div class="widget-summary-col widget-summary-col-icon">
                                <div class="summary-icon bg-primary">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                            <div class="widget-summary-col">
                                <div class="summary">
                                    <h4 class="title mb-2">Data Anak</h4>
                                    <div class="info">
                                        <strong class="amount badge bg-info text-dark px-3 py-2 rounded-pill">
                                            {{ $user->member->children->count() }}
                                        </strong>
                                    </div>
                                </div>
                                <div class="summary-footer mt-2">
                                    <a class="text-uppercase small fw-bold btn btn-link p-0" href="{{ route('member.childrenList') }}">Lihat Data Anak</a>
                                </div>
                            </div>                              
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-md-6 mt-2">
                <section class="card card-featured-left card-featured-primary h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="widget-summary">
                            <div class="widget-summary-col widget-summary-col-icon">
                                <div class="summary-icon bg-primary">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                            </div>
                            <div class="widget-summary-col">
                                <div class="summary">
                                    <h4 class="title mb-2">Kegiatan</h4>
                                    <div class="info">
                                        <strong class="amount badge bg-info text-dark px-3 py-2 rounded-pill">
                                            {{ $activitiesCount ?? 0 }}
                                        </strong>
                                    </div>
                                </div>
                                <div class="summary-footer mt-2">
                                    <a class="text-uppercase small fw-bold btn btn-link p-0" href="{{ route('activities.parent.index') }}">Lihat Kegiatan</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <section class="card card-featured-left card-featured-quaternary h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="widget-summary">
                            <div class="widget-summary-col widget-summary-col-icon">
                                <div class="summary-icon bg-quaternary">
                                    <i class="fas fa-user-check"></i>
                                </div>
                            </div>
                            <div class="widget-summary-col">
                                <div class="summary">
                                    <h4 class="title mb-2">Absensi Anak</h4>
                                </div>
                                <div class="summary-footer mt-2">
                                    <a class="text-uppercase small fw-bold btn btn-link p-0" href="{{ route('attendance.parentView') }}">Lihat Absensi</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
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
    @if (auth()->user()->hasRole('JemaatRemaja'))
        <div class="row">
            <div class="col-md-6 mt-2">
                <section class="card card-featured-left card-featured-primary h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="widget-summary">
                            <div class="widget-summary-col widget-summary-col-icon">
                                <div class="summary-icon bg-primary">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                            <div class="widget-summary-col">
                                <div class="summary">
                                    <h4 class="title mb-2">Pengajuan Keanggotaan</h4>
                                </div>
                                <div class="summary-footer mt-2">
                                    <a class="text-uppercase small fw-bold btn btn-link p-0" href="{{url ('certifications/upload')}}">Ajukan Keanggotaan</a>
                                </div>
                            </div>                              
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-md-6 mt-2">
                <section class="card card-featured-left card-featured-primary h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="widget-summary">
                            <div class="widget-summary-col widget-summary-col-icon">
                                <div class="summary-icon bg-primary">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                            </div>
                            <div class="widget-summary-col">
                                <div class="summary">
                                    <h4 class="title mb-2">Kegiatan</h4>
                                    <div class="info">
                                        <strong class="amount badge bg-info text-dark px-3 py-2 rounded-pill">
                                            {{ $activitiesCount ?? 0 }}
                                        </strong>
                                    </div>
                                </div>
                                <div class="summary-footer mt-2">
                                    <a class="text-uppercase small fw-bold btn btn-link p-0" href="{{ route('activities.parent.index') }}">Lihat Kegiatan</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <section class="card card-featured-left card-featured-quaternary h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="widget-summary">
                            <div class="widget-summary-col widget-summary-col-icon">
                                <div class="summary-icon bg-quaternary">
                                    <i class="fas fa-user-check"></i>
                                </div>
                            </div>
                            <div class="widget-summary-col">
                                <div class="summary">
                                    <h4 class="title mb-2">Absensi</h4>
                                </div>
                                <div class="summary-footer mt-2">
                                    <a class="text-uppercase small fw-bold btn btn-link p-0" href="{{ route('attendance.member.scan') }}">Scans</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    @endif
</x-user>