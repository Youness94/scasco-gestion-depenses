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
        Schema::create('checks', function (Blueprint $table) {
            $table->id();
            $table->string('series');
            $table->string('cheque_sie');
            $table->integer('number');
            $table->foreignId('checkbook_id')->constrained('checkbooks')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users');
            // $table->foreignId('reglement_cheque_id')->nullable()->constrained('reglement_cheques', 'id')->onDelete('cascade'); 
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
        Schema::dropIfExists('checks');
    }
};
