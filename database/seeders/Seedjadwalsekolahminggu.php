<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ScheduleSundaySchoolClass;

class Seedjadwalsekolahminggu extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        ScheduleSundaySchoolClass::create([
            "schedule_id"=> "1",
            "sunday_school_class_id"=> "1",
        ]);
        ScheduleSundaySchoolClass::create([
            "schedule_id"=> "1",
            "sunday_school_class_id"=> "2",
        ]);
        ScheduleSundaySchoolClass::create([
            "schedule_id"=> "1",
            "sunday_school_class_id"=> "3",
        ]);
    }
}
