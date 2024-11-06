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
        'rescheduled_date',
        'original_class_detail_id',
        'id_baptist_class',
    ];
    public function baptistClass()
    {
        return $this->belongsTo(BaptistClass::class, 'id_baptist_class');
    }

    public function attendances()
    {
        return $this->hasMany(BaptistAttendance::class, 'id_baptist_class_detail');
    }

    public function originalClassDetail()
    {
        return $this->belongsTo(BaptistClassDetail::class, 'original_class_detail_id');
    }

    public function replacementClasses()
    {
        return $this->hasMany(BaptistClassDetail::class, 'original_class_detail_id');
    }

    public function details()
    {
        return $this->hasMany(BaptistClassDetail::class, 'id_baptist_class');
    }

}
