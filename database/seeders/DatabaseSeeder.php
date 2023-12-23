<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\City;
use App\Models\Classes;
use App\Models\Communicator;
use App\Models\Country;
use App\Models\Designation;
use App\Models\Section;
use App\Models\Staff;
use App\Models\Student;
use App\Models\Subjects;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(50)->create();
        City::factory()->create();
        Classes::factory(10)->create();
        Designation::factory(10)->create();
        Section::factory(4)->create();
        Staff::factory(20)->create();
        Subjects::factory(3)->create();
        Student::factory(500)->create();
//        Communicator::factory()->create()

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
