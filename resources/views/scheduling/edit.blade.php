<x-app-layout>
    <form method="POST" action="{{ route('scheduling.update', $schedule->id) }}">
        @csrf
        @method('PUT')
        <section>
            <header class="card-header">
                <h2 class="card-title"> Edit Penjadwalan</h2>
            </header>
            <div class="card-body">
                <div class="row form-group">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="schedule_date">Tanggal</label>
                            <input type="text" id="schedule_date" class="form-control" value="{{ $schedule->schedule_date }}" disabled>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="month">Bulan</label>
                            <input type="text" id="month" class="form-control" value="{{ $schedule->monthlySchedule->month }}" disabled>
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="year">Tahun</label>
                            <input type="text" id="year" class="form-control" value="{{ $schedule->monthlySchedule->year }}" disabled>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="member_id">Pembina</label>
                            <select name="member_id" id="member_id" class="form-control">
                                @foreach($members as $member)
                                    <option value="{{ $member->id }}" {{ $schedule->member_id == $member->id ? 'selected' : '' }}>
                                        {{ $member->firstname }} {{ $member->lastname }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('scheduling.index') }}" class="btn btn-success">Kembali</a>
            </div>
        </section>
    </form>
</x-app-layout>