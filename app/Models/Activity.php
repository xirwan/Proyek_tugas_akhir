<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;
    protected $fillable = [
        'created_by',
        'approved_by',
        'title',
        'description',
        'proposal_file',
        'is_paid',
        'price',
        'start_date',
        'registration_open_date',
        'registration_close_date',
        'payment_deadline',
        'status',
        'rejection_reason',
        'poster_file',
        'max_participants',
    ];

    // Relasi ke member (admin yang membuat aktivitas)
    public function creator()
    {
        return $this->belongsTo(Member::class, 'created_by');
    }

    // Relasi ke user (superadmin yang menyetujui aktivitas)
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Relasi ke pendaftaran aktivitas
    public function registrations()
    {
        return $this->hasMany(MemberActivityRegistration::class, 'activity_id');
    }


    // Relasi ke pembayaran aktivitas
    public function payments()
    {
        return $this->hasMany(ActivityPayment::class, 'activity_id');
    }
}
