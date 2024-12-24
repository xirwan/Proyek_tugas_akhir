<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberBaptist extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_member',
        'id_baptist_class_detail',
        'description',
        'status','id_member',
        'id_baptist_class_detail',
        'description',
        'status',
    ];
    
    // Relasi ke BaptistClassDetail
    public function classDetail()
    {
        return $this->belongsTo(BaptistClassDetail::class, 'id_baptist_class_detail');
    }

    // Relasi ke Member
    public function member()
    {
        return $this->belongsTo(Member::class, 'id_member');
    }

}
