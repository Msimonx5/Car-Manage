<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Schema de base du multi-agences : table tenants et colonnes tenant_id.
 *
 * Ces objets existaient sur la base de developpement d'origine mais les
 * migrations correspondantes n'ont jamais ete versionnees. Un clone neuf
 * n'avait donc pas de table tenants ni de colonne tenant_id, et la migration
 * de cloisonnement echouait sur « Key column 'tenant_id' doesn't exist ».
 *
 * Chaque etape est conditionnelle : sur une base qui possede deja ces objets,
 * la migration ne fait rien.
 */
return new class extends Migration
{
    /**
     * Tables portant un tenant_id, avec la regle de suppression associee.
     */
    private array $tables = [
        'users' => 'cascade',
        'clients' => 'cascade',
        'vehicles' => 'cascade',
        'contracts' => 'cascade',
        'payments' => 'cascade',
    ];

    public function up(): void
    {
        if (! Schema::hasTable('tenants')) {
            Schema::create('tenants', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->text('description')->nullable();
                $table->string('horaires')->nullable();
                $table->string('telephone_contact')->nullable();
                $table->string('logo_path')->nullable();
                $table->unsignedInteger('next_contract_number')->default(1);
                $table->timestamp('trial_ends_at')->nullable();
                $table->timestamps();
            });
        }

        foreach ($this->tables as $name => $onDelete) {
            if (! Schema::hasTable($name) || Schema::hasColumn($name, 'tenant_id')) {
                continue;
            }

            Schema::table($name, function (Blueprint $table) use ($onDelete) {
                $column = $table->foreignId('tenant_id')->nullable()->after('id')->constrained();

                $onDelete === 'cascade'
                    ? $column->cascadeOnDelete()
                    : $column->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        foreach (array_keys($this->tables) as $name) {
            if (Schema::hasTable($name) && Schema::hasColumn($name, 'tenant_id')) {
                Schema::table($name, function (Blueprint $table) {
                    $table->dropConstrainedForeignId('tenant_id');
                });
            }
        }

        Schema::dropIfExists('tenants');
    }
};
