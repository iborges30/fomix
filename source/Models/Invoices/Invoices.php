<?php


namespace Source\Models\Invoices;


use Source\Core\Model;

class Invoices extends Model
{
    public function __construct()
    {
        parent::__construct("invoices", ["id"], ["invoice"]);
    }


    public function save(): bool
    {
        if (!$this->invoiceValue() or !parent::save()) {
            return false;
        }
        return true;
    }


    protected function invoiceValue(): bool
    {
        if ($this->invoice <= 49) {
            $this->message->warning("O valor informado não pode ser menor que 50 reais.");
            return false;
        }
        return true;
    }
}

