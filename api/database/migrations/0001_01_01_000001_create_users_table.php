<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('name');
            $table->string('organization');
            $table->string('email')->unique();
            $table->string('password');
            $table->foreignId('role_id')->constrained()->onDelete('cascade');
            $table->rememberToken();
            $table->timestamps();
            
        });

        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();          // Email de l'utilisateur
            $table->string('token');                   // Token de réinitialisation
            $table->timestamp('created_at')->nullable(); // Date de création
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_resets');
    }
};
