<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Les identifiants d'un client restent uniques dans le répertoire d'un
     * compte, mais peuvent exister dans celui d'un autre compte de l'agence.
     */
    public function up(): void
    {
        // Garder un index simple sur numero_permis : certaines bases ont une
        // cle etrangere qui utilise cette colonne comme index de reference.
        if (! $this->indexExists('clients_numero_permis_fk_idx')) {
            Schema::table('clients', function (Blueprint $table): void {
                $table->index('numero_permis', 'clients_numero_permis_fk_idx');
            });
        }

        if (! $this->indexExists('clients_tenant_permis_fk_idx')) {
            Schema::table('clients', function (Blueprint $table): void {
                $table->index(['tenant_id', 'numero_permis'], 'clients_tenant_permis_fk_idx');
            });
        }

        Schema::table('clients', function (Blueprint $table): void {
            foreach ([
                'clients_tenant_id_cin_unique',
                'clients_tenant_id_numero_permis_unique',
            ] as $index) {
                if ($this->indexExists($index)) {
                    $table->dropUnique($index);
                }
            }

            if (! $this->indexExists('clients_tenant_creator_cin_unique')) {
                $table->unique(['tenant_id', 'created_by', 'cin'], 'clients_tenant_creator_cin_unique');
            }

            if (! $this->indexExists('clients_tenant_creator_permis_unique')) {
                $table->unique(['tenant_id', 'created_by', 'numero_permis'], 'clients_tenant_creator_permis_unique');
            }
        });
    }

    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table): void {
            foreach ([
                'clients_tenant_creator_cin_unique',
                'clients_tenant_creator_permis_unique',
            ] as $index) {
                if ($this->indexExists($index)) {
                    $table->dropUnique($index);
                }
            }

            if (! $this->indexExists('clients_tenant_id_cin_unique')) {
                $table->unique(['tenant_id', 'cin'], 'clients_tenant_id_cin_unique');
            }

            if (! $this->indexExists('clients_tenant_id_numero_permis_unique')) {
                $table->unique(['tenant_id', 'numero_permis'], 'clients_tenant_id_numero_permis_unique');
            }
        });

        // L'index simple peut rester en place sans affecter les donnees.
    }

    private function indexExists(string $index): bool
    {
        return collect(Schema::getIndexes('clients'))
            ->contains(fn (array $existing): bool => $existing['name'] === $index);
    }
};
