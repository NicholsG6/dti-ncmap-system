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
        Schema::create('office_locations', function (Blueprint $table) {
            $table->id();
            $table->string('office_name', 150);
            $table->string('office_code', 20)->unique()->nullable();
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->text('complete_address');
            $table->string('region', 50)->default('Region 7');
            $table->string('province', 100);
            $table->string('municipality', 100);
            $table->string('district', 50)->nullable();
            $table->string('contact_number', 20)->nullable();
            $table->string('email_address', 100)->nullable();
            $table->string('office_head', 100)->nullable();
            $table->text('office_description')->nullable();
            $table->string('service_hours', 100)->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            
            $table->index(['latitude', 'longitude']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('office_locations');
    }
};
