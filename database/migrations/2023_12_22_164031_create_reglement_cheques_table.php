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
        Schema::create('reglement_cheques', function (Blueprint $table) {
            $table->id();
            $table->date('date_reglement');
            $table->foreignId('cheque_id')->constrained('checks')->onDelete('cascade');
            $table->foreignId('compte_id')->constrained('compte_depenses')->onDelete('cascade');
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
        Schema::dropIfExists('reglement_cheques');
    }
};
