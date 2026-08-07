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
        Schema::create('clients', function (Blueprint $table) {

            $table->id();

            $table->enum('type', [
                'principal',
                'secondaire'
            ])->default('principal');

            $table->string('nom', 100);

            $table->string('prenom', 100);

            $table->date('date_naissance')->nullable();

            $table->string('lieu_naissance', 150)->nullable();

            $table->text('adresse')->nullable();

            $table->string('cin', 20)->unique();

            $table->string('nationalite', 100)->default('Marocaine');

            $table->string('numero_permis', 50)->unique();

            $table->string('numero_passeport', 50)->nullable();

            $table->text('adresse_etranger')->nullable();

            $table->string('telephone', 20);

            $table->timestamps();

            $table->softDeletes();

            $table->index('nom');
            $table->index('prenom');
            $table->index('cin');
            $table->index('numero_permis');
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};