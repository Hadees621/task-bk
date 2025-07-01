<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->index();
            $table->string('last_name');
            $table->string('email')->unique()->index();
            $table->string('personal_phone')->nullable();
            $table->text('description')->nullable();
            $table->string('address')->nullable();
            $table->string('business_phone')->nullable();
            $table->string('home_phone')->nullable();
            $table->string('nationality')->index();
            $table->string('country_of_residence')->nullable();
            $table->date('dob')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
