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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->text('uuid');
            $table->string('status');
            $table->integer('number');
            $table->string('type');
            $table->date('creationDate');
            $table->string('creationUserUUID');
            $table->text('traveluuid')->nullable();
            $table->text('invoiceuuid')->nullable();
            $table->text('comentary')->nullable();
            $table->longText('data');
            $table->decimal('totalValue', 10, 2); 
            $table->decimal('importValue', 10, 2);
            $table->decimal('taxableBase', 10, 2);
            $table->string('methodOfPayment'); 
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
