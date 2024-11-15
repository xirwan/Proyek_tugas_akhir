<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberBaptist extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_member',
        'id_baptist_class',
        'description',
        'status',
    ];
    
    public function baptistClass()
    {
        return $this->belongsTo(BaptistClass::class, 'id_baptist_class');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'id_member');
    }

}
