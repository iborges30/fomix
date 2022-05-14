<?php
header('Content-Type: application/json');
use App\CoastCalculator;
use App\Direction;

require './vendor/autoload.php';

$minCoast = filter_input(INPUT_GET, 'min_coast', FILTER_SANITIZE_STRING);
$coastPerKm = filter_input(INPUT_GET, 'coast_per_km', FILTER_SANITIZE_STRING);
$origin = filter_input(INPUT_GET, 'origin', FILTER_SANITIZE_STRING);
$destination = filter_input(INPUT_GET, 'destination', FILTER_SANITIZE_STRING);
$mode = filter_input(INPUT_GET, 'mode', FILTER_SANITIZE_STRING)??'car';

$direction = new Direction();
$result = $direction->getDirection($origin, $destination, $mode);
$route = $result->routes[0]??null;
if($route)
{
    $km = $route->legs[0]->distance->value/1000;
    $coastCalculator = new CoastCalculator();
    $coast = $coastCalculator->setCoastPerKm($coastPerKm)
    ->setKm($km)
    ->setMinCoast($minCoast)
    ->calculate();
    echo json_encode([
        'coast'=>$coast,
        'distance'=> $route->legs[0]->distance->value/1000,
        'duration'=> $route->legs[0]->duration->value/60
    ]);
}
