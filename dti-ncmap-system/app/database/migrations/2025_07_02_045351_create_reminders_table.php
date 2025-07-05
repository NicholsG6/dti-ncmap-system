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
        Schema::create('reminders', function (Blueprint $table) {
            $table->id();
            $table->string('title', 200);
            $table->text('description')->nullable();
            $table->date('reminder_date');
            $table->time('reminder_time')->nullable();
            $table->enum('priority', ['Low', 'Medium', 'High'])->default('Medium');
            $table->enum('status', ['Active', 'Completed', 'Cancelled'])->default('Active');
            $table->foreignId('location_id')->nullable()->constrained('office_locations');
            $table->foreignId('staff_id')->nullable()->constrained('staff_information');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            
            $table->index('reminder_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reminders');
    }
};
