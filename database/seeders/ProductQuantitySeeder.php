<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductQuantitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('product_qualities')->insert([
            ['name' => 'High','created_at'=>now(),'updated_at'=>now()],
            ['name' => 'Low','created_at'=>now(),'updated_at'=>now()],
            ['name' => 'Medium','created_at'=>now(),'updated_at'=>now()],
        ]);
    }
}
