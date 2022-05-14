<?php

namespace Source\App\Admin;

use Source\Models\Additional\Additional;
use Source\Models\AdditionalItems\AdditionalItems;
use Source\Models\ProductCategories\ProductCategories;
use Source\Support\Pager;

/**
 * Class Faq
 * @package Source\App\Admin
 */
class AdditionalController extends Admin
{
    /**
     * Faq constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }



    public function home(?array $data): void
    {
        $enterpriseId = user()->enterprise_id;
        $items = (new Additional())->has(ProductCategories::class, "category_id")->find("enterprise_id = :en", "en={$enterpriseId}");

        $pager = new Pager(url("/admin/additional/home/"));
        $pager->pager($items->count(), 20, (!empty($data["page"]) ? $data["page"] : 1));

        $head = $this->seo->render(
            CONF_SITE_NAME . " Meus itens Adicionais ",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/additional/home", [
            "app" => "additional/home",
            "head" => $head,
            "items" => $items->order(" status ASC, category_id ASC, additional ASC")->limit($pager->limit())->offset($pager->offset())->fetch(true),
            "paginator" => $pager->render()
        ]);
    }

    //CREATE< UPDATE
    public function manager(?array $data): void
    {
        $enterpriseId = user()->enterprise_id;
        $userId =  user()->id;
        //POVOA O SELECT DAS CATEGORIAS
        $categories = (new ProductCategories)->find("enterprise_id = :en", "en={$enterpriseId}");


        //create
        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $create = new Additional();
            $create->additional = $data["additional"];
            $create->max_additional = $data["max_additional"];
            $create->status = $data["status"];
            $create->category_id = $data["category_id"];
            $create->price = saveMoney($data["price"]);
            $create->slug = str_slug($data["additional"]);
            $create->user_id = $userId;
            $create->enterprise_id =  $enterpriseId;
            $create->created = date("Y-m-d H:i:s");


            if (!$create->save()) {
                $json["message"] = $create->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Item cadastrado com sucesso.")->flash();
            echo json_encode(["redirect" => url("/admin/additional/manager/{$create->id}")]);
            return;
        }


        //UPDATE
        if (!empty($data["action"]) && $data["action"] == "update") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $additionalId = filter_var($data["id"], FILTER_VALIDATE_INT);

            $updateAdditional = (new Additional())->find("id = :di AND enterprise_id = :en", "di={$additionalId}&en={$enterpriseId}")->fetch();

            if (!$updateAdditional) {
                $this->message->error("Você tentou editar um item que não existe no sistema")->flash();
                echo json_encode(["redirect" => url("/admin/options/home")]);
                return;
            }

            $updateAdditional->additional = $data["additional"];
            $updateAdditional->max_additional = $data["max_additional"];
            $updateAdditional->status = $data["status"];
            $updateAdditional->category_id = $data["category_id"];
            $updateAdditional->price = saveMoney($data["price"]);
            $updateAdditional->slug = str_slug($data["additional"]);
            $updateAdditional->user_id = $userId;
            $updateAdditional->enterprise_id =  $enterpriseId;
            $updateAdditional->lastupdate = date("Y-m-d H:i:s");


            if (!$updateAdditional->save()) {
                $json["message"] = $updateAdditional->message()->render();
                echo json_encode($json);
                return;
            }

            $json["message"] = $this->message->success("Item atualizado com sucesso...")->render();
            echo json_encode($json);

            return;
        }


        $updateAdditional = null;
        if (!empty($data["id"])) {
            $additionalId = filter_var($data["id"], FILTER_VALIDATE_INT);
            $updateAdditional = (new Additional())->find("id = :di AND enterprise_id = :en", "di={$additionalId}&en={$enterpriseId}")->fetch();
        }


        $head = $this->seo->render(
            CONF_SITE_NAME . " Itens adicionais ",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/additional/manager", [
            "app" => "additional/manager",
            "head" => $head,
            "categories" => $categories->fetch(true),
            "additional" => $updateAdditional
        ]);
    }


    //DELETA ITEM
    public function delete(?array $data): void
    {

        //DELETE  -- FAZER O POLI DO DESTROY
        if (!empty($data["action"]) && $data["action"] == "delete") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $delete = (new Additional())->findById($data["id"]);

            if (!$delete) {
                $this->message->error("Você tentou remover um item que não existe ou já foi removida do sistema.")->flash();
                echo json_encode(["redirect" => url("/admin/additional/home")]);
                return;
            }

            $delete->destroy();
            $this->message->success("Item excluído com sucesso...")->flash();

            echo json_encode(["redirect" => url("/admin/additional/home")]);
            return;
        }
    }

    // TRAZ OS ITEMS PARA MONTAR A TABELA
    public function related(?array $data): void
    {

        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $categoryId = filter_var($data["id"], FILTER_VALIDATE_INT);

        if (!empty($categoryId)) {
            $items = (new AdditionalItems)->has(Additional::class, "additional_id")->find("category_id = :p", "p={$categoryId}");
        }

        echo $this->view->render("widgets/categories/item-additional", [
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
        $additionals = (new Additional)->find("category_id = :c AND enterprise_id = :d", "c={$categoryId}&d={$enterpriseId}");


        echo $this->view->render("widgets/categories/modal-additional", [
            "additionals" => $additionals->order("additional ASC")->fetch(true),
            "categoryId" =>  $categoryId
        ]);
    }



    //CADASTRA OS SABORES DA MODAL CRIANDO O RELACIONAMENTO

    public function relationship(?array $data): void
    {

        $json =  null;
        if (!empty($data["action"]) && $data["action"] == "relationship") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $related = new AdditionalItems;

            $related->category_id = $data["category_id"];
            $related->additional_id = $data["additional_id"];
            $related->enterprise_id = user()->enterprise_id;

            //VERIFICA SE EXISTE ESTE ITEM NA CATEGORIA JÁ
            $itemDuplicate = (new AdditionalItems)->find("category_id = :p AND additional_id = :di", "p={$data["category_id"]}&di={$data["additional_id"]}")->fetch();


            if (!empty($itemDuplicate)) {
                $json["duplicate"] = true;
                echo json_encode($json);
                return;
            }

            //CRIA O RELACIONAMENTO
            if ($related->save()) {
                $json["success"] = true;

                //EXIBE OS PRODUTOS PÓS CRIAR O RELACIONAMENTO
                $items = (new AdditionalItems)->findCustom("SELECT
                   additional_items.additional_id, 
                   additional.additional, 
                   additional.id,
                   additional.price
               FROM
               additional_items
                   INNER JOIN
                   additional
                   ON 
                   additional_items.additional_id = additional.id
               WHERE
               additional_items.additional_id = :p LIMIT 1", "p={$related->additional_id}")->fetch();


                $json["additional_id"] = $related->id;
                $json["additional"] = $items->additional;
                $json["price"] = str_price($items->price);
                $json["url"] = url("/admin/additional-items/delete/{$related->id}");
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
            $deleteItem = (new AdditionalItems)->findById($deleteId);

            if (!empty($deleteId)) {

                if (!$deleteItem) {
                    $this->message->error("Você tentou remover um item que não existe ou já foi removida do sistema.")->flash();
                    echo json_encode(["redirect" => url("/admin/categories/home")]);
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
