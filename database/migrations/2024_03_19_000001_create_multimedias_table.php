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
        Schema::create('multimedias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('path');
            $table->string('thumbnail')->nullable();
            $table->string('type');
            $table->string('text');
            $table->date('media_date');
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('multimedias');
    }
}; 