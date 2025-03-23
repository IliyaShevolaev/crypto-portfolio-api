<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Portfolio;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PortfolioTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /**@test */
    public function test_returns_user_portfolios_list()
    {
        $this->withoutExceptionHandling();

        $portfolios = Portfolio::factory()->count(3)->create(['user_id' => $this->user->id]);

        $jsonPortfolios = $portfolios->map(function ($portfolio) {
            return [
                'id' => $portfolio->id,
                'name' => $portfolio->name,
                'balance' => '0.0',
                'created_at' => $portfolio->created_at->toISOString(),
                'updated_at' => $portfolio->updated_at->toISOString(),
            ];
        })->toArray();

        $response = $this->actingAs($this->user)->get('/api/portfolio/index');

        $response->assertOk();
        $response->assertJson($jsonPortfolios);
    }

    /**@test */
    public function test_returns_user_single_portfolio()
    {   
        $this->withoutExceptionHandling();

        $portfolio = Portfolio::factory()->create(['user_id' => $this->user->id]);
        $portfolioJson = [
            'id' => $portfolio->id,
            'name' => $portfolio->name,
            'balance' => '0.0',
            'created_at' => $portfolio->created_at->toISOString(),
            'updated_at' => $portfolio->updated_at->toISOString(),
        ];

        $response = $this->actingAs($this->user)->get('/api/portfolio/show/' . $portfolio->id);

        $response->assertOk();
        $response->assertJson($portfolioJson);
    }

    /**@test */
    public function test_creates_user_portfolio()
    {   
        $this->withoutExceptionHandling();

        $data = [
            'name' => 'some string',
        ];
        $response = $this->actingAs($this->user)->post('/api/portfolio/store', $data);
        
        $portfolio = Portfolio::first();

        $response->assertOk();
        $this->assertDatabaseCount('portfolios' , 1);
        $this->assertEquals($data['name'], $portfolio->name);
        $this->assertEquals($this->user->id, $portfolio->user_id);
    }

    /**@test */
    public function test_updates_user_portfolio()
    {   
        $this->withoutExceptionHandling();
        $portfolio = Portfolio::factory()->create(['user_id' => $this->user->id]);

        $data = [
            'name' => 'some string updated',
        ];
        $response = $this->actingAs($this->user)->patch('/api/portfolio/update/' . $portfolio->id, $data);
        $portfolioUpdated = Portfolio::first();

        $response->assertOk();
        $this->assertDatabaseCount('portfolios' , 1);
        $this->assertEquals($data['name'], $portfolioUpdated->name);
        $this->assertEquals($this->user->id, $portfolioUpdated->user_id);
    }

    /**@test */
    public function test_deletes_user_portfolio()
    {
        $this->withoutExceptionHandling();

        $portfolio = Portfolio::factory()->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->user)->delete('api/portfolio/delete/' . $portfolio->id);

        $response->assertOk();
        $this->assertDatabaseCount('portfolios', 0);
    }

    /**@test */
    public function test_refuses_acces_to_not_owners_poftfolio()
    {
        $otherUser = User::factory()->create();
        $portfolio = Portfolio::factory()->create(['user_id' => $otherUser->id]);

        $response = $this->actingAs($this->user)->get('api/portfolio/show/' . $portfolio->id);
        $response->assertStatus(403);

        $response = $this->actingAs($this->user)->patch('api/portfolio/update/' . $portfolio->id, ['name' => 'test']);
        $response->assertStatus(403);

        $response = $this->actingAs($this->user)->delete('api/portfolio/delete/' . $portfolio->id);
        $response->assertStatus(403);
    }
}
