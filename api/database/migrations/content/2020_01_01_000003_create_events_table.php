<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{

    public function up(): void
    {
      Schema::create('events', function (Blueprint $table) {
        $table->id();
        $table->string('title_fr')->unique();
        $table->string('title_en')->nullable();
        $table->string('creator');
        $table->integer('start_year');
        $table->integer('start_month')->nullable();
        $table->integer('start_day')->nullable();
        $table->integer('end_year')->nullable();
        $table->integer('end_month')->nullable();
        $table->integer('end_day')->nullable();
        $table->text('description_fr')->nullable();
        $table->text('description_en')->nullable();
        $table->text('bibliography_fr')->nullable();
        $table->text('bibliography_en')->nullable();
        $table->float('km_up',6,2)->nullable();
        $table->float('km_down',6,2)->nullable();
        $table->foreignId('theme_id')->constrained('themes')->onDelete('cascade');
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->geometry('points', subtype: 'multiPoint', srid: 4326)->nullable()->spatialIndex();
        $table->geometry('lines', subtype: 'multiLineString', srid: 4326)->nullable()->spatialIndex();
        $table->geometry('polygons', subtype: 'multiPolygon', srid: 4326)->nullable()->spatialIndex();
        $table->timestamps();
      });
    }

    public function down(): void
    {
      Schema::dropIfExists('events');
    }
};
