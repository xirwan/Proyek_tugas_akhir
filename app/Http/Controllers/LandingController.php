<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SundaySchoolClass;
use App\Models\Activity;

class LandingController extends Controller
{
    //
    public function landing()
    {
        // Pastikan Model SundayClass dan relasinya sudah di-define:
        // SundayClass -> hasMany -> Schedule
        $classes = SundaySchoolClass::with('schedules')->get();

        // Kirim data ini ke view landing.blade.php
        return view('welcome', compact('classes'));
    }

    public function index()
    {
        // Jika Anda ingin menampilkan semua Activity (termasuk yang belum di-approve), gunakan:
        // $activities = Activity::paginate(9);

        // Jika Anda hanya ingin menampilkan activity yang sudah di-approve, bisa gunakan:
        // (sesuaikan dengan kolom 'status' di model)
        $activities = Activity::where('status', 'Approved')->paginate(9);

        return view('welcomeactivity', compact('activities'));
    }

}
