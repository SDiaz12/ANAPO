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
        Schema::create('asignaturadocentes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('docente_id');
            $table->unsignedBigInteger('asignatura_id');
            $table->unsignedBigInteger('periodo_id');
            $table->unsignedBigInteger('seccion_id');
            $table->integer('estado');
            $table->integer('mostrarTercerParcial')->default(1);
           $table->unique(
                            ['asignatura_id', 'docente_id', 'periodo_id', 'seccion_id'],
                            'asig_doc_per_sec_unique'
                         );
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('docente_id')->references('id')->on('docentes');
            $table->foreign('asignatura_id')->references('id')->on('asignaturas');
            $table->foreign('periodo_id')->references('id')->on('periodos');
            $table->foreign('seccion_id')->references('id')->on('secciones');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignaturadocentes');
    }
};
