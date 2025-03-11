<?php

use App\Models\Car;
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
        Schema::table('cars', function (Blueprint $table) {
            $table->integer('max_people_amount')->default(1);
        });

        $car = Car::where('name', 'Toyota Land Cruiser')->first();
        $car->max_people_amount = env('VITE_ADULTS_AMOUNT');
        $car->save();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
           $table->dropColumn('max_people_amount');
        });
    }
};
