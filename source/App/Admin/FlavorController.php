<?php

namespace Source\App\Admin;

use Source\Models\FlavorItems\FlavorItems;
use Source\Models\Flavors\Flavors;
use Source\Models\ProductCategories\ProductCategories;
use Source\Support\Pager;

class FlavorController extends Admin
{
    public function __construct()
    {
        parent::__construct();
    }


    //LISTA OS SABORES
    public function home(?array $data): void
    {
        $enterpriseId = user()->enterprise_id;
        $items = (new Flavors())->has(ProductCategories::class, "category_id")->find("enterprise_id = :en", "en={$enterpriseId}");


        $pager = new Pager(url("/admin/flavors/home/"));
        $pager->pager($items->count(), 20, (!empty($data["page"]) ? $data["page"] : 1));

        $head = $this->seo->render(
            CONF_SITE_NAME . " Meus Sabores ",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/flavors/home", [
            "app" => "flavors/home",
            "head" => $head,
            "items" => $items->order("category_id ASC, flavor ASC")->limit($pager->limit())->offset($pager->offset())->fetch(true),
            "paginator" => $pager->render()
        ]);
    }

    //GERENCIA O CADASTRO
    public function manager(?array $data): void
    {
        //Retorna as categorias
        $enterpriseId = user()->enterprise_id;
        $userId =  user()->id;
        $categories = (new ProductCategories)->find("enterprise_id = :p", "p={$enterpriseId}")->fetch(true);

        //CREATE
        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $create = new Flavors();

            $create->flavor = $data["flavor"];
            $create->slug = str_slug($data['flavor']);
            $create->category_id = $data["category_id"];
            $create->status = $data["status"];
            $create->description = $data["description"];
            $create->enterprise_id = $enterpriseId;
            $create->user_id = $userId;
            $create->created = date("Y-m-d H:i:s");



            if (!$create->save()) {
                $json["message"] = $create->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Sabor Cadastrado com sucesso.")->flash();
            echo json_encode(["redirect" => url("/admin/flavors/manager/{$create->id}")]);
            return;
        }


        //ATUALIZA FLAVOR
        if (!empty($data["action"]) && $data["action"] == "update") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $flavorId = filter_var($data["id"], FILTER_VALIDATE_INT);

            $updateFlavor = (new Flavors())->find("id = :di AND enterprise_id = :en", "di={$flavorId}&en={$enterpriseId}")->fetch();

            if (!$updateFlavor) {
                $this->message->error("Você tentou editar um item que não existe no sistema")->flash();
                echo json_encode(["redirect" => url("/admin/flavors/home")]);
                return;
            }

            $updateFlavor->flavor = $data["flavor"];
            $updateFlavor->slug = str_slug($data['flavor']);
            $updateFlavor->category_id = $data["category_id"];
            $updateFlavor->status = $data["status"];
            $updateFlavor->description = $data["description"];
            $updateFlavor->enterprise_id = $enterpriseId;
            $updateFlavor->user_id = $userId;


            if (!$updateFlavor->save()) {
                $json["message"] = $updateFlavor->message()->render();
                echo json_encode($json);
                return;
            }

            $json["message"] = $this->message->success("Item atualizado com sucesso...")->render();
            echo json_encode($json);
            return;
        }


        //UPDATE
        $updateFlavor = null;
        if (!empty($data["id"])) {
            $flavorId = filter_var($data["id"], FILTER_VALIDATE_INT);
            $updateFlavor = (new Flavors())->find("id = :di AND enterprise_id = :en", "di={$flavorId}&en={$enterpriseId}")->fetch();
        }


        $head = $this->seo->render(
            CONF_SITE_NAME . " Novo Sabor ",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/flavors/manager", [
            "app" => "flavors/home",
            "head" => $head,
            "categories" => $categories,
            "flavor" => $updateFlavor
        ]);
    }


    public function delete(?array $data): void
    {
        //DELETE  -- FAZER O POLI DO DESTROY
        if (!empty($data["action"]) && $data["action"] == "delete") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $delete = (new Flavors())->findById($data["id"]);

            if (!$delete) {
                $this->message->error("Você tentou remover um item que não existe ou já foi removida do sistema.")->flash();
                echo json_encode(["redirect" => url("/admin/options/home")]);
                return;
            }

            $delete->destroy();
            $this->message->success("Item excluído com sucesso...")->flash();

            echo json_encode(["redirect" => url("/admin/flavors/home")]);
            return;
        }
    }

    // TRAZ OS ITEMS PARA MONTAR A TABELA
    public function related(?array $data): void
    {

        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $categoryId = filter_var($data["id"], FILTER_VALIDATE_INT);

        if (!empty($categoryId)) {
            $items = (new FlavorItems)->has(Flavors::class, "flavor_id")->find("category_id = :p", "p={$categoryId}");
        }

        echo $this->view->render("widgets/categories/item-flavors", [
            "items" => $items->fetch(true),
            "categoryId" => $categoryId
        ]);
    }


    //CRIA OS ITENS DENTRO DA MODAL E GERA A MODAL
    public  function modal(?array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $categoryId = filter_var($data["id"], FILTER_VALIDATE_INT);
        $enterpriseId = user()->enterprise_id;

        //COM O ID DA CATEGORIA BUSCA-SE OS OPTIONS
        $options = (new Flavors)->find("category_id = :c AND enterprise_id = :d", "c={$categoryId}&d={$enterpriseId}");

        echo $this->view->render("widgets/categories/modal-flavors", [
            "flavors" => $options->order("flavor ASC")->fetch(true),
            "categoryId" =>  $categoryId
        ]);
    }


    //CADASTRA OS SABORES DA MODAL CRIANDO O RELACIONAMENTO

    public function relationship(?array $data): void
    {

        $json =  null;
        if (!empty($data["action"]) && $data["action"] == "relationship") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $related = new FlavorItems;

            $related->category_id = $data["category_id"];
            $related->flavor_id = $data["flavor_id"];
            $related->enterprise_id = user()->enterprise_id;

            //VERIFICA SE EXISTE ESTE ITEM NA CATEGORIA JÁ
            $itemDuplicate = (new FlavorItems)->find("category_id = :p AND flavor_id = :di", "p={$data["category_id"]}&di={$data["flavor_id"]}")->fetch();

            if ($itemDuplicate) {
                $json["duplicate"] = true;
                echo json_encode($json);
                return;
            }

            //CRIA O RELACIONAMENTO
            if ($related->save()) {
                $json["success"] = true;

                //EXIBE OS PRODUTOS PÓS CRIAR O RELACIONAMENTO
                $items = (new FlavorItems)->findCustom("SELECT
                   flavor_items.flavor_id, 
                   flavors.flavor, 
                   flavors.id
               FROM
               flavor_items
                   INNER JOIN
                   flavors
                   ON 
                   flavor_items.flavor_id = flavors.id
               WHERE
               flavor_items.flavor_id = :p LIMIT 1", "p={$related->flavor_id}")->fetch();
          

                $json["flavor_id"] = $related->id;
                $json["flavor"] = $items->flavor;
                $json["url"] = url("/admin/flavors-items/delete/{$related->id}");
            }

            echo json_encode($json);
        }
    }

     //FAZER O DELETE

     public function deleteItems(?array $data): void
     {
         if (!empty($data["action"]) && $data["action"] == "delete") {
             $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
             $deleteId = filter_var($data["id"], FILTER_VALIDATE_INT);
             $deleteItem = (new FlavorItems)->findById($deleteId);
 
             if (!empty($deleteId)) {
 
                 if (!$deleteItem) {
                     $this->message->error("Você tentou remover um item que não existe ou já foi removida do sistema.")->flash();
                     echo json_encode(["redirect" => url("/admin/flavors/home")]);
                     return;
                 }
                 $deleteItem->destroy();
                 $json["delete"] = true;
                 echo json_encode($json);
                 return;
             }
         }
     }
}
