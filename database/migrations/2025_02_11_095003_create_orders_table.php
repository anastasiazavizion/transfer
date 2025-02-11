<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Status;
use App\Models\Client;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id()->from(2050);

            $table->string('address_from');
            $table->string('address_to');

            $table->integer('adults');
            $table->integer('children');
            $table->integer('suitcases');
            $table->time('travel_time'); // Travel time in HH:MM:SS format
            $table->float('kms');
            $table->float('total_price');
            $table->date('meeting_date');
            $table->time('meeting_time');
            $table->text('comment')->nullable()->default(null);
            $table->foreignIdFor(Status::class)->constrained('statuses')->noActionOnDelete();
            $table->foreignIdFor(Client::class)->constrained('clients')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
