<?php

namespace App\Services;

use App\Contracts\CoinApiInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class CoinGeckoService implements CoinApiInterface
{
    protected string $baseUrl;
    protected string $apiKey;

    public function __construct()
    {
        $this->baseUrl = 'https://api.coingecko.com/api/v3';
        $this->apiKey = config('services.api_keys.coingecko');
    }

    private function request(string $endpoint, array $params = [])
    {
        $headers = [
            'Accept' => 'application/json',
            'Authorization' =>  'Bearer ' . $this->apiKey,
        ];

        $response = Http::withHeaders($headers)->get("{$this->baseUrl}/{$endpoint}", $params);

        if ($response->failed()) {
            throw new \Exception("CoinGecko API error: " . $response->body());
        }

        return $response->json();
    }

    public function getCurrentPrice(string $symbol, string $currency = 'usd')
    {
        $cachedValue = Cache::get('coin:' . $symbol);

        if ($cachedValue) {
            return $cachedValue;
        }

        $data = $this->request("simple/price", [
            'ids' => $symbol,
            'vs_currencies' => $currency
        ]);

        Cache::set('coin:' . $symbol, $data[$symbol][$currency], 60 * 2);

        return $data[$symbol][$currency];
    }

    public function getHistoricalPrice(string $symbol, string $date, string $currency = 'usd')
    {
        $data = $this->request("coins/{$symbol}/history", [
            'date' => $date,
            'localization' => false,
        ]);

        return $data['market_data']['current_price'][$currency];
    }
}