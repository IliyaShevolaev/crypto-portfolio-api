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

    public function getCurrentPrice(array $symbols) : array
    {
        $resultCoins = [];
        $coinsToRequest = [];

        foreach ($symbols as $symbol) {
            $cachedCoin = Cache::get('coins:' . $symbol);
            if ($cachedCoin === null) {
                $coinsToRequest[] = $symbol;
            } else {
                $resultCoins[$symbol] = $cachedCoin;
            }
        }

        if (!empty($coinsToRequest)) {
            $symbolsString = implode(',', $coinsToRequest);
            $coins = $this->request("simple/price", [
                'ids' => $symbolsString,
                'vs_currencies' => 'usd',
            ]);

            foreach ($coins as $coinName => $coinPrice) {
                Cache::put('coins:' . $coinName, $coinPrice, 60 * 2);
                $resultCoins[$coinName] = $coinPrice;
            }
        }

        return $resultCoins;
    }


    public function getHistoricalPrice(string $symbol, string $date)
    {
        $data = $this->request("coins/{$symbol}/history", [
            'date' => $date,
            'localization' => false,
        ]);

        return $data['market_data']['current_price']['usd'];
    }
}
