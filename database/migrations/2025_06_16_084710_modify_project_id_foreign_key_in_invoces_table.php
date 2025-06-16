<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Get the actual foreign key name
        $foreignKeys = DB::select("
            SELECT CONSTRAINT_NAME 
            FROM information_schema.KEY_COLUMN_USAGE 
            WHERE TABLE_SCHEMA = DATABASE()
            AND TABLE_NAME = 'invoces' 
            AND COLUMN_NAME = 'project_id'
            AND REFERENCED_TABLE_NAME IS NOT NULL
        ");

        Schema::table('invoces', function (Blueprint $table) use ($foreignKeys) {
            if (!empty($foreignKeys)) {
                $foreignKeyName = $foreignKeys[0]->CONSTRAINT_NAME;
                // Drop the existing foreign key constraint
                $table->dropForeign($foreignKeyName);
            }
            
            // Add the new foreign key constraint with ON DELETE SET NULL
            $table->foreign('project_id')
                  ->references('id')
                  ->on('projects')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoces', function (Blueprint $table) {
            // Drop the SET NULL foreign key
            $table->dropForeign(['project_id']);
            
            // Restore the original foreign key constraint
            $table->foreign('project_id')
                  ->references('id')
                  ->on('projects')
                  ->onDelete('cascade');
        });
    }
};
