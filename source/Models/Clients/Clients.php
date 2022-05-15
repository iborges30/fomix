<?php


namespace Source\Models\Clients;


use Source\Core\Model;

class Clients extends Model
{
    public function __construct()
    {
        parent::__construct("clients", ["id"], ["client", "document", "whatsapp"]);
    }



    public function findByDocument(string $document, string $columns = "*"): ?Model
    {
        $find = $this->find("document = :doc", "doc={$document}", $columns);
        return $find->fetch();
    }

}