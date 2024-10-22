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
        Schema::create('parsing_results', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->json('resulting_files')->default('{}');
            $table->enum('export_type', \App\Enums\ExportType::values());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parsing_results');
    }
};
