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
        Schema::create('annonces', function (Blueprint $table) {
            $table->id();
            $table->foreignId('host_id')->constrained()->onUpdate('cascade');
            $table->foreignId('country_id')->constrained()->onUpdate('cascade');
            $table->string('title', '255');
            $table->text('description');
            $table->dateTime('schedule');
            $table->integer('max_guest',0,1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('annonces');
    }
};
