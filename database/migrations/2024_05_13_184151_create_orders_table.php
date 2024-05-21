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
            $table->string('username')->nullable();
            $table->string('orders')->nullable();
            $table->string('completion')->nullable();
            $table->string('available')->nullable();
            $table->string('feedback')->nullable();
            $table->string('qr_code')->nullable();
            $table->string('сredentials')->nullable();
            $table->string('currency_from');
            $table->string('currency_to');
            $table->string('limit')->nullable();
            $table->string('spread')->default(0);
            $table->string('minimal_payment')->nullable();
            $table->boolean('bestPrice')->dafault(false);
            $table->boolean('AutoMode')->dafault(false);
            $table->boolean('active')->dafault(true);

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
