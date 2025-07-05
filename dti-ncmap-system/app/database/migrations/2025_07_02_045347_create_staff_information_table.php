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
        Schema::create('staff_information', function (Blueprint $table) {
            $table->id();
            $table->date('date_created');
            $table->string('first_name', 50);
            $table->string('middle_name', 50)->nullable();
            $table->string('last_name', 50);
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->string('region', 50)->default('Region 7');
            $table->string('province', 100);
            $table->string('municipality', 100);
            $table->string('district', 50)->nullable();
            $table->text('complete_address');
            $table->foreignId('location_id')->nullable()->constrained('office_locations');
            $table->text('remarks')->nullable();
            $table->string('type_advanced', 50)->nullable();
            $table->string('type_code', 50)->nullable();
            $table->string('service_area', 100)->nullable();
            $table->string('contact_person', 100)->nullable();
            $table->string('position', 100);
            $table->string('cellphone_number', 20)->nullable();
            $table->string('email_address', 100)->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            
            $table->index('location_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_information');
    }
};
