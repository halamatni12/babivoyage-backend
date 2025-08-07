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
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
                $table->string('flight_number', 20)->unique();
    $table->string('departure_city', 100);
    $table->string('arrival_city', 100);
    $table->dateTime('departure_time');
    $table->dateTime('arrival_time');
    $table->string('duration', 50)->nullable();
    $table->decimal('price', 8, 2);
    $table->integer('seats_available');
    $table->string('status', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};
