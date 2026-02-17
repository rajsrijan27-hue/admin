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
        Schema::create('institutions', function (Blueprint $table) {
            $table->id();

            // Core Details
            $table->string('name');
            $table->string('code')->unique();
            $table->string('email')->nullable();
            $table->string('contact_number')->nullable();
            $table->text('address')->nullable();

            // Access & Branding
            $table->string('institution_url')->nullable();
            $table->string('default_language')->nullable();
            $table->string('login_template')->nullable();
            $table->string('logo')->nullable();

            // Admin & Control
            $table->string('admin_name')->nullable();
            $table->string('admin_email')->nullable();
            $table->string('admin_mobile')->nullable();

            // Billing & Payment
            $table->string('invoice_type')->nullable();
            $table->decimal('invoice_amount', 10, 2)->nullable();
            $table->string('payment_mode')->nullable();
            $table->string('payment_status')->nullable();

            // Status
            $table->enum('status', ['Active', 'Inactive'])->default('Active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('institutions');
    }
};
