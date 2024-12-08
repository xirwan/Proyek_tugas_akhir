<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleSundaySchoolClass extends Model
{
    use HasFactory;
    protected $table = 'schedules_sunday_school_class';
    protected $fillable = ['schedule_id', 'sunday_school_class_id'];

    public function sundaySchoolClass()
    {
        return $this->belongsTo(SundaySchoolClass::class, 'sunday_school_class_id', 'id'); // Sesuaikan dengan model kelas
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id', 'id'); // Sesuaikan dengan model jadwal
    }
}
