<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('countries')->delete();
        $countries = array(
            array('id' => 1,'code' => 'AF' ,'name' => "Afghanistan",'phone_code' => 93),
            array('id' => 2,'code' => 'AL' ,'name' => "Albania",'phone_code' => 355),
            array('id' => 3,'code' => 'DZ' ,'name' => "Algeria",'phone_code' => 213),
            array('id' => 4,'code' => 'AS' ,'name' => "American Samoa",'phone_code' => 1684),
            array('id' => 5,'code' => 'AD' ,'name' => "Andorra",'phone_code' => 376),
            array('id' => 6,'code' => 'AO' ,'name' => "Angola",'phone_code' => 244),
            array('id' => 7,'code' => 'AI' ,'name' => "Anguilla",'phone_code' => 1264),
            array('id' => 8,'code' => 'AQ' ,'name' => "Antarctica",'phone_code' => 0),
        );
        DB::table('countries')->insert($countries);
    }
}
