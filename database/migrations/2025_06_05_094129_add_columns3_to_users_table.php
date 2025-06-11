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
        Schema::table('users', function (Blueprint $table) {
            $table->string('category')->nullable()->after('img_url');
            $table->string('workplace')->nullable()->after('category');
            $table->string('level')->nullable()->after('workplace');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('category');
            $table->dropColumn('workplace');
            $table->dropColumn('level');
        });
    }
};
