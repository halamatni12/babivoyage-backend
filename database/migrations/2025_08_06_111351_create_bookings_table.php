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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->foreignId('flight_id')->constrained()->onDelete('cascade');
    $table->dateTime('booking_date');
    $table->string('seat_number', 10)->nullable();
    $table->string('status', 50); // confirmed, cancelled, pending
    $table->decimal('total_price', 8, 2);
    $table->foreignId('insurance_id')->nullable()->constrained('insurances')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
