<?php

use App\Models\City;
use App\Models\Country;
use App\Models\User;
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
        Schema::create('nurseries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->foreignIdFor(Country::class);
            $table->foreignIdFor(City::class);
            $table->string('address');
            $table->longText('about')->nullable();
            $table->integer('branches_number')->default(0);
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->boolean('generate_branch')->default(false);
            $table->foreignIdFor(User::class)->nullable()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nurseries');
    }
};
