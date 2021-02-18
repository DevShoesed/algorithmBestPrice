<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\Flight;

class FlightRepository
{

    private $data = [];

    /**
     * Return list of Flight from code_departure
     */
    public function findByDeparture(string $code_departure): array
    {
        $flightsFound = array_filter($this->all(), function ($flight) use (&$code_departure) {
            return $flight->code_departure == $code_departure;
        });

        return $flightsFound;
    }

    /**
     * Return Example Data
     */
    public function all(): array
    {
        return $this->data;
    }

    /**
     * Set Data
     * @param Flight[] $data
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }
}
