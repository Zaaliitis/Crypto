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
public function getCryptoCurrencyData(): array
{
    $url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest';
    $parameters = [
        'start' => '1',
        'limit' => '10',
        'convert' => 'USD'
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
$cryptoData = json_decode($response->getBody());
$cryptoCurrencies = [];
foreach ($cryptoData->data as $cryptoCurrency) {
    $cryptoCurrencies[] = new CryptoCurrency(
        $cryptoCurrency->name,
        $cryptoCurrency->symbol,
        $cryptoCurrency->date_added,
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