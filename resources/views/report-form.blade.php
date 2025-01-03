    <x-app-layout>
        <x-card>
            <x-slot name="header">
                Cetak Laporan
            </x-slot>

            <form method="GET" action="{{ route('attendance.member.report') }}" target="_blank">
                @csrf
                <div class="mb-3">
                    <label for="start_date" class="form-label">Tanggal Mulai</label>
                    <input type="date" id="start_date" name="start_date" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="end_date" class="form-label">Tanggal Selesai</label>
                    <input type="date" id="end_date" name="end_date" class="form-control" required>
                </div>
                <button type="submit" class="btn" style="background-color: #4CAF50; color: white;">Cetak Laporan</button>
                <button type="reset" class="btn" style="background-color: #FF5733; color: white;">Reset</button>
            </form>
        </x-card>
    </x-app-layout>
