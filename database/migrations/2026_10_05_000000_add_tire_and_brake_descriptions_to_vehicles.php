<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vehicles', function (Blueprint $table): void {
            if (! Schema::hasColumn('vehicles', 'pneus_description')) {
                $table->string('pneus_description')->nullable();
            }

            if (! Schema::hasColumn('vehicles', 'plaquettes_frein_description')) {
                $table->string('plaquettes_frein_description')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table): void {
            $columns = array_filter([
                Schema::hasColumn('vehicles', 'pneus_description') ? 'pneus_description' : null,
                Schema::hasColumn('vehicles', 'plaquettes_frein_description') ? 'plaquettes_frein_description' : null,
            ]);

            if ($columns !== []) {
                $table->dropColumn($columns);
            }
        });
    }
};
