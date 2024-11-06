<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaptistAttendance extends Model
{
    use HasFactory;
    public function member()
    {
        return $this->belongsTo(Member::class, 'id_member');
    }

    public function classDetail()
    {
        return $this->belongsTo(BaptistClassDetail::class, 'id_baptist_class_detail');
    }

}
