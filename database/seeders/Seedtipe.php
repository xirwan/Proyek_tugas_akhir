<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Type;

class Seedtipe extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Type::create([
            "name"=> "Sekolah Minggu",
            "description"=> "Ibadah sekolah minggu",
            "status"=> "Active",
        ]);
    }
}
