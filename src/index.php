<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Model\Flight;
use App\Model\Airport;
use App\Repository\AirportRepository;
use App\Repository\FlightRepository;
use App\Solution\BestPrice;

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
$airportTable->setData(array_map("csvToAirport", file(__DIR__ . "/../data/airports.csv")));

/* Set Flights Repository */
$flightTable = new FlightRepository();
$flightTable->setData(array_map("csvToFlight", file(__DIR__ . "/../data/flights.csv")));


$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    case "/airport":
        http_response_code(200);
        echo json_encode($airportTable->all());
        break;
    case "/flight":
        http_response_code(200);
        echo json_encode($flightTable->all());
        break;
    case "/getBestPrice":
        $input = json_decode(file_get_contents('php://input'));
        $code_departure = $input->code_departure;
        $code_arrival = $input->code_arrival;
        $max_stop = (int) $input->max_stop;

        $solution = new BestPrice($airportTable, $flightTable);
        $bestPrice = $solution->getBestPrice($code_departure, $code_arrival, $max_stop);

        if ($bestPrice["stops"] > 0) {
            http_response_code(200);
            echo json_encode($bestPrice);
            break;
        }
        http_response_code(404);
        echo json_encode([
            "error" => "No flight from $code_departure To $code_arrival"
        ]);
        break;
    default:
        require __DIR__ . '/views/index.html';
        break;
}

/* Instance of Solution for find best price */
//
//echo 
