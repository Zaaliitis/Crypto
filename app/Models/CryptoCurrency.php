<?php
namespace App\Models;


class CryptoCurrency //immutable Class
{
    private string $name;
    private string $symbol;
    private string $date;
    private int $rank;
    private string $price;
    private string $change24h;
    private string $change7d;
    private string $change30d;
    private string $change90d;

    public function __construct
    (
    string $name,
    string $symbol,
    string $date,
    int $rank,
    string $price,
    string $change24h,
    string $change7d,
    string $change30d,
    string $change90d
    )
{
    $this->name = $name;
    $this->symbol = $symbol;
    $this->date = $date;
    $this->rank = $rank;
    $this->price = $price;
    $this->change24h = $change24h;
    $this->change7d = $change7d;
    $this->change30d = $change30d;
    $this->change90d = $change90d;
}


    public function getName(): string
    {
        return $this->name;
    }

    public function getChange7d(): string
    {
        return number_format($this->change7d, 2) . "%";
    }

    public function getChange24h(): string
    {
        return number_format($this->change24h, 2) . "%";
    }

    public function getChange30d(): string
    {
        return number_format($this->change30d, 2) . "%";
    }

    public function getChange90d(): string
    {
        return number_format($this->change90d, 2) . "%";
    }

    public function getDate(): string
    {
        return date_format(date_create($this->date), 'd-m-Y');
    }

    public function getPrice(): string
    {
        return number_format($this->price, 2) . "$";
    }

    public function getRank(): int
    {
        return $this->rank;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }
}