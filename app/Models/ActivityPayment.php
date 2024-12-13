<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityPayment extends Model
{
    use HasFactory;
    protected $fillable = [
        'parent_id',
        'activity_id',
        'total_children',
        'total_amount',
        'payment_proof',
        'verified_by',
        'payment_status',
    ];

     // Relasi ke member (orang tua yang melakukan pembayaran)
     public function parent()
     {
         return $this->belongsTo(Member::class, 'parent_id');
     }
 
     // Relasi ke aktivitas
     public function activity()
     {
         return $this->belongsTo(Activity::class, 'activity_id');
     }
 
     // Relasi ke member (admin yang memverifikasi pembayaran)
     public function verifier()
     {
         return $this->belongsTo(User::class, 'verified_by');
     }
}
