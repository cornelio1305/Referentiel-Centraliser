<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('script_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('script_id')->constrained()->onDelete('cascade');
            $table->timestamp('viewed_at');
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();

            $table->index(['user_id', 'viewed_at']);
            $table->index(['script_id', 'viewed_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('script_views');
    }
};
