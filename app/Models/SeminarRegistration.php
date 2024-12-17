<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeminarRegistration extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'seminar_id',
        'is_attended',
        'certificate_url',
    ];

    public function seminar()
    {
        return $this->belongsTo(Seminar::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function member()
    {
        return $this->hasOneThrough(
            Member::class, // Model target (Member)
            User::class,   // Model perantara (User)
            'id',          // Foreign key di User (terhubung ke Member)
            'user_id',     // Foreign key di Member (terhubung ke User)
            'user_id',     // Foreign key di SeminarRegistration
            'id'           // Primary key di User
        );
    }
}
