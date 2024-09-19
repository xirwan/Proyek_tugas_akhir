<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;

class Anggota extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = [
        'nama_depan',
        'nama_belakang',
        'tanggal_lahir',
        'status',
        'deskripsi',
        'cabang_id',
        'roles_id',
    ];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'roles_id'); // Role model dari Spatie\Permission
    }

}
