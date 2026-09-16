<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $tables = ['vehicles', 'contracts', 'payments', 'infractions'];

    public function up(): void
    {
        foreach ($this->tables as $tableName) {
            if (! Schema::hasTable($tableName) || Schema::hasColumn($tableName, 'created_by')) {
                continue;
            }

            Schema::table($tableName, function (Blueprint $table) {
                $table->foreignId('created_by')
                    ->nullable()
                    ->after('tenant_id')
                    ->constrained('users')
                    ->nullOnDelete();
            });
        }

        foreach ($this->tables as $tableName) {
            $this->assignExistingRowsToOwners($tableName);
        }
    }

    public function down(): void
    {
        foreach ($this->tables as $tableName) {
            if (Schema::hasTable($tableName) && Schema::hasColumn($tableName, 'created_by')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->dropConstrainedForeignId('created_by');
                });
            }
        }
    }

    private function assignExistingRowsToOwners(string $tableName): void
    {
        if (! Schema::hasTable($tableName) || ! Schema::hasColumn($tableName, 'created_by')) {
            return;
        }

        DB::table($tableName)
            ->select('tenant_id')
            ->whereNull('created_by')
            ->whereNotNull('tenant_id')
            ->distinct()
            ->orderBy('tenant_id')
            ->pluck('tenant_id')
            ->each(function ($tenantId) use ($tableName): void {
                $ownerId = $this->ownerIdForTenant((int) $tenantId);

                if ($ownerId !== null) {
                    DB::table($tableName)
                        ->where('tenant_id', $tenantId)
                        ->whereNull('created_by')
                        ->update(['created_by' => $ownerId]);
                }
            });
    }

    private function ownerIdForTenant(int $tenantId): ?int
    {
        $ownerId = DB::table('users')
            ->join('model_has_roles', function ($join) {
                $join->on('model_has_roles.model_id', '=', 'users.id')
                    ->where('model_has_roles.model_type', 'App\\Models\\User');
            })
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('users.tenant_id', $tenantId)
            ->where('roles.name', 'owner')
            ->orderBy('users.id')
            ->value('users.id');

        return $ownerId !== null
            ? (int) $ownerId
            : DB::table('users')->where('tenant_id', $tenantId)->orderBy('id')->value('id');
    }
};
