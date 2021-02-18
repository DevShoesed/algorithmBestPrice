<?php

declare(strict_types=1);

use App\Model\Airport;
use App\Model\Flight;
use App\Repository\AirportRepository;
use App\Repository\FlightRepository;
use App\Solution\BestPrice;
use PHPUnit\Framework\TestCase;


final class BestPriceTest extends TestCase
{

    private $airportTable;
    private $flightTable;

    /**
     * Test best Price for max 2 Stops
     */
    public function testBestPriceTwoStops(): void
    {
        $solution = new BestPrice($this->airportTable, $this->flightTable);

        $bestPrice = $solution->getBestPrice("NAP", "MXP", 2);
        $this->assertEquals(
            250,
            $bestPrice["price"]
        );

        $this->assertLessThanOrEqual(
            2,
            $bestPrice["stops"]
        );
    }

    /**
     * Test best Price for max 1 Stops
     */
    public function testBestPriceOneStop(): void
    {
        $solution = new BestPrice($this->airportTable, $this->flightTable);

        $bestPrice = $solution->getBestPrice("NAP", "MXP", 1);

        $this->assertEquals(
            500,
            $bestPrice["price"]
        );

        $this->assertEquals(
            1,
            $bestPrice["stops"]
        );
    }

    /**
     * Test best price Not Found
     */
    public function testBestPriceNotFound(): void
    {
        $solution = new BestPrice($this->airportTable, $this->flightTable);
        $bestPrice = $solution->getBestPrice("FCO", "VCE", 1);

        $this->assertEquals(
            INF,
            $bestPrice["price"]
        );
        $this->assertEquals(
            0,
            $bestPrice["stops"]
        );
    }


    protected function setUp(): void
    {
        parent::setUp();

        /* Set Airport Repository */
        $this->airportTable = new AirportRepository();
        $this->airportTable->setData([
            new Airport(1, "Roma Fiumicino", "FCO", 0, 0),
            new Airport(2, "Milano Malpensa", "MXP", 0, 0),
            new Airport(3, "Napoli", "NAP", 0, 0),
            new Airport(4, "Venezia", "VCE", 0, 0),
            new Airport(5, "Palermo", "PMO", 0, 0),
        ]);

        /* Set Flights Repository */
        $this->flightTable = new FlightRepository();
        $this->flightTable->setData([
            new Flight("NAP", "FCO", 100),
            new Flight("FCO", "MXP", 150),
            new Flight("MXP", "VCE", 250),
            new Flight("NAP", "MXP", 500),
            new Flight("NAP", "VCE", 250)
        ]);
    }

    protected function tearDown(): void
    {
        $this->airportTable = null;
        $this->flightTable = null;
        parent::tearDown();
    }
}
