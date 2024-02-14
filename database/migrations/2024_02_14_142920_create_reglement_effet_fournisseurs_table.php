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
        Schema::create('reglement_effet_fournisseurs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sous_compte_id')->constrained('sous_comptes')->onDelete('cascade');
            $table->foreignId('reglement_effet_id')->constrained('reglement_effets')->onDelete('cascade');
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
        Schema::dropIfExists('reglement_effet_fournisseurs');
    }
};
