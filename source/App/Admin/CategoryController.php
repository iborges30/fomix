<?php

namespace Source\App\Admin;

use Source\Models\ProductCategories\ProductCategories;
use Source\Support\Pager;

/**
 * Class Faq
 * @package Source\App\Admin
 */
class CategoryController extends Admin
{
    /**
     * Faq constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param array|null $data
     */
    public function home(?array $data): void
    {
        $enterpriseId = user()->enterprise_id;
        $categories = (new ProductCategories())->find("enterprise_id = :en", "en={$enterpriseId}");

        $pager = new Pager(url("/admin/categories/home/"));
        $pager->pager($categories->count(), 20, (!empty($data["page"]) ? $data["page"] : 1));

        $head = $this->seo->render(
            CONF_SITE_NAME . " Minhas Categorias ",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/categories/home", [
            "app" => "categories/home",
            "head" => $head,
            "categories" => $categories->order("category")->limit($pager->limit())->offset($pager->offset())->fetch(true),
            "paginator" => $pager->render()
        ]);
    }

    /**
     * @param array|null $data
     */
    public function category(?array $data): void
    {
        $enterpriseId = user()->enterprise_id;
        $userId =  user()->id;

        //create
        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $create = new ProductCategories();
            $create->category = $data["category"];
            $create->position = $data["position"];
            $create->slug = str_slug($data["category"]);
            $create->user_id = $userId;
            $create->enterprise_id =  $enterpriseId;
            $create->created = date("Y-m-d H:i:s");


            if (!$create->save()) {
                $json["message"] = $create->message()->render();
                echo json_encode($json);
                return;
            }

            //GERA O CODE CASO NÃO SEJA INFORMADO
            if ($create->save() and empty($data['position'])) {
                $position = (new ProductCategories())->findById($create->id);
                $position->position = $create->id;
                $position->save();
            }



            $this->message->success("Categoria Cadastrada com sucesso.")->flash();
            echo json_encode(["redirect" => url("/admin/categories/category/{$create->id}")]);
            return;
        }


        // DELETE
        // VERIFICAR A VALIDAÇÃO POSTERIORMENTE

        if (!empty($data["action"]) && $data["action"] == "delete") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $delete = (new ProductCategories())->findById($data["id"]);

            if (!$delete) {
                $this->message->error("Você tentou remover uma categoria que não existe ou já foi removida do sistema.")->flash();
                echo json_encode(["redirect" => url("/admin/categories/home")]);
                return;
            }

            $delete->destroy();
            $this->message->success("Categoria excluído com sucesso...")->flash();

            echo json_encode(["redirect" => url("/admin/categories/home")]);
            return;
        }

        //update

        if (!empty($data["action"]) && $data["action"] == "update") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $categoryId = filter_var($data["id"], FILTER_VALIDATE_INT);

            $updateCategory = (new ProductCategories())->find("id = :di AND enterprise_id = :en", "di={$categoryId}&en={$enterpriseId}")->fetch();

            if (!$updateCategory) {
                $this->message->error("Você tentou editar uma categoria que não existe no sistema")->flash();
                echo json_encode(["redirect" => url("/admin/categories/home")]);
                return;
            }

            $updateCategory->category = $data["category"];
            $updateCategory->position = $data["position"];
            $updateCategory->slug = str_slug($data["category"]);
            $updateCategory->user_id = $userId;
            $updateCategory->lastupdate = date("Y-m-d H:i:s");

            if (!$updateCategory->save()) {
                $json["message"] = $updateCategory->message()->render();
                echo json_encode($json);
                return;
            }

            //GERA O CODE CASO NÃO SEJA INFORMADO
            if ($updateCategory->save() and empty($data['position'])) {
                $position = (new ProductCategories())->findById($categoryId);
                $position->position = $updateCategory->id;
                $position->save();
            }

            $json["message"] = $this->message->success("Categoria atualizada com sucesso...")->render();
            echo json_encode($json);

            return;
        }


        $updateCategory = null;
        if (!empty($data["id"])) {
            $categoryId = filter_var($data["id"], FILTER_VALIDATE_INT);
            $updateCategory = (new ProductCategories())->find("id = :di AND enterprise_id = :en", "di={$categoryId}&en={$enterpriseId}")->fetch();
        }


        $head = $this->seo->render(
            CONF_SITE_NAME . " Gerenciar categorias ",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/categories/category", [
            "app" => "categories/home",
            "head" => $head,
            "category" => $updateCategory
        ]);
    }

    //CRIA A CATEGORIA NO FORM DO PRODUTO

    public function createInModalProduct(?array $data): void
    {
        $category = new ProductCategories();
        $category->category = $data["category"];
        $category->slug = str_slug($data["category"]);
        $category->user_id = user()->id;
        $category->enterprise_id = user()->enterprise_id;
        $category->created = date("Y-m-d H:i:s");


        if (!$category->save()) {
            $json['message'] = 'error';
        } else {
            $json['name'] = $data["category"];
            $json['value'] = $category->id;
        }

        //GERA O CODE CASO NÃO SEJA INFORMADO
        if ($category->save()) {
            $position = (new ProductCategories())->findById($category->id);
            $position->position = $category->id;
            $position->save();
        }
        echo json_encode($json);
    }
}
