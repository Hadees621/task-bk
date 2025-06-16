<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('leads')) {
            Schema::create('leads', function (Blueprint $table) {
                $table->id();
                $table->string('full_name');
                $table->string('email')->nullable();
                $table->string('phone_number')->nullable();
                $table->string('source')->nullable();
                $table->enum('status', ['new', 'contacted', 'qualified', 'converted', 'lost'])->default('new');
                $table->unsignedBigInteger('assigned_to')->nullable();
                $table->string('company_name')->nullable();
                $table->integer('lead_score')->default(0);
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('leads');
    }

};
