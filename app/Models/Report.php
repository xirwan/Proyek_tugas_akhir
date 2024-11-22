<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'week_of',
        'title',
        'description',
        'file_path',
        'sunday_school_class_id',
    ];

    public function sundaySchoolClass()
    {
        return $this->belongsTo(SundaySchoolClass::class, 'sunday_school_class_id'); // Pastikan kolom `class_id` ada di tabel reports
    }

}