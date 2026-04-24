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
   Schema::create('programmes', function (Blueprint $table) {
    $table->id();

    // Référence EC
    $table->string("code_ec", 20);
    $table->foreign("code_ec")->references("code_ec")->on("ecs")->onDelete("cascade");

    // Référence Salle
    $table->unsignedBigInteger('salle_id');
    $table->foreign('salle_id')->references('id')->on('salle')->onDelete('cascade');

    // Référence Personnel
   $table->string('code_personnel', 20);
$table->foreign('code_personnel')->references('code_personnel')->on('personnel')->onDelete('cascade');

    $table->date("date");
    $table->time("heure_debut");
    $table->time("heure_fin");
    $table->integer("nombre_dheure");
    $table->string("statut", 50);
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programmes');
    }
};
