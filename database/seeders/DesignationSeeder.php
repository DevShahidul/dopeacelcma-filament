<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\table;

class DesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('designations')->delete();
        $designations = array(
            array('name' => 'Executive director'),
            array('name' => 'Supervisor'),
            array('name' => 'Field officer'),
            array('name' => 'Teacher'),
        );
        DB::table('designations')->insert($designations);;
    }
}
