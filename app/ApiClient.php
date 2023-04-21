<?php

namespace App;

use App\Models\CryptoCurrency;
use GuzzleHttp\Client;

class
ApiClient
{
    private Client $client;
    private const API_KEY = "3d9caaeb-f062-4a9f-bd8f-6b7a506fc187";

    public function __construct()
    {
        $this->client = new Client();
    }

    public function getData(int $limit, string $currency): object
    {
        $url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest';
        $parameters = [
            'start' => '1',
            'limit' => $limit,
            'convert' => $currency
        ];

        $headers = [
            'Accepts' => 'application/json',
            'X-CMC_PRO_API_KEY' => self::API_KEY
        ];

        $client = new Client();
        $response = $client->request('GET', $url, [
            'query' => $parameters,
            'headers' => $headers
        ]);
        return json_decode($response->getBody());

    }
    public function getCryptoCurrencyBySymbol(string $symbol): CryptoCurrency
    {
        $cryptoData = $this->getData(5000, "USD");
        $cryptoCurrency = "";
        foreach ($cryptoData->data as $cryptoCurrency) {
            $cryptoCurrency = new CryptoCurrency(
                $cryptoCurrency->name,
                $cryptoCurrency->symbol,
                $cryptoCurrency->quote->USD->market_cap,
                $cryptoCurrency->cmc_rank,
                $cryptoCurrency->quote->USD->price,
                $cryptoCurrency->quote->USD->percent_change_24h,
                $cryptoCurrency->quote->USD->percent_change_7d,
                $cryptoCurrency->quote->USD->percent_change_30d,
                $cryptoCurrency->quote->USD->percent_change_90d,
            );
            if ($cryptoCurrency->getSymbol() == $symbol) {
                return $cryptoCurrency;
            }
        }
        return $cryptoCurrency;
    }

    public function getTop(int $input): array
    {
        $cryptoData = $this->getData($input, "USD");
        $cryptoCurrencies = [];
        foreach ($cryptoData->data as $cryptoCurrency) {
            $cryptoCurrencies[] = new CryptoCurrency(
                $cryptoCurrency->name,
                $cryptoCurrency->symbol,
                $cryptoCurrency->quote->USD->market_cap,
                $cryptoCurrency->cmc_rank,
                $cryptoCurrency->quote->USD->price,
                $cryptoCurrency->quote->USD->percent_change_24h,
                $cryptoCurrency->quote->USD->percent_change_7d,
                $cryptoCurrency->quote->USD->percent_change_30d,
                $cryptoCurrency->quote->USD->percent_change_90d,
            );
        }
        return $cryptoCurrencies;
    }

}