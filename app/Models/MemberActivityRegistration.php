<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberActivityRegistration extends Model
{
    use HasFactory;
    protected $fillable = [
        'activity_id',
        'child_id',
        'registered_by',
    ];

    // Relasi ke aktivitas
    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id');
    }

    // Relasi ke member (anak yang didaftarkan)
    public function child()
    {
        return $this->belongsTo(Member::class, 'child_id');
    }

    // Relasi ke member (orang tua yang mendaftarkan)
    public function parent()
    {
        return $this->belongsTo(Member::class, 'registered_by');
    }

    // Relasi ke pembayaran (jika ada)
    public function payment()
    {
        return $this->hasOne(ActivityPayment::class, 'parent_id', 'registered_by');
    }
}   
