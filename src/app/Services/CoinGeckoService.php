<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CoinGeckoService
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
        $data = $this->request("simple/price", [
            'ids' => $symbol,
            'vs_currencies' => $currency
        ]);

        return $data[$symbol][$currency] ?? null;
    }

    public function getHistoricalPrice(string $symbol, string $date, string $currency = 'usd')
    {
        $data = $this->request("coins/{$symbol}/history", [
            'date' => $date,
            'localization' => false,
        ]);

        return $data['market_data']['current_price'][$currency] ?? null;
    }
}