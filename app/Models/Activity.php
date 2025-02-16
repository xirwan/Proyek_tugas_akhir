<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Activity extends Model
{
    use HasFactory;
    //kalau midtrans hilangkan payment deadline
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
        'account_number',
    ];

    // Event yang dijalankan setelah activity disetujui
    protected static function booted()
    {
        static::updated(function ($activity) {
            // Pastikan hanya membuat berita jika status menjadi 'approved'
            if ($activity->isDirty('status') && $activity->status === 'approved') {
                // Membuat entri berita baru
                News::create([
                    'title' => $activity->title,
                    'slug' => Str::slug($activity->title),
                    'image' => $activity->poster_file,
                    'content' => $activity->description . ', Harap membuka menu kegiatan untuk melihat informasi lebih lanjut.',
                    'status' => 'published',
                ]);
            }
        });
    }

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

    public function registrationmembers()
    {
        return $this->hasMany(SelfActivityRegistration::class, 'activity_id');
    }

    // Relasi ke pembayaran aktivitas
    public function payments()
    {
        return $this->hasMany(ActivityPayment::class, 'activity_id');
    }
}
