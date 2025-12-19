<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
      Schema::create('themes', function (Blueprint $table) {
        $table->id();
        $table->string('name_fr')->unique();
        $table->string('name_en');
        $table->integer('ranking');
        $table->string('color');
        $table->foreignId('thematic_id')->constrained('thematics')->onDelete('cascade');
        $table->timestamps();
      });
    }

    public function down(): void
    {
      Schema::dropIfExists('themes');
    }
};
