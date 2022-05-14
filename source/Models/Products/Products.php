<?php

namespace Source\Models\Products;

use Source\Core\Model;
use Source\Models\Enterprises\Enterprises;
use Source\Models\Orders\Orders;
use Source\Models\OrdersItems\OrdersItems;
use Source\Models\ProductCategories\ProductCategories;

class Products extends Model
{
    public function __construct()
    {
        parent::__construct("products", ["id"], ["name", "category_id", "status", "price", "option", "additional", "flavors"]);
    }


    public function save(): bool
    {
        if (!$this->checkSlug() or !parent::save()) {
            return false;
        }
        return true;
    }

    public function destroy(): bool
    {
        if (!$this->checkProductDestroy() or !parent::destroy()) {
            return false;
        }
        return true;
    }

    /*
    *** VERIFICA SE EXISTE UM PRODUTO COM PEDIDO JÁ
        CASO EXISTA ELE IMPEDE DE SER DELETADO
    ***
    */
    public function checkProductDestroy(): bool
    {
        $orders = (new OrdersItems)->find("product_id = :di", "di={$this->id}")->fetch();

        if ($orders) {
            $this->message->warning("Ooops! Você não pode deletar um produto que tem um pedido já registrado no sistema. Use a opção inativar para remove-lo do aplicativo.")->render();
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
            $this->message->warning("Ooops! este item já foi cadastrado anteriormente")->render();
            return false;
        }

        return true;
    }


    //RETORNA CATEGORIAS QUE TEM PRODUTOS DENTRO
    public function categories(string $slug)
    {
        $categories = $this->findCustom("SELECT * FROM product_categories AS cat WHERE enterprise_id = :slug AND id IN ((	SELECT category_id	FROM products as p	WHERE cat.id = p.category_id))", "slug={$slug}");
        if ($categories) {
            return $categories;
        }

    }


    //Retorna todos os produtos ativos
    public function all($enterpriseId)
    {
        $all = $this->findCustom("SELECT products.* FROM	products INNER JOIN	product_categories	ON 	products.category_id = product_categories.id WHERE	products.enterprise_id = :p 
        AND products.status = :st ", "st=active&p={$enterpriseId}");

        if ($all) {
            return $all;
        }
    }
}
