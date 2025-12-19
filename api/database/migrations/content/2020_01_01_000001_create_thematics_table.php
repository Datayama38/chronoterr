<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{

    public function up(): void
    {
      Schema::create('thematics', function (Blueprint $table) {
        $table->id();
        $table->string('name_fr')->unique();
        $table->string('name_en');
        $table->integer('ranking');
        $table->timestamps();
      });
    }

    public function down()
    {
      Schema::dropIfExists('thematics');
    }
};
