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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->foreignId('booking_id')->constrained()->onDelete('cascade');
    $table->decimal('amount', 8, 2);
    $table->string('payment_method', 50); // Visa, MasterCard...
    $table->string('payment_status', 50); // successful, failed
    $table->dateTime('payment_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
