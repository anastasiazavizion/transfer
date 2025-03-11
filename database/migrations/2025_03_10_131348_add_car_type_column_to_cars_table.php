<?php

use App\Models\Car;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\CarType;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::table('cars', function (Blueprint $table) {
            $table->foreignIdFor(CarType::class)->nullable()->constrained('car_types')->nullOnDelete();
        });

        $car = Car::where('name', 'Toyota Land Cruiser')->first();
        $carType = CarType::where('name', 'Comfort +')->first();
        $car->carType()->associate($carType);
        $car->save();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->dropColumn('car_type_id');
            $table->dropForeign(['car_type_id']);
        });
    }
};

