<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceMember extends Model
{
    use HasFactory;
    protected $fillable = [
        'schedule_id',
        'member_id',
        'scanned_at',
    ];
    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id');
    }

    /**
     * Relasi ke tabel members.
     * AttendanceMember belongs to Member.
     */
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
}
