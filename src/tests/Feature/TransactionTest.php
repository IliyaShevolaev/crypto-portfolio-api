<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Portfolio;
use Brick\Math\BigDecimal;
use App\Models\Transaction;
use Brick\Math\RoundingMode;
use App\Contracts\CoinApiInterface;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /**@test */
    public function test_returns_transactions_of_portfolio()
    {
        $this->withoutExceptionHandling();

        $portfolio = Portfolio::factory()->create(['user_id' => $this->user->id]);
        $transactions = Transaction::factory(3)->create(['portfolio_id' => $portfolio->id]);
        $transactionsJson = $transactions->map(function ($transaction) {
            return [
                'id' => $transaction->id,
                'coin_name' => $transaction->coin_name,
                'description' => $transaction->description,
                'amount' => BigDecimal::of($transaction->amount)->toFloat(),
                'price_at_buy_moment' => BigDecimal::of($transaction->price_at_buy_moment)->toFloat(),
                'total_value_in_usd' => BigDecimal::of($transaction->total_value_in_usd)->toFloat(),
                'is_buying' => (int) $transaction->is_buying,
                'portfolio_id' => $transaction->portfolio_id,
                'transaction_date' => $transaction->transaction_date->setTimezone('UTC')->format('Y-m-d H:i:s'),
            ];
        })->toArray();

        $response = $this->actingAs($this->user)->get('/api/transaction/index/' . $portfolio->id);

        $response->assertOk();
        $response->assertJson($transactionsJson);
    }

    /**@test */
    public function test_returns_single_transaction()
    {
        $this->withoutExceptionHandling();

        $portfolio = Portfolio::factory()->create(['user_id' => $this->user->id]);
        $transaction = Transaction::factory()->create(['portfolio_id' => $portfolio->id]);
        $transactionJson = [
            'id' => $transaction->id,
            'coin_name' => $transaction->coin_name,
            'description' => $transaction->description,
            'amount' => BigDecimal::of($transaction->amount)->toFloat(),
            'price_at_buy_moment' => BigDecimal::of($transaction->price_at_buy_moment)->toFloat(),
            'total_value_in_usd' => BigDecimal::of($transaction->total_value_in_usd)->toFloat(),
            'is_buying' => (int) $transaction->is_buying,
            'portfolio_id' => $transaction->portfolio_id,
            'transaction_date' => $transaction->transaction_date->setTimezone('UTC')->format('Y-m-d H:i:s'),
        ];

        $response = $this->actingAs($this->user)->get('/api/transaction/show/' . $transaction->id);

        $response->assertOk();
        $response->assertJson($transactionJson);
    }

    /**@test */
    public function test_creates_transaction_to_portfolio() // api call
    {
        $this->withoutExceptionHandling();

        $portfolio = Portfolio::factory()->create(['user_id' => $this->user->id]);
        $dataAmount = [
            'coin_name' => 'bitcoin',
            'amount' => '0.001',
            'is_buying' => true,
            'portfolio_id' => $portfolio->id,
        ];

        $btcMockedPrice = '50000.0';
        $apiMock = $this->createMock(CoinApiInterface::class);
        $apiMock->method('getCurrentPrice')->willReturn([
            'bitcoin' => [
                'usd' => $btcMockedPrice,
            ]
        ]);
        $this->app->instance(CoinApiInterface::class, $apiMock);

        $response = $this->actingAs($this->user)->post('/api/transaction/store', $dataAmount);

        $response->assertOk();
        $response->assertJsonStructure(["coin_name", "description", "amount", "price_at_buy_moment", "total_value_in_usd", "is_buying", "portfolio_id", "transaction_date"]);
        $this->assertDatabaseCount('transactions', 1);

        $dataUsdValue = [
            'coin_name' => 'bitcoin',
            'total_value_in_usd' => '100.0',
            'is_buying' => true,
            'portfolio_id' => $portfolio->id,
        ];

        $response = $this->actingAs($this->user)->post('/api/transaction/store', $dataUsdValue);

        $response->assertOk();
        $response->assertJsonStructure(["coin_name", "description", "amount", "price_at_buy_moment", "total_value_in_usd", "is_buying", "portfolio_id", "transaction_date"]);
        $this->assertDatabaseCount('transactions', 2);
    }

    /**@test */
    public function test_calculates_transaction_by_getting_amount_correct() 
    {
        $this->withoutExceptionHandling();

        $portfolio = Portfolio::factory()->create(['user_id' => $this->user->id]);

        $mockedBtcPrice = '50000.0';
        $apiMocked = $this->createMock(CoinApiInterface::class);
        $apiMocked->method('getCurrentPrice')->willReturn([
            'bitcoin' => ['usd' => $mockedBtcPrice]
        ]);
        app()->instance(CoinApiInterface::class, $apiMocked);

        $testCases = [
            ['amount' => '0.001'],
            ['amount' => '0.002'],
            ['amount' => '0.0005'],
            ['amount' => '1.0'],
        ];

        foreach($testCases as $testCase) {
            $amountData = [
                'coin_name' => 'bitcoin',
                'amount' => $testCase['amount'],
                'is_buying' => true,
                'portfolio_id' => $portfolio->id,
            ];
    
            $response = $this->actingAs($this->user)->post('/api/transaction/store', $amountData);
    
            $response->assertOk();
        
            $expectedTotalValue = BigDecimal::of($mockedBtcPrice)->multipliedBy(BigDecimal::of($amountData['amount']))->toFloat();
            $transaction = Transaction::where('amount', $amountData['amount'])->first();
            $this->assertEquals($expectedTotalValue, $transaction->total_value_in_usd);
        }
    }

    /**@test */
    public function test_calculates_transaction_by_getting_usd_price_correct() 
    {
        $this->withoutExceptionHandling();

        $portfolio = Portfolio::factory()->create(['user_id' => $this->user->id]);

        $mockedBtcPrice = '50000.0';
        $apiMocked = $this->createMock(CoinApiInterface::class);
        $apiMocked->method('getCurrentPrice')->willReturn([
            'bitcoin' => ['usd' => $mockedBtcPrice]
        ]);
        app()->instance(CoinApiInterface::class, $apiMocked);

        $testCases = [
            ['total_value_in_usd' => '100.0'],
            ['total_value_in_usd' => '2500.0'],
            ['total_value_in_usd' => '5.99'],
            ['total_value_in_usd' => '100.50'],
        ];

        foreach($testCases as $testCase) {
            $usdValueData = [
                'coin_name' => 'bitcoin',
                'total_value_in_usd' => $testCase['total_value_in_usd'],
                'is_buying' => true,
                'portfolio_id' => $portfolio->id,
            ];
    
            $response = $this->actingAs($this->user)->post('/api/transaction/store', $usdValueData);
    
            $response->assertOk();
        
            $expectedTotalValue = BigDecimal::of($testCase['total_value_in_usd'])->dividedBy(BigDecimal::of($mockedBtcPrice), 8, RoundingMode::HALF_UP)->toFloat();
            $transaction = Transaction::where('total_value_in_usd', $usdValueData['total_value_in_usd'])->first();
            $this->assertEquals($expectedTotalValue, $transaction->amount);
        }
    }

    /**@test */
    public function test_calculates_transaction_by_getting_historical_price() 
    {
        $this->withoutExceptionHandling();

        $portfolio = Portfolio::factory()->create(['user_id' => $this->user->id]);

        $mockedBtcPrice = '50000.0';
        $apiMocked = $this->createMock(CoinApiInterface::class);
        $apiMocked->method('getHistoricalPrice')->willReturn($mockedBtcPrice);
        app()->instance(CoinApiInterface::class, $apiMocked);

        $testCases = [
            ['total_value_in_usd' => '100.0'],
            ['total_value_in_usd' => '2500.0'],
            ['total_value_in_usd' => '5.99'],
            ['total_value_in_usd' => '100.50'],
        ];

        foreach($testCases as $testCase) {
            $usdValueData = [
                'coin_name' => 'bitcoin',
                'total_value_in_usd' => $testCase['total_value_in_usd'],
                'is_buying' => true,
                'portfolio_id' => $portfolio->id,
                'transaction_date' => '01-01-2025',
            ];
    
            $response = $this->actingAs($this->user)->post('/api/transaction/store', $usdValueData);
    
            $response->assertOk();
        
            $expectedTotalValue = BigDecimal::of($testCase['total_value_in_usd'])->dividedBy(BigDecimal::of($mockedBtcPrice), 8, RoundingMode::HALF_UP)->toFloat();
            $transaction = Transaction::where('total_value_in_usd', $usdValueData['total_value_in_usd'])->first();
            $this->assertEquals($expectedTotalValue, $transaction->amount);
        }
    }


    /**@test */
    public function test_updates_transaction_to_portfolio()
    {
        $this->withoutExceptionHandling();

        $portfolio = Portfolio::factory()->create(['user_id' => $this->user->id]);
        $transaction = Transaction::factory()->create(['portfolio_id' => $portfolio->id]);

        $btcMockedPrice = '50000.0';
        $apiMock = $this->createMock(CoinApiInterface::class);
        $apiMock->method('getCurrentPrice')->willReturn([
            'bitcoin' => [
                'usd' => $btcMockedPrice,
            ]
        ]);
        $this->app->instance(CoinApiInterface::class, $apiMock);

        $dataAmount = [
            'coin_name' => 'bitcoin',
            'description' => 'updated',
            'amount' => '0.001',
            'is_buying' => true,
            'portfolio_id' => $portfolio->id,
        ];
        
        $response = $this->actingAs($this->user)->patch('/api/transaction/update/' . $transaction->id, $dataAmount);
        $transactionUpdated = Transaction::first(); 

        $response->assertOk();
        $response->assertJsonStructure([ "coin_name", "description", "amount", "price_at_buy_moment", "total_value_in_usd", "is_buying", "portfolio_id", "transaction_date"
        ]);
        $this->assertEquals($dataAmount['description'], $transactionUpdated->description);
    }

    /**@test */
    public function test_delete_transaction_from_portfolio()
    {
        $this->withoutExceptionHandling();

        $portfolio = Portfolio::factory()->create(['user_id' => $this->user->id]);
        $transaction = Transaction::factory()->create(['portfolio_id' => $portfolio->id]);

        $response = $this->actingAs($this->user)->delete('/api/transaction/delete/' . $transaction->id);

        $response->assertOk();
        $this->assertDatabaseCount('transactions', 0);
    }

    /**@test */
    public function test_refuses_acces_to_not_owners_transactions()
    {
        $otherUser = User::factory()->create();
        $portfolio = Portfolio::factory()->create(['user_id' => $otherUser->id]);
        $transaction = Transaction::factory()->create(['portfolio_id' => $portfolio->id]);

        $response = $this->actingAs($this->user)->get('/api/transaction/index/' . $portfolio->id);
        $response->assertStatus(403);

        $response = $this->actingAs($this->user)->get('/api/transaction/show/' . $transaction->id);
        $response->assertStatus(403);

        $dataAmount = [
            'coin_name' => 'bitcoin',
            'description' => 'updated',
            'amount' => '0.001',
            'is_buying' => true,
            'portfolio_id' => $portfolio->id,
        ];
        $response = $this->actingAs($this->user)->patch('/api/transaction/update/' . $transaction->id, $dataAmount);
        $response->assertStatus(403);
    }
}
