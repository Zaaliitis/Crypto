<?php
namespace App;
use App\ApiClient;
use App\Models\CryptoCurrency;
class Application
{
    private ApiClient $apiClient;
    public function __construct( ApiClient $apiClient)
    {
                $this->apiClient = $apiClient;
    }
    function run()
    {
        while (true) {
            echo "-----------------------------------" . PHP_EOL;
            echo "Welcome to my Crypto Currency app! \n";
            echo "Enter a number to perform an action! \n";
            echo "Choose 0 for EXIT\n";
            echo "Choose 1 to list TOP Crypto Currencies by Market Cap\n";
            echo "Choose 2 to find a crypto currency by symbol\n";
            echo "Choose 3 to enter crypto currency calculator\n";
            echo "Choose 4 to convert crypto to another currency\n";
            echo "-----------------------------------" . PHP_EOL;

            $command = (int)readline();

            switch ($command) {
                case 0:
                    echo "Bye!" . PHP_EOL;
                    die;
                case 1:
                    $this->list();
                    break;
                case 2:
                    $this->find();
                    break;
                case 3:
                    $this->calculate();
                    break;
                case 4:
                    $this->convert();
                    break;
                default:
                    echo "Sorry this option doesn't exist." . PHP_EOL;
            }
        }
    }
    private  function list(): void
    {

        $input = (int)readline("Enter the number of cryptocurrencies you want to see: ");
        if ($input !== 0) {
            $cryptoCurrencies = $this->apiClient->getTop($input);
            echo "-_- TOP $input Crypto Currencies by market cap! -_-" . PHP_EOL;
            foreach ($cryptoCurrencies as $cryptoCurrency) {
                $this->formatOutput($cryptoCurrency);
            }
        } else {
            echo "Invalid input, try numbers!" . PHP_EOL;
        }

    }
    private function find(): void
    {
        $input = readline("Enter the symbol of crypto currency you want to find: ");
        $cryptoCurrency = $this->apiClient->getCryptoCurrencyBySymbol($input);
        $this->formatOutput($cryptoCurrency);
    }
    private function calculate(): void
    {
        /** @var CryptoCurrency $cryptoCurrency */
        $crypto = readline("Enter symbol of crypto currency: ");
        $amount = (int)readline("Enter amount of cryptocurrency: ");
//
        $cryptoCurrency = $this->apiClient->getCryptoCurrencyBySymbol($crypto);
        $price = $cryptoCurrency->getPrice();
        $result = number_format($price * $amount, 2);
        echo "Result: $result $" . PHP_EOL;
    }
    private function convert(): void
    {
        $crypto = readline("Enter crypto currency (for example BTC, ETH, XRP): ");
        $fiat = readline("Enter fiat currency (for example USD, EUR, GBP): ");
        $cryptoData = $this->apiClient->getData(5000, $fiat);
        $cryptoCurrency = "";
        foreach ($cryptoData->data as $cryptoCurrency) {
            $cryptoCurrency = new CryptoCurrency(
                $cryptoCurrency->name,
                $cryptoCurrency->symbol,
                $cryptoCurrency->quote->$fiat->market_cap,
                $cryptoCurrency->cmc_rank,
                $cryptoCurrency->quote->$fiat->price,
                $cryptoCurrency->quote->$fiat->percent_change_24h,
                $cryptoCurrency->quote->$fiat->percent_change_7d,
                $cryptoCurrency->quote->$fiat->percent_change_30d,
                $cryptoCurrency->quote->$fiat->percent_change_90d,
            );
            if ($cryptoCurrency->getSymbol() == $crypto) {
                echo "The price of $crypto is: " . $cryptoCurrency->getFormattedPrice() . $fiat . PHP_EOL;
            }


        }
    }

    private function formatOutput($cryptoCurrency): void
    {
        /** @var CryptoCurrency $cryptoCurrency */
        echo "--- [{$cryptoCurrency->getRank()}]";
        echo " {$cryptoCurrency->getSymbol()} / {$cryptoCurrency->getName()} / {$cryptoCurrency->getFormattedPrice()} ---" . PHP_EOL;
        echo "-------- Market changes --------" . PHP_EOL . "   24h   /   7d   /   30d   /   90d   " . PHP_EOL;
        echo "{$cryptoCurrency->getChange24h()}% / {$cryptoCurrency->getChange7d()}% / ";
        echo "{$cryptoCurrency->getChange30d()}% / {$cryptoCurrency->getChange90d()}%" . PHP_EOL;
        echo "--- Market cap: {$cryptoCurrency->getMarketCap()} ---" . PHP_EOL;
        echo PHP_EOL;
    }
}