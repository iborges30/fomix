<?php


namespace Source\Models\Deliveries;


use Source\Core\Model;

class Deliveries extends Model
{
    public function __construct()
    {
        parent::__construct("deliveries", ["id"], ["first_name",
            "last_name",
            "datebirth",
            "zipcode",
            "document",
            "phone",
            "vehicle",
            "type"
        ]);
    }


    /**
     * @return string
     */
    public function fullName(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * @return bool
     */
    public function save(): bool
    {
        if (!$this->validateDocument() or
            !$this->checkDuplicateDocument() or
            !$this->checkDuplicatePhone() or
            !parent::save()) {
            return false;
        }

        return true;
    }


    public function findByDocument(string $document, string $columns = "*"): ?Deliveries
    {
        $find = $this->find("document = :doc", "doc={$document}", $columns);
        return $find->fetch();
    }

    //VERIFICA VALIDADE DOCUMENTO
    public function validateDocument(): bool
    {
        //VERIFICA DOCUMENTO USUÁRIO
        if (!validadeDocumentClient($this->document)) {
            $this->message->warning("O CPF informado não é válido");
            return false;
        }
        return true;
    }


    //VERIFICA A DUPLICAÇÃO DO DOCUMENTO
    public function checkDuplicateDocument(): bool
    {
        $check = null;
        if (!$this->id) {
            $check = $this->find("document = :c", "c={$this->document}")->count();
        } else {
            $check = $this->find("document = :c AND id != :di ", "c={$this->document}&di={$this->id}")->count();
        }

        if ($check) {
            $this->message->warning("Ooops! Este CPF foi cadastrado anteriormente.")->render();
            return false;
        }
        return true;
    }

    //VERIFICA A DUPLICAÇÃO DO DOCUMENTO
    public function checkDuplicatePhone(): bool
    {
        $check = null;
        if (!$this->id) {
            $check = $this->find("phone = :c", "c={$this->phone}")->count();
        } else {
            $check = $this->find("phone = :c AND id != :di ", "c={$this->phone}&di={$this->id}")->count();
        }

        if ($check) {
            $this->message->warning("Ooops! Este Celular já foi cadastrado anteriormente.")->render();
            return false;
        }
        return true;
    }

}