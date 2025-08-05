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
        Schema::create('script_versions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('script_id');
            $table->string('version');
            $table->longText('content');
            $table->text('description')->nullable();
            $table->json('metadata')->nullable(); // Métadonnées de cette version
            $table->string('change_reason')->nullable(); // Raison du changement
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
            
            $table->foreign('script_id')->references('id')->on('scripts')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            
            $table->unique(['script_id', 'version']);
            $table->index(['script_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('script_versions');
    }
}; 