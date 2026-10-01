<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vehicles', function (Blueprint $table): void {
            if (! Schema::hasColumn('vehicles', 'pneus_quantite_remplacee')) {
                $table->unsignedTinyInteger('pneus_quantite_remplacee')->default(0);
            }

            if (! Schema::hasColumn('vehicles', 'plaquettes_frein_quantite_remplacee')) {
                $table->unsignedTinyInteger('plaquettes_frein_quantite_remplacee')->default(0);
            }
        });
    }

    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table): void {
            $columns = array_filter([
                Schema::hasColumn('vehicles', 'pneus_quantite_remplacee') ? 'pneus_quantite_remplacee' : null,
                Schema::hasColumn('vehicles', 'plaquettes_frein_quantite_remplacee') ? 'plaquettes_frein_quantite_remplacee' : null,
            ]);

            if ($columns !== []) {
                $table->dropColumn($columns);
            }
        });
    }
};
