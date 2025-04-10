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
            $table->unsignedBigInteger('report_id')->nullable();
            $table->string('path');
            $table->string('type');
            $table->text('text');
            $table->string('media_date');
            $table->timestamps();
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
