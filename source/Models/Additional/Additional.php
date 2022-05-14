<?php

namespace Source\Models\Additional;

use Source\Core\Model;

class Additional extends Model
{
    public function __construct()
    {
        parent::__construct("additional", ["id"], ["additional", "category_id", "status"]);
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
            $check = $this->find("slug = :c AND enterprise_id = :en AND category_id = :cat", "c={$this->slug}&en={$this->enterprise_id}&cat={$this->category_id}")->count();
        } else {
            $check = $this->find("slug = :c AND id != :di AND enterprise_id = :en AND category_id = :cat", "c={$this->slug}&di={$this->id}&en={$this->enterprise_id}&cat={$this->category_id}")->count();
        }

        if ($check) {
            $this->message->warning("Ooops! este item já foi cadastrado anteriormente")->render();
            return false;
        }

        return true;
    }
}
