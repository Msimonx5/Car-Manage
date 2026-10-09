<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('infractions', function (Blueprint $table) {
            $table->decimal('tarif_jour', 10, 2)->nullable();
            $table->decimal('avance', 10, 2)->nullable();
        });

        DB::statement(<<<'SQL'
            UPDATE infractions AS i
            LEFT JOIN contracts AS c ON c.id = i.contract_id
            LEFT JOIN vehicles AS v ON v.id = i.vehicle_id
            SET i.tarif_jour = COALESCE(c.tarif_jour, v.prix_jour, 0),
                i.avance = COALESCE(c.avance, 0)
            WHERE i.tarif_jour IS NULL OR i.avance IS NULL
        SQL);
    }

    public function down(): void
    {
        Schema::table('infractions', function (Blueprint $table) {
            $table->dropColumn(['tarif_jour', 'avance']);
        });
    }
};
