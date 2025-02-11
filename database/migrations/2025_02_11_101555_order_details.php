<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Order;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Order::class)->constrained('orders')->cascadeOnDelete();
            $table->boolean('is_own_car')->default(true);
            $table->float('km_to_location_1');
            $table->float('km_to_location_2');
            $table->float('km_back');
            $table->decimal('car_petrol_usage_per_100_km', 6, 2);
            $table->decimal('price_per_km_when_empty', 6, 2);
            $table->decimal('price_per_km_with_client', 6, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
