<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlySchedule extends Model
{
    use HasFactory;
    protected $fillable = ['month', 'year'];

    public function memberSchedules()
    {
        return $this->hasMany(MemberScheduleMonthly::class);
    }
}
