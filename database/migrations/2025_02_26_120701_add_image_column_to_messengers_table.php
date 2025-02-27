<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Messenger;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('messengers', function (Blueprint $table) {
            $table->string('image')->nullable();
        });

        $viber = Messenger::where('name', 'Viber')->first();
        $viber->image = '/messengers/viber.svg';
        $viber->save();

        $telegram = Messenger::where('name', 'Telegram')->first();
        $telegram->image = '/messengers/telegram.svg';
        $telegram->save();

        $whatsapp = Messenger::where('name', 'Whatsapp')->first();
        $whatsapp->image = '/messengers/whatsapp.svg';
        $whatsapp->save();

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messengers', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
};
