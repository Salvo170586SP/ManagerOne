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
            $table->string('surname')->nullable()->after('name');
            $table->unsignedInteger('IdClient')->nullable()->after('surname');
            $table->string('img_url')->nullable()->after('IdClient');
            $table->string('phone')->nullable()->after('img_url');
            $table->string('city')->nullable()->after('phone');
            $table->string('type')->nullable()->after('city');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('surname');
            $table->dropColumn('IdClient');
            $table->dropColumn('img_url');
            $table->dropColumn('phone');
            $table->dropColumn('city');
            $table->dropColumn('type');
        });
    }
};
