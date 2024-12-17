<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seminar extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'status',
        'max_participants',
        'poster_file',
        'event_date',
        'start',
        'registration_start',
        'registration_end',
    ];

    public function registrations()
    {
        return $this->hasMany(SeminarRegistration::class);
    }
}
