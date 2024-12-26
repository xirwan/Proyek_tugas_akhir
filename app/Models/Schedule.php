<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'day',
        'start',
        'end',
        'status',
        'description',
        'category_id',
        'type_id',
        'qr_code_path',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id', 'id');
    }

    public function classes()
    {
        return $this->belongsToMany(SundaySchoolClass::class, 'schedules_sunday_school_class', 'schedule_id', 'sunday_school_class_id');
    }

}
