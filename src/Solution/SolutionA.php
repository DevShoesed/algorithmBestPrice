<?php

declare(strict_types=1);

namespace App\Solution;

use App\Repository\AirportRepository;
use App\Repository\FlightRepository;
use SebastianBergmann\Type\VoidType;

class SolutionA
{
    private $airportTable;
    private $flightTable;
    private $bestPrice = [];

    public function __construct(AirportRepository $airportTable, FlightRepository $flightTable)
    {
        $this->airportTable = $airportTable;
        $this->flightTable = $flightTable;
    }

    /**
     * @param String $code_departure
     * @param String $code_arrival
     * @param Inte
     */
    public function getBestPrice(string $code_departure, string $code_arrival, int $maxStop): float
    {
        /* Set Price to Infinite for All arrival */
        foreach ($this->airportTable->all() as $arrival) {
            if ($code_departure !== $arrival->code) {
                $this->bestPrice[$code_departure][$arrival->code] = [
                    "price" => INF,
                    "stops" => 0
                ];
            }
        }

        $firstDestination = $this->flightTable->findByDeparture($code_departure);

        foreach ($firstDestination as $flight) {
            /* If price from  */
            if ($flight->price < $this->getPrice($code_departure, $flight->code_arrival)) {
                $this->bestPrice[$code_departure][$flight->code_arrival]["price"] = $flight->price;
                $this->bestPrice[$code_departure][$flight->code_arrival]["stops"] = 1;
            }
        }

        foreach ($this->bestPrice[$code_departure] as $codeFirstArrival => $flight) {
            $secodDestination = $this->flightTable->findByDeparture($codeFirstArrival);
            $firstPrice = $this->getPrice($code_departure, $codeFirstArrival);
            foreach ($secodDestination as $secondFlight) {
                if ($secondFlight->price < $this->getPrice($code_departure, $secondFlight->code_arrival)) {
                    $this->bestPrice[$code_departure][$secondFlight->code_arrival]["price"] = $firstPrice + $secondFlight->price;
                    $this->bestPrice[$code_departure][$secondFlight->code_arrival]["stops"] = 2;
                }
            }
        }

        return $this->getPrice($code_departure, $code_arrival);
    }

    /**
     * Get Price from $code_departure to $code_arrival
     * @param String $code_departure
     * @param String $code_arrival
     */
    private function getPrice(string $code_departure, string $code_arrival): float
    {
        return $this->bestPrice[$code_departure][$code_arrival]["price"];
    }
}
