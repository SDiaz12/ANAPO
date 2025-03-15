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
        Schema::create('programaformaciones', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 100);
            $table->string('nombre', 100);
            $table->date('fecha_aprobacion');
            $table->date('fecha_final');
            $table->time('hora_finalizacion');
            $table->string('instituto', 100);
            $table->string('tipo_programa', 100);
            $table->integer('procentaje_aprobacion');
            $table->tinyInteger ('estado');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programaformaciones');
    }
};
