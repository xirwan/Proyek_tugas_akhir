<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SundaySchoolMember extends Model
{
    use HasFactory;

    protected $table = 'sunday_school_member'; // Nama tabel

    protected $fillable = [
        'member_id',
        'sunday_school_class_id',
    ];

    // Relasi ke Member
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    // Relasi ke Class
    public function class()
    {
        return $this->belongsTo(SundaySchoolClass::class, 'sunday_school_class_id');
    }
}
