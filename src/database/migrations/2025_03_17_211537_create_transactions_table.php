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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            $table->string('coin_name');
            $table->string('description')->nullable();
            $table->decimal('amount', 30, 10);
            $table->decimal('price_at_buy_moment', 30, 10);
            $table->decimal('total_value_in_usd', 30, 10);
            $table->boolean('is_buying');
            $table->foreignId('portfolio_id')->constrained('portfolios', 'id')->onDelete('cascade');
            $table->timestamp('transaction_date')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
