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
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->uuid('plan_uuid');
            $table->string('name');
            $table->text('address_uuid');
            $table->string('email')->nullable();
            $table->string('document_number');
            $table->string('phone_number')->nullable();
            $table->boolean('is_active')->default(true); // para bloquear acceso
            $table->date('next_payment_due')->nullable(); // control de pago
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
