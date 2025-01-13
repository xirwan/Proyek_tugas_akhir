<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Schedule;

class Seedjadwal extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Schedule::create([
            "name"=> "Ibadah Sekolah Minggu",
            "day"=> "Minggu",
            "start"=> "12:00:00",
            "end"=> "14:00:00", 
            "description"=> "Ibadah sekolah minggu anak-anak",
            "status"=> "Active",
            "category_id"=> "1",
            "type_id"=> "1",
        ]);
    }
}
