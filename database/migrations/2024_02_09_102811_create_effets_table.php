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
        Schema::create('effets', function (Blueprint $table) {
            $table->id();
            $table->string('effet_series');
            $table->string('effet_sie');
            $table->integer('effet_number');
            $table->foreignId('carnet_effet_id')->constrained('carnet_effets')->onDelete('cascade');
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
        Schema::dropIfExists('effets');
    }
};
