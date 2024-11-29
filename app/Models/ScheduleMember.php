<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleMember extends Model
{
    use HasFactory;
    protected $fillable = [
        'member_id',
        'schedule_id',
        'schedule_date', // Tanggal spesifik penjadwalan
    ];
}
