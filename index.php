<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use App\Model\Airport;
use App\Model\Flight;
use App\Repository\AirportRepository;
use App\Repository\FlightRepository;
use App\Solution\SolutionA;

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
    new Flight("FCO", "PMO", 150),
    new Flight("PMO", "MXP", 200),
    new Flight("NAP", "MXP", 500)
]);

/* Instance of Solution for find best price */
$solution = new SolutionA($airportTable, $flightTable);
