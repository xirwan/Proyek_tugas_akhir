<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Spatie\Permission\Traits\HasRoles;
// use Spatie\Permission\Models\Role;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstname',
        'lastname',
        'dateofbirth',
        'status',
        'address',
        'qr_code',
        'branch_id',
        // 'role_id',
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

    // public function role()
    // {
    //     return $this->belongsTo(Role::class, 'role_id');
    // }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function relations()
    {
        return $this->hasMany(MemberRelation::class, 'member_id');
    }

    // Relasi ke anggota lain melalui member_relation
    // public function relatedMembers()
    // {
    //     return $this->belongsToMany(Member::class, 'member_relation', 'member_id', 'related_member_id')
    //                 ->withPivot('relation_id');
    // }

    // Relasi ke absensi sekolah minggu
    public function sundaySchoolPresence()
    {
        return $this->hasMany(SundaySchoolPresence::class, 'member_id');
    }

    // Relasi untuk mendapatkan orang tua dari anggota ini (jika anggota adalah anak)
    public function parents()
    {
        return $this->belongsToMany(Member::class, 'member_relation', 'related_member_id', 'member_id')
                    ->withPivot('relation_id');
    }

    // Relasi untuk mendapatkan anak-anak dari anggota ini (jika anggota adalah orang tua)
    public function children()
    {
        return $this->belongsToMany(Member::class, 'member_relation', 'member_id', 'related_member_id')
                    ->withPivot('relation_id');
    }

    // Relasi untuk kelas yang diikuti oleh murid
    public function sundaySchoolClasses()
    {
        return $this->belongsToMany(SundaySchoolClass::class, 'sunday_school_members', 'member_id', 'sunday_school_class_id');
    }

    public function memberBaptists()
    {
        return $this->hasMany(MemberBaptist::class, 'id_member'); // 'id_member' adalah foreign key pada tabel member_baptists
    }

    public function certification()
    {
        return $this->hasOne(Certification::class);
    }

    public function scheduleMember()
    {
        return $this->hasMany(MemberScheduleMonthly::class, 'member_id');
    }

}
