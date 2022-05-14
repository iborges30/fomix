<?php


namespace Source\Models\ProductCategories;


use Source\Core\Model;


class ProductCategories extends Model
{
    /**
     * Category constructor.
     */
    public function __construct()
    {
        parent::__construct("product_categories", ["id"], ["category"]);
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
            $check = $this->find("slug = :c AND enterprise_id = :en", "c={$this->slug}&en={$this->enterprise_id}")->count();
        } else {
            $check = $this->find("slug = :c AND id != :di AND enterprise_id = :en", "c={$this->slug}&di={$this->id}&en={$this->enterprise_id}")->count();
        }

        if ($check) {
            $this->message->warning("Ooops! esta categoria já foi cadastrado anteriormente")->render();
            return false;
        }

        return true;
    }
}
