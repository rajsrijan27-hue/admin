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
Schema::create('job_type_master', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->string('job_type_code', 50)->unique();   // NEW
    $table->string('job_type_name', 100);            // Already exists
    $table->text('description')->nullable();         // NEW
    $table->enum('status', ['Active', 'Inactive'])->default('Active');
    $table->integer('display_order')->nullable();
    $table->string('created_by')->nullable();
    $table->string('updated_by')->nullable();
    $table->softDeletes();
    $table->timestamps();
});


}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_type_master');
    }
};
