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
        Schema::create('niveaux', function (Blueprint $table) {
            // code_niveau en VARCHAR et clé primaire
            $table->string('code_niveau', 20)->primary();

            $table->string('label_niveau', 191);
            $table->text('description_niveau');

            // clé étrangère vers filieres
            $table->string('code_filiere', 20);
            $table->foreign('code_filiere')
                  ->references('code_filiere')
                  ->on('filieres')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('niveaux');
    }
};
