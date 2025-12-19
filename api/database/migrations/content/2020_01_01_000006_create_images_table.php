<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{

    public function up(): void
    {
      Schema::create('images', function (Blueprint $table) {
        $table->id();
        $table->string('filename')->unique();
        $table->text('legend_fr')->nullable();
        $table->text('legend_en')->nullable();
        $table->string('copyright')->nullable();
        $table->timestamps();
      });
    }

    public function down(): void
    {
      Schema::dropIfExists('images');
    }
};
