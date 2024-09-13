<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    protected $table="cabang";
    use HasFactory;
    protected $fillable = [
        'nama',
        'status',
        'deskripsi',
    ];
}
