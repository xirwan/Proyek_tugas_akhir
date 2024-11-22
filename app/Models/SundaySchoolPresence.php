<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SundaySchoolPresence extends Model
{
    use HasFactory;

    protected $table = 'sunday_school_presences'; // Nama tabel

    protected $fillable = [
        'member_id',
        'check_in',
        'admin_check_in',
        'week_of',  
    ];

    // Relasi: Absensi ini terkait dengan satu anggota (member)
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    // Relasi: Admin yang melakukan check-in manual (opsional)
    public function admin()
    {
        return $this->belongsTo(Member::class, 'admin_check_in');
    }

    
}
