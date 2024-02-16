<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('effet_annules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('effet_id')->constrained('effets')->onDelete('cascade');;
            $table->foreignId('effet_compte_id')->constrained('effet_comptes')->onDelete('cascade');
            $table->foreignId('benefiiaire_id')->constrained('bene_comptes')->onDelete('cascade');
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
            $table->decimal('montant_annule', 8,2);
            $table->string('series_effet_annule');
            $table->string('bank_effet_annule');
            $table->string('effet_sie_annule')->nullable();
            $table->string('refe_effet_annule')->nullable();
            $table->string('retour_effet_annule')->default('Non');
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('effet_annules');
    }
};
