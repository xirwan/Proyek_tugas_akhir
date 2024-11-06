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
    public function classes()
    {
        return $this->hasMany(BaptistClass::class, 'id_baptist');
    }

}
