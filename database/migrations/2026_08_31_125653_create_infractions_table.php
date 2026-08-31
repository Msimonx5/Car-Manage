<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('infractions', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Relations
            |--------------------------------------------------------------------------
            */

            $table->foreignId('contract_id')
                ->constrained('contracts')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('client_id')
                ->constrained('clients')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('vehicle_id')
                ->constrained('vehicles')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Informations client
            |--------------------------------------------------------------------------
            */

            $table->string('nom', 100);
            $table->string('prenom', 100);

            $table->string('cin', 20);
            $table->string('numero_permis', 50);

            $table->text('adresse')->nullable();
            $table->string('ville', 100)->nullable();
            $table->string('code_postal', 20)->nullable();

            $table->string('telephone', 20)->nullable();
            $table->string('email', 150)->nullable();

            /*
            |--------------------------------------------------------------------------
            | Informations véhicule
            |--------------------------------------------------------------------------
            */

            $table->string('immatriculation', 50);
            $table->string('marque', 100)->nullable();
            $table->string('modele', 100)->nullable();

            /*
            |--------------------------------------------------------------------------
            | Informations contrat
            |--------------------------------------------------------------------------
            */

            $table->string('numero_contrat', 100)->nullable();

            $table->date('date_depart')->nullable();
            $table->time('heure_depart')->nullable();

            $table->date('date_retour')->nullable();
            $table->time('heure_retour')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Infraction
            |--------------------------------------------------------------------------
            */


            $table->timestamps();
            $table->softDeletes();

            $table->index([
                'contract_id',
                'client_id',
                'vehicle_id',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('infractions');
    }
};