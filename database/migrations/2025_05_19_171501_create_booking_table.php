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
        Schema::create('booking', function (Blueprint $table) {
            $table->id();
            $table->text('uuid');
            $table->text('name');
            $table->text('origen_type');
            $table->string('room_selected');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->decimal('total', 10, 2); 
            $table->date('entry_date');
            $table->date('final_date');
            $table->integer('travels')->default(1);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking');
    }
};
