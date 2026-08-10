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
        Schema::create('vehicles', function (Blueprint $table) {

            $table->id();

            // Informations générales
            $table->string('marque', 100);
            $table->string('modele', 100);
            $table->year('annee');
            $table->string('couleur', 50)->nullable();

            // Identification
            $table->string('immatriculation')->unique();
            $table->string('numero_chassis')->unique()->nullable();
            $table->string('numero_moteur')->nullable();

            // Caractéristiques
            $table->enum('carburant', [
                'Essence',
                'Diesel',
                'Hybride',
                'Electrique'
            ]);

            $table->enum('boite_vitesse', [
                'Manuelle',
                'Automatique'
            ]);

            $table->unsignedTinyInteger('nombre_places')->default(5);

            // Location
            $table->decimal('prix_jour', 10, 2);
            $table->decimal('caution', 10, 2)->default(0);

            // Kilométrage
            $table->unsignedInteger('kilometrage')->default(0);

            // Vidange
            $table->unsignedInteger('derniere_vidange_km')->nullable();
            $table->date('derniere_vidange_date')->nullable();

            $table->unsignedInteger('prochaine_vidange_km')->nullable();

            // Assurance
            $table->date('assurance_expiration')->nullable();

            // Visite technique
            $table->date('visite_technique')->nullable();

            // Statut
            $table->enum('statut', [
                'disponible',
                'loue',
                'maintenance',
                'reserve',
                'hors_service'
            ])->default('disponible');

            $table->text('observation')->nullable();

            $table->timestamps();

            $table->softDeletes();

            // Index
            $table->index('marque');
            $table->index('modele');
            $table->index('immatriculation');
            $table->index('statut');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};