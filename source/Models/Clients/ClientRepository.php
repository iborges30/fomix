<?php

namespace Source\Models\Clients;

class ClientRepository
{

    public function save($data)
    {
        $data["document"] = preg_replace("/[^0-9]/", "", $data["document"]);
        $data["whatsapp"] = preg_replace("/[^0-9]/", "", $data["whatsapp"]);

        $client = (new Clients())->find("document = :doc", "doc={$data["document"]}")->fetch();
        if (!$client) {
            $client = new Clients();
            $client->client = $data["client"];
            $client->address = $data["address"];
            $client->square = $data["square"];
            $client->number = $data["number"];
            $client->complement = $data["complement"];
            $client->reference = $data["point"];
            $client->whatsapp = $data["whatsapp"];
            $client->document = $data["document"];
            $client->state = $data["state"];
            $client->city = $data["city"];
            $client->save();
        } else {
            $client->client = $data["client"];
            $client->address = $data["address"];
            $client->square = $data["square"];
            $client->number = $data["number"];
            $client->complement = $data["complement"];
            $client->reference = $data["point"];
            $client->whatsapp = $data["whatsapp"];
            $client->state = $data["state"];
            $client->city =  $data["city"];
            $client->save();
        }
        return $client;
    }
}
