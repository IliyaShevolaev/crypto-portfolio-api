<?php 

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CoinmarketcapService
{
    protected string $baseUrl;
    protected string $apiKey;

    public function __construct()
    {
        $this->baseUrl = 'https://pro-api.coinmarketcap.com/v1';
        $this->apiKey = config('services.api_keys.coinmarketcap');
    }

    private function request(string $endpoint, array $params = [])
    {
        $headers = [
            'Accept' => 'application/json',
            'X-CMC_PRO_API_KEY' => $this->apiKey
        ];

        $response = Http::withHeaders($headers)->get("{$this->baseUrl}/{$endpoint}", $params);

        if ($response->failed()) {
            throw new \Exception("CoinMarketCap API error: " . $response->body());
        }

        return $response->json();
    }

    public function getPrice(string $symbol, string $convert = 'USD')
    {
        $data = $this->request('cryptocurrency/quotes/latest', [
            'symbol' => $symbol,
            'convert' => $convert
        ]);

        return $data['data'][$symbol]['quote'][$convert]['price'] ?? null;
    }
}