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
        Schema::create('obra_ubications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('obra_id');
            $table->foreign('obra_id')->references('id')->on('obras')->onDelete('cascade');
            $table->string('ubicacion')->nullable();
            /* $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable(); */
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
        Schema::dropIfExists('obra_ubications');
    }
};
