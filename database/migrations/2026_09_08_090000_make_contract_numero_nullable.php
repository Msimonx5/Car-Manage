<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Rend contracts.numero de nouveau nullable.
 *
 * Le controleur cree le contrat sans numero puis le renseigne avec l'id
 * obtenu, ce qui suppose une colonne nullable — c'est d'ailleurs ce que
 * declare create_contracts_table. Certaines bases ont pourtant la colonne en
 * NOT NULL, et toute creation de contrat y echoue avec
 * « Field 'numero' doesn't have a default value ».
 */
return new class extends Migration
{
    public function up(): void
    {
        if ($this->estNullable()) {
            return;
        }

        Schema::table('contracts', function (Blueprint $table) {
            $table->string('numero')->nullable()->change();
        });
    }

    public function down(): void
    {
        // La colonne est nullable dans la migration de creation : on ne
        // retablit pas une contrainte que le code ne peut pas respecter.
    }

    private function estNullable(): bool
    {
        if (! Schema::hasTable('contracts')) {
            return true;
        }

        foreach (Schema::getColumns('contracts') as $colonne) {
            if ($colonne['name'] === 'numero') {
                return (bool) $colonne['nullable'];
            }
        }

        return true;
    }
};
