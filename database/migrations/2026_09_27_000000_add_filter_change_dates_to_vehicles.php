<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $columns = [
        'filtre_air_date',
        'filtre_huile_date',
        'filtre_carburant_date',
        'filtre_habitacle_date',
    ];

    public function up(): void
    {
        Schema::table('vehicles', function (Blueprint $table): void {
            foreach ($this->columns as $column) {
                if (! Schema::hasColumn('vehicles', $column)) {
                    $table->date($column)->nullable();
                }
            }
        });
    }

    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table): void {
            foreach ($this->columns as $column) {
                if (Schema::hasColumn('vehicles', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
