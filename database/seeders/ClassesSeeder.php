<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\table;

class ClassesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('classes')->delete();
        $classes = array(
            array('name' => 'One'),
            array('name' => 'Two'),
            array('name' => 'Three'),
            array('name' => 'Four'),
            array('name' => 'Five'),
            array('name' => 'Six'),
            array('name' => 'Seven'),
            array('name' => 'Eight'),
            array('name' => 'Nine'),
            array('name' => 'Ten'),
        );
        DB::table('classes')->insert($classes);
    }
}
