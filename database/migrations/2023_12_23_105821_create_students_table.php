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
            $table->text('avatar')->nullable();
            $table->string('first_name', 60)->index();
            $table->string('last_name', 60)->index();
            $table->string('father_mother_name', 120);
            $table->enum('gender', ["male","female"]);
            $table->date('date_of_birth');
            $table->string('zip_code')->nullable();
            $table->string('address', 120)->nullable();
            $table->string('email', 60)->nullable();
            $table->string('phone', 25)->nullable();
            $table->string('facebook_url', 255)->nullable();
            $table->string('whatsapp_number', 255)->nullable();
            $table->foreignId('ngo_id');
            $table->foreignId('learning_center_id');
            $table->enum('learning_center_type', ["coaching","pre school"])->default('Pre School');
            $table->integer('student_name_mentioned_year')->nullable();
            $table->foreignId('classes_id');
            $table->foreignId('session_id')->nullable();
            $table->integer('class_roll');
            $table->date('date_of_enrollment');
            $table->boolean('is_still_in_learning_center')->default(true);
            $table->date('date_of_graduation')->nullable();
            $table->string('current_institute_name', 255)->nullable();
            $table->integer('current_institute_class_roll')->nullable();
            $table->foreignId('city_id')->nullable()->comment('City of the school');
            $table->string('address_of_institute', 255)->nullable();
            $table->string('grade_of_studying', 10)->nullable();
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
