<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SundaySchoolClass extends Model
{
    use HasFactory;

    protected $table = 'sunday_school_classes'; // Nama tabel

    protected $fillable = [
        'name',
        'description',
        'status',
    ];

    // Relasi: Kelas ini memiliki banyak anggota melalui sunday_school_member
    public function members()
    {
        return $this->belongsToMany(Member::class, 'sunday_school_members', 'sunday_school_class_id', 'member_id');
    }

    public function schedules()
    {
        return $this->belongsToMany(Schedule::class, 'schedules_sunday_school_class', 'sunday_school_class_id', 'schedule_id');
    }
    
    public function scheduleSundaySchoolClasses()
    {
        return $this->hasMany(ScheduleSundaySchoolClass::class, 'sunday_school_class_id', 'id');
    }

}