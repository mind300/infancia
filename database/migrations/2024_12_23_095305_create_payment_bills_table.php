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
        Schema::create('payment_bills', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('descirption')->nullable();
            $table->foreignId('nursery_id')->constrained('nurseries');
            $table->foreignId('branch_id')->constrained('branches');
            $table->enum('status', ['mandatory', 'optional']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_bills');
    }
};



