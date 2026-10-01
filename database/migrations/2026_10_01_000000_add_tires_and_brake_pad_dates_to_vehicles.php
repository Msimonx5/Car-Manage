<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vehicles', function (Blueprint $table): void {
            if (! Schema::hasColumn('vehicles', 'pneus_date')) {
                $table->date('pneus_date')->nullable();
            }

            if (! Schema::hasColumn('vehicles', 'plaquettes_frein_date')) {
                $table->date('plaquettes_frein_date')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table): void {
            $columns = array_filter([
                Schema::hasColumn('vehicles', 'pneus_date') ? 'pneus_date' : null,
                Schema::hasColumn('vehicles', 'plaquettes_frein_date') ? 'plaquettes_frein_date' : null,
            ]);

            if ($columns !== []) {
                $table->dropColumn($columns);
            }
        });
    }
};
