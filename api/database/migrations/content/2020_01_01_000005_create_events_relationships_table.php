<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
      Schema::create('events_relationships', function (Blueprint $table) {
        $table->foreignId('relationship_id')->constrained()->onDelete('cascade');
        $table->foreignId('from_event_id')->constrained('events')->onDelete('cascade');
        $table->foreignId('to_event_id')->constrained('events')->onDelete('cascade');
        $table->primary(['relationship_id', 'from_event_id', 'to_event_id']); // clé primaire composée
      });
    }

    public function down(): void
    {
      Schema::dropIfExists('events_relationships');
    }
};
