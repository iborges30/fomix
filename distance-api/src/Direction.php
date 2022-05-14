<?php

namespace App;

use GuzzleHttp\Client;

class Direction implements DirectionInterface
{
    private $url = 'https://maps.googleapis.com/maps/api/directions/json?origin={origin}&destination={destination}&avoid=highways&mode={mode}&key={key}';
    private $key;
    public function __construct($key = "AIzaSyAJ-n7EAIR-favtWUvCfSf-B9CpNM7NhfI")
    {
        $this->key = $key;
    }

    public function getDirection($origin, $destination, $mode = "car")
    {
        $url = str_replace(['{origin}', '{destination}', '{mode}', '{key}'], [$origin, $destination, $mode, $this->key], $this->url);
        $client = new Client();
        $response = $client->get($url);
        return json_decode($response->getBody()->getContents());
    }
}
