<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\table;

class SessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sessions')->delete();
        $sessions = array(
            array('name' => 'A'),
            array('name' => 'B'),
            array('name' => 'C'),
            array('name' => 'D'),
        );
        DB::table('sessions')->insert($sessions);
    }
}
