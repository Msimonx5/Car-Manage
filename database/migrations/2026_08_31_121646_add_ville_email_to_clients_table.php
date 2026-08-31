<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
        $table->string('ville', 100)->nullable()->after('adresse');
        $table->string('code_postal', 20)->nullable()->after('ville');
        $table->string('email', 150)->nullable()->after('telephone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('ville');
            $table->dropColumn('code_postal');
            $table->dropColumn('email');
        });
    }
};
