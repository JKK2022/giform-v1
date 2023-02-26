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
        Schema::create('photo_stagiaires', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("stagiaire_id");
            $table->string("photo");

            $table->foreign('stagiaire_id')->references('id')->on('stagiaires')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('photo_stagiaires');
    }
};
