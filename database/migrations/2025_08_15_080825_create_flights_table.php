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
                $table->string('flight_number')->unique();
        $table->foreignId('airline_id')->constrained()->onDelete('cascade');
        $table->foreignId('departure_id')->constrained('destinations')->onDelete('cascade');
        $table->foreignId('arrival_id')->constrained('destinations')->onDelete('cascade');
        $table->dateTime('departure_time');
        $table->dateTime('arrival_time');
        $table->decimal('base_price', 10, 2);
        $table->enum('class', ['economy', 'business', 'first'])->default('economy');
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
