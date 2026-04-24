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
        Schema::create('personnel', function (Blueprint $table) {
            // PK must be declared as a method call
            $table->string('code_personnel', 20)->primary();
            $table->string('nom_personnel');
            $table->enum('sex_personnel', ['M', 'F']);
            // store phone as string to preserve leading zeros and match validation
            $table->string('phone_personnel', 20);
            $table->string('login_personnel');
            $table->string('password_personnel');
            // include RESPONSABLE_FINANCIER to match validation and tests
            $table->enum('type_personnel', ['ENSEIGNANT', 'RESPONSABLE_ACADEMIQUE', 'RESPONSABLE_FINANCIER']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personnel');
    }
};
