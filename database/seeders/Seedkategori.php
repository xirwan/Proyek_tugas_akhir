<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\MOdels\Category;

class Seedkategori extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Category::create([
            "name"=> "Ibadah anak-anak",
            "description"=> "Ibadah untuk anak-anak",
            "status"=> "Active",
        ]);
    }
}
