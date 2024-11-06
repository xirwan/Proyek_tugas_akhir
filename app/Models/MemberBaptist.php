<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberBaptist extends Model
{
    use HasFactory;
    public function baptist()
    {
        return $this->belongsTo(Baptist::class, 'id_baptist');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'id_member');
    }

}
