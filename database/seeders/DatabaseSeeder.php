<?php

namespace Database\Seeders;

use App\Models\LearningCenter;
use App\Models\Staff;
use App\Models\Student;
use App\Models\Subjects;
use App\Models\User;
use CitiesTableSeeder;
use CountriesTableSeeder;
use Illuminate\Database\Seeder;
use StatesTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(CountriesSeeder::class);
        $this->call(StatesSeeder::class);
        $this->call(CitiesSeeder::class);

        $this->call(DesignationSeeder::class);
        $this->call(ClassesSeeder::class);
        $this->call(SessionSeeder::class);


        User::factory(20)->create();
        LearningCenter::factory(20)->create();

        Staff::factory(10)->create();
        Subjects::factory(3)->create();
        Student::factory(50)->create();

        User::factory()->create([
            'name' => 'Shahidul Islam',
            'email' => 'shahidul@pitc.edu',
        ]);
    }
}
