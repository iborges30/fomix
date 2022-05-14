<?php

namespace Source\App\Admin;


use Source\Models\OptionalItems\OptionalItems;
use Source\Models\Options\Options;
use Source\Models\ProductCategories\ProductCategories;
use Source\Models\Products\Products;
use Source\Support\Pager;

class OptionController extends Admin
{
    public function __construct()
    {
        parent::__construct();
    }


    public function home(?array $data): void
    {
        $enterpriseId = user()->enterprise_id;
        $items = (new Options())->has(ProductCategories::class, "category_id")->find("enterprise_id = :en", "en={$enterpriseId}");


        $pager = new Pager(url("/admin/options/home/"));
        $pager->pager($items->count(), 20, (!empty($data["page"]) ? $data["page"] : 1));

        $head = $this->seo->render(
            CONF_SITE_NAME . " Meus itens opcionais ",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/options/home", [
            "app" => "options/home",
            "head" => $head,
            "items" => $items->order("category_id ASC, status ASC,  item ASC")->limit($pager->limit())->offset($pager->offset())->fetch(true),
            "paginator" => $pager->render()
        ]);
    }


    public function option(?array $data): void
    {
        $enterpriseId = user()->enterprise_id;
        $userId =  user()->id;

        //POVOA O SELECT DAS CATEGORIAS
        $categories = (new ProductCategories)->find("enterprise_id = :en", "en={$enterpriseId}");

        //CREATE
        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $create = new Options();
            $create->item = $data["item"];
            $create->status = $data["status"];
            $create->category_id = $data["category_id"];
            $create->slug = str_slug($data["item"]);
            $create->user_id = $userId;
            $create->enterprise_id =  $enterpriseId;
            $create->created = date("Y-m-d H:i:s");


            if (!$create->save()) {
                $json["message"] = $create->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Item Cadastrado com sucesso.")->flash();
            echo json_encode(["redirect" => url("/admin/options/option/{$create->id}")]);
            return;
        }

        //DELETE  -- FAZER O POLI DO DESTROY
        if (!empty($data["action"]) && $data["action"] == "delete") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $delete = (new Options())->findById($data["id"]);

            if (!$delete) {
                $this->message->error("Você tentou remover um item que não existe ou já foi removida do sistema.")->flash();
                echo json_encode(["redirect" => url("/admin/options/home")]);
                return;
            }

            $delete->destroy();
            $this->message->success("Item excluído com sucesso...")->flash();

            echo json_encode(["redirect" => url("/admin/options/home")]);
            return;
        }

        //UPDATE
        if (!empty($data["action"]) && $data["action"] == "update") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $itemOptionId = filter_var($data["id"], FILTER_VALIDATE_INT);

            $updateItemOptions = (new Options())->find("id = :di AND enterprise_id = :en", "di={$itemOptionId}&en={$enterpriseId}")->fetch();

            if (!$updateItemOptions) {
                $this->message->error("Você tentou editar um item que não existe no sistema")->flash();
                echo json_encode(["redirect" => url("/admin/options/home")]);
                return;
            }

            $updateItemOptions->item = $data["item"];
            $updateItemOptions->category_id = $data["category_id"];
            $updateItemOptions->slug = str_slug($data["item"]);
            $updateItemOptions->status = $data["status"];
            $updateItemOptions->user_id = $userId;
            $updateItemOptions->enterprise_id =  $enterpriseId;
            $updateItemOptions->lastupdate = date("Y-m-d H:i:s");


            if (!$updateItemOptions->save()) {
                $json["message"] = $updateItemOptions->message()->render();
                echo json_encode($json);
                return;
            }

            $json["message"] = $this->message->success("Item atualizado com sucesso...")->render();
            echo json_encode($json);

            return;
        }

        $updateItemOptions = null;
        if (!empty($data["id"])) {
            $itemOptionId = filter_var($data["id"], FILTER_VALIDATE_INT);
            $updateItemOptions = (new Options())->find("id = :di AND enterprise_id = :en", "di={$itemOptionId}&en={$enterpriseId}")->fetch();
        }

        $head = $this->seo->render(
            CONF_SITE_NAME . " Novo Item opcional ",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/options/option", [
            "app" => "options/option",
            "head" => $head,
            "categories" => $categories->order("category ASC")->fetch(true),
            "item" => $updateItemOptions
        ]);
    }



    //CRIA OS ITENS DENTRO DA MODAL E GERA A MODAL
    public  function modal(?array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $categoryId = filter_var($data["id"], FILTER_VALIDATE_INT);
        $enterpriseId = user()->enterprise_id;

        //COM O ID DA CATEGORIA BUSCA-SE OS OPTIONS
        $options = (new Options)->find("category_id = :c AND enterprise_id = :d", "c={$categoryId}&d={$enterpriseId}");

        echo $this->view->render("widgets/categories/modal-options", [
            "options" => $options->order("item ASC")->fetch(true),
            "categoryId" =>  $categoryId
        ]);
    }


    // ABRE A MODAL PARA CADASTRAR O NOVO ITEM
    public function related(?array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $categoryId = filter_var($data["id"], FILTER_VALIDATE_INT);

        if (!empty($categoryId)) {
            $items = (new OptionalItems)->has(Options::class, "item_id")->find("category_id = :p", "p={$categoryId}");
        }

        echo $this->view->render("widgets/categories/item-options", [
            "items" => $items->fetch(true),
            "categoryId" => $categoryId
        ]);
    }




    //CRIA O RELACIONAMENTO ENTRE PRODUTO E OPTION 

    public function relationship(?array $data): void
    {
        $json =  null;
        if (!empty($data["action"]) && $data["action"] == "createItemOptions") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $related = new OptionalItems;

            $related->category_id = $data["category_id"];
            $related->item_id = $data["item_id"];
            $related->enterprise_id = user()->enterprise_id;

            //VERIFICA SE EXISTE ESTE ITEM NA CATEGORIA JÁ
            $itemDuplicate = (new OptionalItems)->find("category_id = :p AND item_id = :di", "p={$data["category_id"]}&di={$data["item_id"]}")->fetch();

            if ($itemDuplicate) {
                $json["duplicate"] = true;
                echo json_encode($json);
                return;
            }

            //CRIA O RELACIONAMENTO
            if ($related->save()) {
                $json["success"] = true;

                //EXIBE OS PRODUTOS PÓS CRIAR O RELACIONAMENTO
                $item = (new OptionalItems)->findCustom("SELECT
                optional_items.item_id, 
                options.item, 
                options.id
            FROM
            optional_items
                INNER JOIN
                options
                ON 
                optional_items.item_id = options.id
            WHERE
            optional_items.item_id = :p LIMIT 1", "p={$related->item_id}")->fetch();

                $json["item_id"] = $related->id;
                $json["item"] = $item->item;
                $json["url"] = url("/admin/options-items/delete/{$related->id}");
            }

            echo json_encode($json);
        }
    }


    //FAZER O DELETE

    public function delete(?array $data): void
    {
        if (!empty($data["action"]) && $data["action"] == "delete") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $deleteId = filter_var($data["id"], FILTER_VALIDATE_INT);
            $deleteItem = (new OptionalItems)->findById($deleteId);

            if (!empty($deleteId)) {

                if (!$deleteItem) {
                    $this->message->error("Você tentou remover um item que não existe ou já foi removida do sistema.")->flash();
                    echo json_encode(["redirect" => url("/admin/options/home")]);
                    return;
                }
                $deleteItem->destroy();
                $json["delete"] = true;
                echo json_encode($json);
                return;
            }
        }
    }


    //INATIVA PRODUTO
    public function inactive(?array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $enterpriseId = user()->enterprise_id;
        $options = (new Options())->find("id = :di AND enterprise_id = :en", "di={$data["id"]}&en={$enterpriseId}")->fetch();
        if ($options) {
            $options->status =  $data["status"] == 'active' ? 'inactive' : 'active';
            $options->save();
            $json["message"] = $this->message->success("Você alterou o status do produto com sucesso.")->flash();
            echo json_encode($json);
            return;
        }
    }
}
