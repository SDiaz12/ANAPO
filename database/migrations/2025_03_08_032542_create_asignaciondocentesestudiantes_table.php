<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('asignaciondocentesestudiantes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('docente_id');
            $table->unsignedBigInteger('estudiante_id');
            $table->unsignedBigInteger('periodo_id');
            $table->integer('estado');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('docente_id')->references('id')->on('docentes');
            $table->foreign('estudiante_id')->references('id')->on('estudiantes');
            $table->foreign('periodo_id')->references('id')->on('periodos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignaciondocentesestudiantes');
    }
};
