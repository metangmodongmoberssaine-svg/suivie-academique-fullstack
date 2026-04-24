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
     Schema::create('ues', function (Blueprint $table) {
    $table->string('code_ue', 20)->primary();
    $table->string('label_ue', 191);
    $table->string('description_ue', 255);

    // Ici on définit code_niveau comme VARCHAR
    $table->string('code_niveau', 20);
    $table->foreign('code_niveau')
          ->references('code_niveau')
          ->on('niveaux')
          ->onDelete('cascade');

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ues');
    }
};
