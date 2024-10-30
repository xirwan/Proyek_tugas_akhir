<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\SundaySchoolPresence;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AttendanceController extends Controller
{
    // Menampilkan daftar anak dengan status QR code
    // public function listChildren()
    // {
    //     // Ambil semua anak dari relasi parents
    //     $children = Member::whereHas('parents')->paginate(3);

    //     return view('attendance.children-list', compact('children'));
    // }
    public function listChildren()
    {
        // Ambil semua anak yang memiliki orang tua dan paginate hasilnya
        $children = Member::whereHas('parents')->paginate(3);

        return view('attendance.children-list', compact('children'));
    }

    // Generate QR code untuk anak tertentu
    public function generateQrForChild($id)
    {
        $child = Member::findOrFail($id);

        // Tentukan nama dan path file QR code
        $fileName = 'qr_' . $child->id . '.png';
        $filePath = storage_path('app/public/qr-codes/' . $fileName);

        // Pastikan folder 'qr-codes' ada
        if (!file_exists(storage_path('app/public/qr-codes'))) {
            mkdir(storage_path('app/public/qr-codes'), 0777, true);
        }

        // Cek apakah QR code sudah ada
        if (!file_exists($filePath)) {
            // Generate URL untuk QR code hanya dengan ID anak
            $url = route('qr-code.checkin', ['id' => $child->id]);

            // Generate dan simpan QR code sebagai gambar PNG
            QrCode::format('png')->size(300)->generate($url, $filePath);

            // Simpan nama file di database (hanya menyimpan path relatif)
            $child->update(['qr_code' => 'qr-codes/' . $fileName]);
        }

        return redirect()->route('qr-code.children.list')
            ->with('success', 'QR Code berhasil di-generate!');
    }


    // Generate QR code untuk semua anak yang belum memilikinya
    public function generateQrForAllChildrenWithoutQr()
    {
        // Ambil semua anak yang belum memiliki QR code
        $childrenWithoutQr = Member::whereHas('parents')
            ->whereNull('qr_code')
            ->get();

        // Generate QR code untuk setiap anak
        foreach ($childrenWithoutQr as $child) {
            $qrUrl = route('qr-code.checkin', ['id' => $child->id]);
            $child->update(['qr_code' => $qrUrl]);
        }

        return redirect()->route('qr-code.children.list')->with('success', 'QR Code berhasil di-generate untuk semua anak!');
    }

    // Fungsi check-in otomatis dengan QR code
    public function checkIn($id)
    {
        // Temukan member berdasarkan ID
        $member = Member::findOrFail($id);

        // Cek apakah member sudah check-in hari ini
        $alreadyCheckedIn = SundaySchoolPresence::where('member_id', $id)
            ->whereDate('check_in', now()->toDateString())
            ->exists();

        if ($alreadyCheckedIn) {
            return redirect()->route('attendance.children.list')
                ->with('info', 'Anak ini sudah melakukan check-in hari ini.');
        }

        // Simpan data kehadiran baru
        SundaySchoolPresence::create([
            'member_id' => $id,
            'check_in' => now(),
        ]);

        return redirect()->route('attendance.children.list')
            ->with('success', 'Check-in berhasil!');
    }
}