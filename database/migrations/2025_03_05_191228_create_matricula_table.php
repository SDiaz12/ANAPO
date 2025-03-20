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
        Schema::create('matriculas', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_matricula');
            $table->unsignedBigInteger('programaformacion_id');
            $table->unsignedBigInteger('estudiante_id');
            $table->string('instituto_id');
            $table->tinyInteger('estado')->default(1);
            $table->string('motivo_estado')->nullable();
            $table->string('observacion_estado')->nullable();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->unique(['estudiante_id', 'programaformacion_id']);
            $table->timestamps();
            $table->foreign('estudiante_id')->references('id')->on('estudiantes');
            $table->foreign('instituto_id')->references('id')->on('institutos');
            $table->foreign('programaformacion_id')->references('id')->on('programaformaciones');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matriculas');
    }
};
