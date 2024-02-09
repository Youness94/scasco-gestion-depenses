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
        Schema::create('reglements_sinirdps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('companier_id')->constrained('compagnies')->onDelete('cascade');
            $table->string('referance_dossier'); 
            $table->string('referance_quittance');
            $table->foreignId('reglement_cheque_id')->constrained('reglement_cheques')->onDelete('cascade');
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
        Schema::dropIfExists('reglements_sinirdps');
    }
};
