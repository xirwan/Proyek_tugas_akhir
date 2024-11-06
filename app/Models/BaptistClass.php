<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaptistClass extends Model
{
    use HasFactory;
    protected $fillable = [
        'day',
        'start',
        'end',
        'description',
        'status',
        'id_baptist',
    ];

    public function baptist()
    {
        return $this->belongsTo(Baptist::class, 'id_baptist');
    }

    public function details()
    {
        return $this->hasMany(BaptistClassDetail::class, 'id_baptist_class');
    }

}
