<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SelfActivityRegistration extends Model
{
    use HasFactory;
    protected $fillable = [
        'activity_id',
        'member_id',
        'payment_id',
    ];

    // Relasi ke aktivitas
    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id');
    }

    // Relasi ke member
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    // Relasi ke pembayaran
    public function payment()
    {
        return $this->belongsTo(ActivityPayment::class, 'payment_id');
    }
}
