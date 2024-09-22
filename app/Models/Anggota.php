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
        'positions_id',
        'users_id',
    ];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'cabang_id', 'id');
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'positions_id', 'id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'roles_id'); // Role model dari Spatie\Permission
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

}
