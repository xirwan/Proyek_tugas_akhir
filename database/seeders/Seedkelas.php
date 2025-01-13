<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SundaySchoolClass;

class Seedkelas extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        SundaySchoolClass::create([
            "name"=> "Kelas Yohanes",
            "description"=> "Khusus anak umur 10-15 tahun",
            "status"=> "Active",
        ]);
        SundaySchoolClass::create([
            "name"=> "Kelas Yakobus",
            "description"=> "Khusus anak umur 1-5 tahun",
            "status"=> "Active",
        ]);
        SundaySchoolClass::create([
            "name"=> "Kelas Petrus",
            "description"=> "Khusus anak umur 5-10 tahun",
            "status"=> "Active",
        ]);
    }
}
