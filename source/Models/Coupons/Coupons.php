<?php


namespace Source\Models\Coupons;


use Source\Core\Model;


class Coupons extends Model
{
    /**
     * Category constructor.
     */
    public function __construct()
    {
        parent::__construct("coupons", ["id"], ["name"]);
    }

    public function save(): bool
    {
        if (
            !$this->checkSlug() or
            !parent::save()
        ) {
            return false;
        }
        return true;
    }



    //EVITA A DUPLICIDADE -- COLOCAR A EMPRESA PARA VERIFICAR
    protected function checkSlug(): bool
    {
        $check = null;

        if (!$this->id) {
            $check = $this->find("slug = :c AND status = :st", "c={$this->slug}&st=active")->count();
        } else {
            $check = $this->find("slug = :c AND id != :di AND status = :st", "c={$this->slug}&di={$this->id}&st=active")->count();
        }

        if ($check) {
            $this->message->warning("Ooops! este cupom já foi cadastrado anteriormente")->render();
            return false;
        }

        return true;
    }
}
