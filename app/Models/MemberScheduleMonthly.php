<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberScheduleMonthly extends Model
{
    use HasFactory;
    protected $table = 'member_schedule_monthly';
    protected $fillable = [
        'member_id', 
        'schedules_sunday_school_class_id', 
        'monthly_schedule_id', 
        'schedule_date'];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function scheduleSundaySchoolClass()
    {
        return $this->belongsTo(ScheduleSundaySchoolClass::class, 'schedules_sunday_school_class_id');
    }

    public function monthlySchedule()
    {
        return $this->belongsTo(MonthlySchedule::class, 'monthly_schedule_id', 'id');
    }
}
