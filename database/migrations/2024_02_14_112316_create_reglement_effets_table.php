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
        Schema::create('reglement_effets', function (Blueprint $table) {
            $table->id();
            $table->date('date_reglement');
            $table->foreignId('effet_id')->constrained('effets')->onDelete('cascade');
            $table->foreignId('effet_compte_id')->constrained('effet_comptes')->onDelete('cascade');
            $table->foreignId('benefiiaire_id')->constrained('bene_comptes')->onDelete('cascade');
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
            $table->decimal('montant', 8, 5);
            $table->date('echeance');
            $table->string('referance');
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
        Schema::dropIfExists('reglement_effets');
    }
};
