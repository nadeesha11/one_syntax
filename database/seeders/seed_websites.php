<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class seed_websites extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $websites = [
            ['name'=>'Bbc sinhala', 'created_at'=> Carbon::now(), 'updated_at'=> Carbon::now()],
            ['name'=>'Hiru News', 'created_at'=> Carbon::now(), 'updated_at'=> Carbon::now()],
            ['name'=>'Ada Derana', 'created_at'=> Carbon::now(), 'updated_at'=> Carbon::now()],
            
        ]; // inserted data

        DB::table('website')->insert($websites);//insert data into website table
    }
}
