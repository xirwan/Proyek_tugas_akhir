<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    use HasFactory;
    protected $fillable = [
        'member_id',
        'seminar_file',
        'baptism_file',
        'seminar_certified',
        'baptism_certified',
        'admin_override',
        'rejection_reason',
        'created_by',
        'admin_note',
    ];

    /**
     * Get the member associated with the certification.
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Get the admin who created or verified this certification.
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}
