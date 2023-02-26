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
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->string("nom")->unique();
            $table->unsignedBigInteger("type_formation_id");
            $table->unsignedBigInteger("filiere_id");

            $table->foreign("type_formation_id")->references("id")->on("type_formations")->onDelete('cascade')->onUpdate('cascade');
            $table->foreign("filiere_id")->references("id")->on("filieres")->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('modules');
    }
};
