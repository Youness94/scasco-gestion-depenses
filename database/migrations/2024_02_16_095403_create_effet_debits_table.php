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
        Schema::create('effet_debits', function (Blueprint $table) {
            $table->id();
            $table->string('effet_sie_debit');
            $table->string('effet_series_debit');
            $table->string('effet_compte_debit');
            $table->string('effet_reference_debit');
            $table->string('effet_service_debit');
            $table->string('effet_beneficiare_debit');
            $table->string('effet_banque_debit');
            $table->decimal('effet_amount_debit',  8, 2);
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('effet_id')->constrained('effets')->onDelete('cascade');
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
        Schema::dropIfExists('effet_debits');
    }
};
