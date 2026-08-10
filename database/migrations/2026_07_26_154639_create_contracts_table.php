<?php

use App\Enums\ContractStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contracts', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Références
            |--------------------------------------------------------------------------
            */

            $table->string('numero')->unique();

            $table->foreignId('client_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('vehicle_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Deuxième conducteur
            |--------------------------------------------------------------------------
            */

            $table->foreignId('second_driver_id')
                ->nullable()
                ->constrained('clients')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Départ
            |--------------------------------------------------------------------------
            */

            $table->date('date_depart');

            $table->time('heure_depart');

            /*
            |--------------------------------------------------------------------------
            | Retour
            |--------------------------------------------------------------------------
            */

            $table->date('date_retour');

            $table->time('heure_retour');

            /*
            |--------------------------------------------------------------------------
            | Kilométrage
            |--------------------------------------------------------------------------
            */

            $table->unsignedInteger('km_depart');

            $table->unsignedInteger('km_retour')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Prix
            |--------------------------------------------------------------------------
            */

            $table->decimal('tarif_jour',10,2);

            $table->unsignedInteger('nombre_jours');

            $table->decimal('avance',10,2)->default(0);

            $table->decimal('caution',10,2)->default(0);

            $table->decimal('total_ht',10,2);

            $table->decimal('tva',10,2);

            $table->decimal('total_ttc',10,2);

            /*
            |--------------------------------------------------------------------------
            | Paiement
            |--------------------------------------------------------------------------
            */

            $table->string('mode_paiement')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Statut
            |--------------------------------------------------------------------------
            */

            $table->string('statut')
                ->default(ContractStatus::EN_ATTENTE->value);

            /*
            |--------------------------------------------------------------------------
            | Observation
            |--------------------------------------------------------------------------
            */

            $table->text('observation')
                ->nullable();

            $table->timestamps();

            $table->softDeletes();

            $table->index('numero');

            $table->index('date_depart');

            $table->index('date_retour');

            $table->index('statut');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};