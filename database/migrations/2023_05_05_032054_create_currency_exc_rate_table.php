<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('currency_exc_rate', function (Blueprint $table) {
            $table->increments('id');
            $table->string('from_currency_code');
            $table->string('from_currency_name');
            $table->string('to_currency_code');
            $table->string('to_currency_name');
            $table->float('exchange_rate', 16, 8);
            $table->dateTime('last_refreshed');
            $table->string('time_zone');
            $table->float('bid_price', 16, 8);
            $table->float('ask_price', 16, 8);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currency_exc_rate');
    }
};
