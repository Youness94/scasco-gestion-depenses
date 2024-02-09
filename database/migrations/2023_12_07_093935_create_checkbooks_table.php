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
        Schema::create('checkbooks', function (Blueprint $table) {
            $table->id();
            $table->date('reception_date');
            $table->string('series');
            $table->foreignId('bank_id')->constrained('banks')->onDelete('cascade');
            $table->string('cheque_sie');
            $table->integer('start_number');
            $table->integer('quantity');
            $table->enum('status', ['Consomé', 'No Consomé'])->default('No Consomé');
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
        Schema::dropIfExists('checkbooks');
    }
};
