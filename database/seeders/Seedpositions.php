<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Position;

class Seedpositions extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Position::create([
            "name"=> "Pembina",
            "description"=> "Pembina Sekolah Minggu GBI Sungai Yordan",
            "status"=> "Active",
        ]);
        Position::create([
            "name"=> "Jemaat",
            "description"=> "Jemaat GBI Sungai Yordan",
            "status"=> "Active",
        ]);
    }
}
