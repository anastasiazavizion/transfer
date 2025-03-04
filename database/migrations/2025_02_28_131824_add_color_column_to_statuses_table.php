<?php

use App\Models\Status;
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
        Schema::table('statuses', function (Blueprint $table) {
            $table->string('color')->nullable();
        });

        // Update colors for each status
        Status::where('name', 'New')->update(['color' => '#008CBA']); // Blue
        Status::where('name', 'Confirmed')->update(['color' => '#4CAF50']); // Green
        Status::where('name', 'In Progress')->update(['color' => '#FF9800']); // Orange
        Status::where('name', 'Completed')->update(['color' => '#2196F3']); // Light Blue
        Status::where('name', 'Cancelled')->update(['color' => '#F44336']); // Red
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('statuses', function (Blueprint $table) {
           $table->dropColumn('color');
        });
    }
};
