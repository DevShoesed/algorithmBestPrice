<?php

declare(strict_types=1);

namespace App\Solution;

use App\Repository\AirportRepository;
use App\Repository\FlightRepository;

class BestPrice
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
     * @param Integer $maxStop
     */
    public function getBestPrice(string $code_departure, string $code_arrival, int $maxStop): array
    {
        /* Set Price to Infinite for All airports */
        foreach ($this->airportTable->all() as $arrival) {
            if ($code_departure !== $arrival->code) {
                $this->bestPrice[$code_departure][$arrival->code] = [
                    "price" => INF,
                    "stops" => 0
                ];
            }
        }

        /* Search First destination from Departure Airport  */
        $firstDestination = $this->flightTable->findByDeparture($code_departure);
        foreach ($firstDestination as $flight) {
            if ($flight->price < $this->getPrice($code_departure, $flight->code_arrival)) {
                $this->bestPrice[$code_departure][$flight->code_arrival]["price"] = $flight->price;
                $this->bestPrice[$code_departure][$flight->code_arrival]["stops"] = 1;
            }
        }

        /* Search other destination */
        for ($i = 2; $i <= $maxStop; $i++) {
            foreach ($this->bestPrice[$code_departure] as $codeSecondDeparture => $firstFlight) {
                $firstPrice = $firstFlight["price"];
                $firstStops = $firstFlight["stops"];

                /* if there are no previous flights, skip search coincidences */
                if ($firstFlight["stops"] == 0) {
                    continue;
                }

                /* Search all flights from second departure*/
                $secodDestination = $this->flightTable->findByDeparture($codeSecondDeparture);
                foreach ($secodDestination as $secondFlight) {

                    /* exclude return flights */
                    if ($code_departure == $secondFlight->code_arrival) {
                        continue;
                    }

                    if ($secondFlight->price < $this->getPrice($code_departure, $secondFlight->code_arrival)) {
                        $this->bestPrice[$code_departure][$secondFlight->code_arrival]["price"] = $firstPrice + $secondFlight->price;
                        $this->bestPrice[$code_departure][$secondFlight->code_arrival]["stops"] = $firstStops + 1;
                    }
                }
            }
        }

        return $this->bestPrice[$code_departure][$code_arrival];
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
