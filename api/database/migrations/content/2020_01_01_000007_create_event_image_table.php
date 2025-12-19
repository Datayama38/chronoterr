<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventImageTable extends Migration
{

    public function up(): void
    {
      Schema::create('event_image', function (Blueprint $table) {
          $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
          $table->foreignId('image_id')->constrained('images')->onDelete('cascade');
          $table->primary(['event_id', 'image_id']); // clé primaire composée
      });
    }

    public function down(): void
    {
      Schema::dropIfExists('event_image');
    }
};
