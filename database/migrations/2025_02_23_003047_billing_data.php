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
        Schema::create('billingdata', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('postalCode');
            $table->longText('footer');
            $table->text('uuid');
            $table->string('address');
            $table->string('typeBillingData');
            $table->string('photoPath');
            $table->string('documentNumber');
            $table->timestamps();
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
