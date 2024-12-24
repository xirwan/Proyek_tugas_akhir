<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Baptist extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'description',
        'status',
    ];

    public function classDetails()
    {
        return $this->hasMany(BaptistClassDetail::class, 'id_baptist');
    }

    public function members()
    {
        return $this->hasMany(MemberBaptist::class, 'id_baptist');
    }

    public function details()
    {
        return $this->hasMany(BaptistClassDetail::class, 'id_baptist');
    }

}
