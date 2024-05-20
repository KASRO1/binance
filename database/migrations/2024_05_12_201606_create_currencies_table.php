<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    public function up(): void
    {

        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string("symbol")->unique();
            $table->string("name");
            $table->string("course");
            $table->boolean("spending_limit")->default(false);
            $table->string("type")->default("crypto");
            $table->timestamps();
        });



        $currencies = [
            ['symbol' => 'USD', 'name' => 'United States Dollar', 'course' => 1, 'spending_limit' => false, 'type' => 'fiat'],
            ['symbol' => 'EUR', 'name' => 'Euro', 'course' => 0.85, 'spending_limit' => false, 'type' => 'fiat'],
            ['symbol' => 'BTC', 'name' => 'Bitcoin', 'course' => 0.0001, 'spending_limit' => true, 'type' => 'crypto'],
            ['symbol' => 'ETH', 'name' => 'Ethereum', 'course' => 0.0002, 'spending_limit' => true, 'type' => 'crypto'],
            ['symbol' => 'LTC', 'name' => 'Litecoin', 'course' => 0.0003, 'spending_limit' => true, 'type' => 'crypto'],
            ['symbol' => 'USDT', 'name' => 'USDT', 'course' => 1, 'spending_limit' => true, 'type' => 'crypto'],
        ];
        foreach ($currencies as $currency) {
            DB::table('currencies')->insert($currency);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currencies');
    }
};
