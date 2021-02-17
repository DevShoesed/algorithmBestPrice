<?php

declare(strict_types=1);

use App\Model\Airport;
use App\Model\Flight;
use App\Repository\AirportRepository;
use App\Repository\FlightRepository;
use App\Solution\SolutionA;
use PHPUnit\Framework\TestCase;


final class SolutionATest extends TestCase
{



    /**
     * Test best Price
     */
    public function testBestPrice(): void
    {
        /* Set Airport Repository */
        $airportTable = new AirportRepository();
        $airportTable->setData([
            new Airport(1, "Roma Fiumicino", "FCO", 0, 0),
            new Airport(2, "Milano Malpensa", "MXP", 0, 0),
            new Airport(3, "Napoli", "NAP", 0, 0),
            new Airport(4, "Venezia", "VCE", 0, 0),
            new Airport(5, "Palermo", "PMO", 0, 0),
        ]);

        /* Set Flights Repository */
        $flightTable = new FlightRepository();
        $flightTable->setData([
            new Flight("NAP", "FCO", 100),
            new Flight("FCO", "MXP", 150),
            new Flight("MXP", "VCE", 250),
            new Flight("NAP", "MXP", 500),
            new Flight("NAP", "VCE", 250)
        ]);

        $test = new SolutionA($airportTable, $flightTable);
        $this->assertEquals(
            250,
            $test->getBestPrice("NAP", "MXP", 2)["price"]
        );

        $this->assertEquals(
            250,
            $test->getBestPrice("NAP", "VCE", 2)["price"]
        );
    }
}
