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
        Schema::create('invoces', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('IdInvoice')->nullable();
            /*  $table->foreignId('admin_id')->constrained('users')->onDelete('cascade'); */
            $table->foreignId('admin_id')->constrained('users')->nullable();
            $table->foreignId('client_id')->constrained('users')->nullable();
            $table->foreignId('project_id')->nullable();
           /*  $table->foreignId('client_id')->constrained('users');
            $table->foreignId('project_id')->constrained('projects'); */
            $table->string('name');
            $table->string('client_name');
            $table->text('description')->nullable();
            $table->decimal('preventive', 8, 2)->nullable();
            $table->string('pdf_path')->nullable();
            $table->boolean('is_available')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoces');
    }
};
