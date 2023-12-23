<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 60)->index();
            $table->string('last_name', 60)->index();
            $table->string('fathers_name', 60);
            $table->string('mothers_name', 60);
            $table->enum('gender', ["male","female","other"]);
            $table->date('birth_date');
            $table->integer('age');
            $table->string('email', 60)->nullable();
            $table->foreignId('learning_center_id');
            $table->enum('learning_center_type', ["Coaching","Pre School"])->default('Pre School');
            $table->foreignId('classes_id');
            $table->foreignId('section_id');
            $table->string('class_roll', 60);
            $table->date('enroll_date');
            $table->boolean('is_still_in_learning_center')->default(true);
            $table->date('graduated_date')->nullable();
            $table->string('institute_name', 255)->nullable();
            $table->string('institute_class_roll', 255)->nullable();
            $table->string('address_of_institute', 255)->nullable();
            $table->string('grade_of_students', 255)->nullable();
            $table->string('department', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
