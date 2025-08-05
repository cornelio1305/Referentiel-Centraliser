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
        Schema::create('scripts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->longText('content');
            $table->string('version')->default('1.0');
            $table->enum('status', ['draft', 'active', 'inactive', 'archived'])->default('draft');
            $table->enum('db_target', ['postgresql', 'mysql', 'sqlserver', 'db2', 'oracle', 'other'])->nullable();
            $table->string('server_name')->nullable();
            $table->string('database_name')->nullable();
            $table->string('author')->nullable();
            $table->json('affected_objects')->nullable(); // Tables, vues impactées
            $table->string('related_application')->nullable();
            $table->string('related_job')->nullable();
            $table->text('documentation')->nullable();
            $table->json('dependencies')->nullable();
            $table->string('file_path')->nullable(); // Pour l'import/export
            $table->string('file_name')->nullable();
            $table->string('file_size')->nullable();
            $table->string('checksum')->nullable(); // Pour vérifier l'intégrité
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            
            $table->index(['status', 'db_target']);
            $table->index(['created_by', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scripts');
    }
};
