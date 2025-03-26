<?php

namespace Tests\Feature;

use App\Contracts\CoinApiInterface;
use App\Models\Portfolio;
use App\Models\Transaction;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransactionStatsTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    /**@test */
    public function test_transaction_stats_returns_list_of_stats(): void
    {
        $this->withoutExceptionHandling();

        $btcMockedPrice = '50000.0';
        $apiMock = $this->createMock(CoinApiInterface::class);
        $apiMock->method('getCurrentPrice')->willReturn([
            'bitcoin' => [
                'usd' => $btcMockedPrice,
            ]
        ]);

        $portfolio = Portfolio::factory()->create(['user_id' => $this->user->id]);

        $transaction1 = Transaction::factory()->create(['coin_name' => 'bitcoin', 'portfolio_id' => $portfolio->id]);
        $transaction2 = Transaction::factory()->create(['coin_name' => 'bitcoin', 'portfolio_id' => $portfolio->id]);

        $response = $this->actingAs($this->user)->get('api/stats/transaction/index/' . $portfolio->id);

        $response->assertOk();
        $response->assertJsonCount(2);
    }

    /**@test */
    public function test_transaction_stats_returns_single_transaction(): void
    {
        $this->withoutExceptionHandling();

        $btcMockedPrice = '50000.0';
        $apiMock = $this->createMock(CoinApiInterface::class);
        $apiMock->method('getCurrentPrice')->willReturn([
            'bitcoin' => [
                'usd' => $btcMockedPrice,
            ]
        ]);

        $portfolio = Portfolio::factory()->create(['user_id' => $this->user->id]);

        $transaction1 = Transaction::factory()->create(['coin_name' => 'bitcoin', 'portfolio_id' => $portfolio->id]);
        $transaction2 = Transaction::factory()->create(['coin_name' => 'bitcoin', 'portfolio_id' => $portfolio->id]);

        $response = $this->actingAs($this->user)->get('api/stats/transaction/index/' . $portfolio->id);

        $response->assertOk();
        $response->assertJsonCount(2);
    }
}
