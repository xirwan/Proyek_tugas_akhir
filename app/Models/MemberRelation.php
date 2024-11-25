<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberRelation extends Model
{
    protected $table = 'member_relation';
    // Daftarkan kolom-kolom yang boleh diisi secara massal
    protected $fillable = ['member_id', 'related_member_id', 'relation_id'];

    // Relasi ke anggota yang terkait
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function relatedMember()
    {
        return $this->belongsTo(Member::class, 'related_member_id');
    }

    // Relasi ke jenis hubungan
    public function relation()
    {
        return $this->belongsTo(Relation::class, 'relation_id', 'id');
    }
}
