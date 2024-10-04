<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Branch;

class Seedcabang extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Branch::create([
            "name"=> "GBI Sungai Yordan (Ratu Melati)",
            "address"=> "Jl. Ratu Melati No.7 Blok D3, RT.7/RW.13, Duri Kepa, Kec. Kb. Jeruk, Kota Jakarta Barat, Daerah Khusus Ibukota Jakarta 11510",
            "status"=> "Active",
        ]);
    }
}
