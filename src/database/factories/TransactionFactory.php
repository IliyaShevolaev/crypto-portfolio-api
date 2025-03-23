<?php

namespace Database\Factories;

use App\Models\Portfolio;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Factory>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $amount = fake()->randomFloat(null, 0);
        $priceAtMoment = fake()->randomFloat(null, 0);

        return [
            'coin_name' => fake()->randomElement(
                ['bitcoin', 'ethereum', 'solana', 'dogecoin']
            ),
            'description' => fake()->text(100),
            'amount' => $amount,
            'price_at_buy_moment' => $priceAtMoment,
            'total_value_in_usd' => $amount * $priceAtMoment,
            'is_buying' => true,
            'portfolio_id' => Portfolio::factory()->create()->id,
            'transaction_date' => now(),
        ];
    }
}
