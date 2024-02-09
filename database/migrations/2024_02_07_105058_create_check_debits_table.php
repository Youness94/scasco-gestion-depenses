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
        Schema::create('check_debits', function (Blueprint $table) {
            $table->id();
            $table->string('cheque_sie_debit');
            // $table->string('check_debit_photo')->nullable();
            // $table->integer('check_number_debit');
            $table->string('series_debit');
            $table->string('compte_debit');
            $table->string('reference_debit');
            $table->string('service_debit');
            $table->string('beneficiare_debit');
            $table->string('banque_debit');
            $table->decimal('amount_debit',  8, 2);
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('check_id')->constrained('checks')->onDelete('cascade');
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
        Schema::dropIfExists('check_debits');
    }
};
