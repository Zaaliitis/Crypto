<?php
require_once "vendor/autoload.php";

use App\ApiClient;
use App\Models\CryptoCurrency;

$client = new ApiClient();
$cryptoCurrencies = $client->getCryptoCurrencyData();
echo "-_-_-_ TOP 10 Crypto Currencies right now! _-_-_-" . PHP_EOL;
foreach ($cryptoCurrencies as $cryptoCurrency) {
    /** @var CryptoCurrency $cryptoCurrency */
    echo "[{$cryptoCurrency->getRank()}]";
    echo " / {$cryptoCurrency->getSymbol()} / {$cryptoCurrency->getName()} / {$cryptoCurrency->getPrice()} /" . PHP_EOL;
    echo "-------- Market changes --------" . PHP_EOL . "   24h   /   7d   /   30d   /   90d   " . PHP_EOL;
    echo "{$cryptoCurrency->getChange24h()}% / {$cryptoCurrency->getChange7d()}% / ";
    echo "{$cryptoCurrency->getChange30d()}% / {$cryptoCurrency->getChange90d()}%" . PHP_EOL;
    echo PHP_EOL;
}



