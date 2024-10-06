<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Relation;

class Seedrelasi extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Relation::insert([
            [
                "name"=> "Orang tua",
                "description"=> "Orang tua",
                "status"=> "Active",
            ],
            [
                "name"=> "Anak",
                "description"=> "Anak",
                "status"=> "Active",
            ],
            [
                "name"=> "Saudara",
                "description"=> "Saudara",
                "status"=> "Active",
            ],
        ]);
    }
}
