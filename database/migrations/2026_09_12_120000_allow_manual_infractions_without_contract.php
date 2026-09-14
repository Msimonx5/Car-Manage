<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Les declarations sans contrat n'ont pas de relation de location.
        Schema::table('infractions', function (Blueprint $table) {
            $table->foreignId('contract_id')->nullable()->change();
            $table->foreignId('client_id')->nullable()->change();
            $table->foreignId('vehicle_id')->nullable()->change();
            $table->string('numero_permis', 50)->nullable()->change();
        });
    }

    public function down(): void
    {
        // Les declarations manuelles ne peuvent pas etre restaurees avec des
        // relations obligatoires sans risquer de perdre des donnees.
    }
};
