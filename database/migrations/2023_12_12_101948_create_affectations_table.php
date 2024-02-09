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
        Schema::create('affectations', function (Blueprint $table) {
            $table->id();
            $table->date('affectation_date');
            $table->foreignId('checkbook_id')->constrained('checkbooks')->onDelete('cascade');
            $table->integer('start_number');
            $table->integer('end_number');
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
            $table->foreignId('courtier_id')->constrained('courtiers')->onDelete('cascade');
            $table->text('images');
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
        Schema::dropIfExists('affectations');
    }
};
