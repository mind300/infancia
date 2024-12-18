<?php

use App\Models\City;
use App\Models\Country;
use App\Models\Nursery;
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
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->foreignIdFor(Country::class);
            $table->foreignIdFor(City::class);
            $table->foreignId('manager_id')->constrained('users');
            $table->foreignId('nursery_id')->constrained('nurseries');
            $table->boolean('main')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
