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
        Schema::table('ecs', function (Blueprint $table) {
            // Ajout du champ pour stocker le chemin du fichier PDF
            $table->string('pdf_path')->nullable()->after('code_ue');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ecs', function (Blueprint $table) {
            // Suppression du champ si on rollback
            $table->dropColumn('pdf_path');
        });
    }
};
