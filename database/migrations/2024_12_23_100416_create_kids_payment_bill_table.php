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
        Schema::create('kids_payment_bill', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_bill_id')->constrained('payment_bills')->cascadeOnDelete();
            $table->foreignId('kid_id')->constrained('kids')->cascadeOnDelete();
            $table->enum('status', ['pending', 'review', 'accepted', 'rejcted'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kids_payment_bill');
    }
};
