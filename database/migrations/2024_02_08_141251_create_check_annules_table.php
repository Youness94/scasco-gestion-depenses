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
        Schema::create('check_annules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('check_id')->constrained('checks')->onDelete('cascade');;
            $table->foreignId('compte_id')->constrained('compte_depenses')->onDelete('cascade')->nullable();
            $table->foreignId('benefiiaire_id')->constrained('bene_comptes')->onDelete('cascade')->nullable();
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade')->nullable();
            $table->decimal('montant_annule', 8,2)->nullable();
            $table->string('series_checkbook_annule');
            $table->string('bank_check_annule');
            $table->string('cheque_sie_annule')->nullable();
            $table->string('refe_check_annule')->nullable();
            $table->string('retour_check_annule')->default('Non');
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
        Schema::dropIfExists('check_annules');
    }
};
