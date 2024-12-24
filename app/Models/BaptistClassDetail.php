<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaptistClassDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'description',
        'status',
        'is_rescheduled',
        'reschedule_date',
        'original_class_detail_id',
        'id_baptist',
    ];
    // Relasi ke Baptist
    public function baptist()
    {
        return $this->belongsTo(Baptist::class, 'id_baptist');
    }

    // Relasi ke BaptistAttendance
    public function attendances()
    {
        return $this->hasMany(BaptistAttendance::class, 'id_baptist_class_detail');
    }

    // Relasi untuk class detail yang asli (reschedule)
    public function originalClassDetail()
    {
        return $this->belongsTo(BaptistClassDetail::class, 'original_class_detail_id');
    }

    // Relasi untuk class detail pengganti (reschedule)
    public function replacementClasses()
    {
        return $this->hasMany(BaptistClassDetail::class, 'original_class_detail_id');
    }

    public function memberBaptists()
    {
        return $this->hasMany(MemberBaptist::class, 'id_baptist_class_detail');
    }

}
