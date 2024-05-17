<?php

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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('orders');
            $table->string('completion');
            $table->string('available');
            $table->string('feedback');
            $table->string('qr_code');
            $table->string('сredentials');
            $table->string('currency_from');
            $table->string('currency_to');
            $table->string('limit');
            $table->string('commission');
            $table->boolean('bestPrice')->dafault(false);
            $table->boolean('AutoMode')->dafault(false);

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
