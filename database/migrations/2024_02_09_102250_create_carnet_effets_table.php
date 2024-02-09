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
        Schema::create('carnet_effets', function (Blueprint $table) {
            $table->id();
            $table->date('reception_date');
            $table->string('carnet_series');
            $table->foreignId('bank_id')->constrained('banks')->onDelete('cascade');
            $table->string('effet_sie');
            $table->integer('effet_start_number');
            $table->integer('effet_quantity');
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
        Schema::dropIfExists('carnet_effets');
    }
};
