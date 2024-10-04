<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;

class Member extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = [
        'firstname',
        'lastname',
        'dateofbirth',
        'status',
        'address',
        'branch_id',
        'role_id',
        'position_id',
        'user_id',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id', 'id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id'); // Role model dari Spatie\Permission
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
