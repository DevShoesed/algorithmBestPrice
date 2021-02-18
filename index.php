<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use App\Model\Flight;
use App\Model\Airport;
use App\Repository\AirportRepository;
use App\Repository\FlightRepository;
use App\Solution\SolutionA;

function csvToAirport($row): Airport
{
    $array = str_getcsv($row);
    return new Airport((int)$array[0], $array[1], $array[2], (float)$array[3], (float)$array[4]);
}


function csvToFlight($row): Flight
{
    $array = str_getcsv($row);
    return new Flight($array[0], $array[1], (float)$array[2]);
}


/* Set Airport Repository */

$airportTable = new AirportRepository();
$airportTable->setData(array_map("csvToAirport", file("./data/airports.csv")));

/* Set Flights Repository */
$flightTable = new FlightRepository();
$flightTable->setData(array_map("csvToFlight", file("./data/flights.csv")));


/* Instance of Solution for find best price */
$solution = new SolutionA($airportTable, $flightTable);
echo $solution->getBestPrice("NAP", "MXP", 2)["price"];
