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
        Schema::create('stagiaires', function (Blueprint $table) {
            $table->id();
            $table->string("matricule")->unique();
            $table->string("nom");
            $table->string("postnom");
            $table->string("prenom")->nullable();
            $table->char("sexe")->default('H');
            $table->string("lieu_naissance");
            $table->date("date_naissance");
            $table->string("telephone1")->unique();
            $table->string("telephone2")->nullable();
            $table->string("email")->nullable();
            $table->string("adresse");
            $table->string("nom_pere");
            $table->string("nom_mere");
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
        Schema::dropIfExists('stagiaires');
    }
};
