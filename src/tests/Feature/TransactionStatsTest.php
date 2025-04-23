<?php

namespace Tests\Feature;

use App\Contracts\CoinApiInterface;
use App\Models\Portfolio;
use App\Models\Transaction;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransactionStatsTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private $apiMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $btcMockedPrice = '50000.0';
        $apiMock = $this->createMock(CoinApiInterface::class);
        $apiMock->method('getCurrentPrice')->willReturn([
            'bitcoin' => [
                'usd' => $btcMockedPrice,
            ]
        ]);
        $this->app->instance(CoinApiInterface::class, $apiMock);
    }

    /**@test */
    public function test_transaction_stats_returns_single_transaction(): void
    {
        $this->withoutExceptionHandling();
    
        $portfolio = Portfolio::factory()->create(['user_id' => $this->user->id]);
    
        $transaction = Transaction::factory()->create([
            'coin_name' => 'bitcoin', 
            'portfolio_id' => $portfolio->id, 
            'price_at_buy_moment' => 50000,
            'total_value_in_usd' => 50000,
            'amount' => 1
        ]);
    
        $statsJson = [
            (string)$transaction->id => [
                'profitValuePercent' => 0,
                'profitValuePrice' => 0,
                'profitSide' => '+',
            ]
        ];
    
        $response = $this->actingAs($this->user)->get('api/stats/transaction/get/' . $transaction->id);
        $response->assertOk();
        $response->assertJson($statsJson);
    
        $transaction1 = Transaction::factory()->create([
            'coin_name' => 'bitcoin', 
            'portfolio_id' => $portfolio->id, 
            'price_at_buy_moment' => 25000,
            'total_value_in_usd' => 50000,
            'amount' => 2
        ]);
    
        $statsJson1 = [
            (string)$transaction1->id => [
                'profitValuePercent' => 100,
                'profitValuePrice' => 50000,
                'profitSide' => '+',
            ]
        ];
    
        $response1 = $this->actingAs($this->user)->get('api/stats/transaction/get/' . $transaction1->id);
        $response1->assertOk();
        $response1->assertJson($statsJson1);

    }
    

    /**@test */
    public function test_only_owner_of_transaction_stats_can_see_stats(): void
    {
        $otherUser = User::factory()->create();
        
        $portfolio = Portfolio::factory()->create(['user_id' => $this->user->id]);
        $transaction = Transaction::factory()->create([
            'coin_name' => 'bitcoin', 
            'portfolio_id' => $portfolio->id]);

        $response = $this->actingAs($otherUser)->get('api/stats/transaction/get/' . $transaction->id);
        $response->assertStatus(403);
    }
}
