<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('effet_comptes', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
        DB::table('effet_comptes')->insert([
            ['nom' => 'Règlement fournisseurs', 'user_id' => 1],
            ['nom' => 'Règlement Cies', 'user_id' => 1],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('effet_comptes');
    }
};
