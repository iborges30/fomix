<?php 

namespace App;

use GuzzleHttp\Client;

class Places {
    private $url = 'https://maps.googleapis.com/maps/api/place/autocomplete/json?input={input} MT&types=geocode&language=pt_BR&key={key}';
    private $key;
    public function __construct($key = "AIzaSyAJ-n7EAIR-favtWUvCfSf-B9CpNM7NhfI")
    {
        $this->key = $key;
    }

    public function getPlaces($input)
    {
        $url = str_replace(['{input}', '{key}'], [$input, $this->key], $this->url);
        $client = new Client();
        $response = $client->get($url);
        return json_decode($response->getBody()->getContents());
    }
}