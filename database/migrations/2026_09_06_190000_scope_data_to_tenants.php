<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Cloisonnement des donnees par agence.
 *
 * - Ajoute tenant_id aux infractions, seule table metier qui ne l'avait pas.
 * - Rend les identifiants metier uniques par agence et non plus globalement :
 *   deux agences doivent pouvoir enregistrer le meme CIN ou la meme plaque.
 */
return new class extends Migration
{
    /**
     * Index uniques globaux a transformer en index composites (tenant_id, colonne).
     */
    private array $uniques = [
        'clients' => [
            'clients_cin_unique' => 'cin',
            'clients_numero_permis_unique' => 'numero_permis',
        ],
        'vehicles' => [
            'vehicles_immatriculation_unique' => 'immatriculation',
            'vehicles_numero_chassis_unique' => 'numero_chassis',
        ],
        'contracts' => [
            'contracts_numero_unique' => 'numero',
        ],
    ];

    public function up(): void
    {
        if (! Schema::hasColumn('infractions', 'tenant_id')) {
            Schema::table('infractions', function (Blueprint $table) {
                $table->foreignId('tenant_id')
                    ->nullable()
                    ->after('id')
                    ->constrained()
                    ->nullOnDelete();
            });
        }

        // Rattache les infractions existantes a l'agence de leur contrat.
        DB::table('infractions')
            ->whereNull('tenant_id')
            ->update([
                'tenant_id' => DB::raw(
                    '(select tenant_id from contracts where contracts.id = infractions.contract_id)'
                ),
            ]);

        foreach ($this->uniques as $table => $indexes) {
            Schema::table($table, function (Blueprint $blueprint) use ($table, $indexes) {
                foreach ($indexes as $name => $column) {
                    if ($this->indexExists($table, $name)) {
                        $blueprint->dropUnique($name);
                    }

                    // MySQL ne sait pas annuler un DDL : si un passage precedent
                    // s'est interrompu en cours de route, une partie des index
                    // est deja en place et doit etre laissee telle quelle.
                    if (! $this->indexExists($table, $this->scopedName($table, $column))) {
                        $blueprint->unique(['tenant_id', $column], $this->scopedName($table, $column));
                    }
                }
            });
        }
    }

    public function down(): void
    {
        foreach ($this->uniques as $table => $indexes) {
            Schema::table($table, function (Blueprint $blueprint) use ($table, $indexes) {
                foreach ($indexes as $name => $column) {
                    if ($this->indexExists($table, $this->scopedName($table, $column))) {
                        $blueprint->dropUnique($this->scopedName($table, $column));
                    }

                    if (! $this->indexExists($table, $name)) {
                        $blueprint->unique($column, $name);
                    }
                }
            });
        }

        if (Schema::hasColumn('infractions', 'tenant_id')) {
            Schema::table('infractions', function (Blueprint $table) {
                $table->dropConstrainedForeignId('tenant_id');
            });
        }
    }

    private function scopedName(string $table, string $column): string
    {
        return "{$table}_tenant_id_{$column}_unique";
    }

    private function indexExists(string $table, string $index): bool
    {
        return collect(Schema::getIndexes($table))
            ->contains(fn (array $existing) => $existing['name'] === $index);
    }
};
