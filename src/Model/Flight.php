<?php

declare(strict_types=1);

namespace App\Model;

class Flight
{
    public string $code_departure;
    public string $code_arrival;
    public float $price;

    public function __construct(string $code_departure, string $code_arrival, float $price)
    {
        $this->code_departure = $code_departure;
        $this->code_arrival = $code_arrival;
        $this->price = $price;
    }

    public function __toString(): string
    {
        return "FROM: $this->code_departure TO: $this->code_arrival PRICE: $this->price";
    }
}
