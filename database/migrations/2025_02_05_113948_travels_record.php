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
        Schema::create('travels', function (Blueprint $table) {
            $table->id();
            $table->string('firstName');
            $table->string('subName');
            $table->string('lastName')->nullable();
            $table->text('uuid');
            $table->string('status');
            $table->string('phoneNumber');
            $table->string('emailAddress');
            $table->string('sex');
            $table->string('typeDocument');
            $table->string('documentNumber');
            $table->string('suportNumber')->nullable();
            $table->string('nameResponsibleToBilling')->nullable();       
            $table->date('dateExpedition');
            $table->date('birthdate');
            $table->string('countrySelected');
            $table->string('kinshipLodging')->nullable();
            $table->string('address');
            $table->string('postalCode');
            $table->date('entryDate');
            $table->date('finalDate');
            $table->string('methodOfPayment');
            $table->string('typeOfEntity');
            $table->string('addressOfFacture')->nullable();
            $table->string('postalCodeOfFacture')->nullable();
            $table->string('documentOfEntity')->nullable();
            $table->longText('eFirma');
            $table->integer('npart');
            $table->boolean('travelFatureData');
            $table->boolean('isTrash');
            $table->boolean('usePersonalDataInInvoice');
            $table->text('hotel_uuid');
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
