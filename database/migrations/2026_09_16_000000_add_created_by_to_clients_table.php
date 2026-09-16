<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('clients', 'created_by')) {
            Schema::table('clients', function (Blueprint $table) {
                $table->foreignId('created_by')
                    ->nullable()
                    ->after('tenant_id')
                    ->constrained('users')
                    ->nullOnDelete();
            });
        }

        /*
         * Les clients deja presents sont attribues a l'owner de leur agence.
         * Si l'agence n'a pas encore d'owner, le premier utilisateur de cette
         * agence est retenu : aucune ligne existante ne reste visible a tous.
         */
        DB::table('clients')
            ->select('tenant_id')
            ->whereNull('created_by')
            ->whereNotNull('tenant_id')
            ->distinct()
            ->orderBy('tenant_id')
            ->pluck('tenant_id')
            ->each(function ($tenantId): void {
                $ownerId = $this->ownerIdForTenant((int) $tenantId);

                if ($ownerId !== null) {
                    DB::table('clients')
                        ->where('tenant_id', $tenantId)
                        ->whereNull('created_by')
                        ->update(['created_by' => $ownerId]);
                }
            });
    }

    public function down(): void
    {
        if (Schema::hasColumn('clients', 'created_by')) {
            Schema::table('clients', function (Blueprint $table) {
                $table->dropConstrainedForeignId('created_by');
            });
        }
    }

    private function ownerIdForTenant(int $tenantId): ?int
    {
        $owners = DB::table('users')
            ->join('model_has_roles', function ($join) {
                $join->on('model_has_roles.model_id', '=', 'users.id')
                    ->where('model_has_roles.model_type', 'App\\Models\\User');
            })
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('users.tenant_id', $tenantId)
            ->where('roles.name', 'owner')
            ->orderBy('users.id')
            ->value('users.id');

        return $owners !== null
            ? (int) $owners
            : DB::table('users')->where('tenant_id', $tenantId)->orderBy('id')->value('id');
    }
};
