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
            "nama"=> "Penggurus Umum",
            "deskripsi"=> "Penggurus Umum gereja",
            "status"=> "Aktif",

        ]);
    }
}
