<?php

namespace Source\App\Admin;

use Source\Models\Additional\Additional;
use Source\Models\FlavorProduct\FlavorProduct;
use Source\Models\Flavors\Flavors;
use Source\Models\OpitionProduct\OpitionProduct;
use Source\Models\OptionalItems\OptionalItems;
use Source\Models\Options\Options;
use Source\Models\ProductCategories\ProductCategories;
use Source\Models\Products\Products;
use Source\Support\Pager;
use Source\Support\Thumb;
use Source\Support\Upload;
use WebPConvert\Options\Option;

/**
 * Class Faq
 * @package Source\App\Admin
 */
class ProductController extends Admin
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
 

        $products = (new Products())->has(ProductCategories::class, "category_id")->find("enterprise_id = :en AND category_id = :c ", "en={$enterpriseId}&c={$data['category_id']}");
        $pager = new Pager(url("/admin/products/category/{$data['category_id']}/home/"));
        $pager->pager($products->count(), 20, (!empty($data["page"]) ? $data["page"] : 1));

        $head = $this->seo->render(
            CONF_SITE_NAME . " Meus produtos ",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/products/home", [
            "app" => "products/home",
            "head" => $head,
            "products" => $products->order(" status ASC, name ASC, category_id ASC ")->limit($pager->limit())->offset($pager->offset())->fetch(true),
            "paginator" => $pager->render()
        ]);
    }

    public function showInactive(?array $data): void
    {
        $enterpriseId = user()->enterprise_id;

        $products = (new Products())->has(ProductCategories::class, "category_id")->find("status = :st AND enterprise_id = :en", "st=inactive&en={$enterpriseId}");
        $pager = new Pager(url("/admin/products/inactive/"));
        $pager->pager($products->count(), 20, (!empty($data["page"]) ? $data["page"] : 1));

        $head = $this->seo->render(
            CONF_SITE_NAME . " Meus produtos ",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/products/inactives", [
            "app" => "products/home",
            "head" => $head,
            "products" => $products->order(" status ASC, category_id ASC, name ASC")->limit($pager->limit())->offset($pager->offset())->fetch(true),
            "paginator" => $pager->render()
        ]);
    }

    //CREATE< UPDATE
    public function manager(?array $data): void
    {
        $enterpriseId = user()->enterprise_id;
        $userId = user()->id;
        //POVOA O SELECT DAS CATEGORIAS
        $categories = (new ProductCategories)->find("enterprise_id = :en", "en={$enterpriseId}");

        //create
        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            //IMPEDIR DE CADASTRA VALOR MENOR QUE ZERO PARA OS OPTIONS

            $create = new Products();
            $create->name = $data["name"];
            $create->status = $data["status"];
            $create->description = $data["description"];
            $create->code = $data["code"];
            $create->category_id = $data["category_id"];
            $create->additional = $data["additional"];
            $create->option = $data["option"];
            $create->max_option = $data["max_option"] ?? null;
            $create->max_additional = $data["max_additional"] ?? null;
            $create->flavors = $data["flavors"];
            $create->promotion = $data["promotion"];
            $create->max_flavors = $data["max_flavors"] ?? null;
            $create->price = saveMoney($data["price"]);
            $create->slug = str_slug($data["name"]);
            $create->user_id = $userId;
            $create->enterprise_id = $enterpriseId;
            $create->created = date("Y-m-d H:i:s");


            //upload cover
            if (!empty($_FILES["image"])) {
                $files = $_FILES["image"];
                $upload = new Upload();
                $image = $upload->image($files, $create->slug . time());

                if (!$image) {
                    $json["message"] = $upload->message()->render();
                    echo json_encode($json);
                    return;
                }

                $create->image = $image;
            }

            if (!$create->save()) {
                $json["message"] = $create->message()->render();
                echo json_encode($json);
                return;
            }
            //GERA O CODE CASO N??O SEJA INFORMADO
            if ($create->save() and empty($data['code'])) {
                $code = (new Products())->findById($create->id);
                $code->code = $create->id;
                $code->save();
            }


            $this->message->success("Item cadastrado com sucesso.")->flash();
            echo json_encode(["redirect" => url("/admin/products/manager/{$create->id}")]);
            return;
        }


        // DELETE

        //delete
        if (!empty($data["action"]) && $data["action"] == "delete") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $delete = (new Products())->findById($data["id"]);

            if (!$delete) {
                $this->message->error("Voc?? tentou remover um produto que n??o existe ou j?? foi removido")->flash();
                echo json_encode(["redirect" => url("/admin/products/home")]);
                return;
            }

            if (!$delete->destroy()) {
                $json["message"] = $delete->message()->render();
                echo json_encode($json);
                return;
            }

            if ($delete->image && file_exists(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$delete->image}")) {
                unlink(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$delete->image}");
                (new Thumb())->flush($delete->image);
            }

            $delete->destroy();
            $this->message->success("Produto exclu??do com sucesso...")->flash();
            echo json_encode(["redirect" => url("/admin/products/home")]);
            return;
        }


        //UPDATE
        if (!empty($data["action"]) && $data["action"] == "update") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $productId = filter_var($data["id"], FILTER_VALIDATE_INT);
            $update = (new Products())->find("id = :di AND enterprise_id = :en", "di={$productId}&en={$enterpriseId}")->fetch();

            if (!$update) {
                $this->message->error("Voc?? tentou editar um item que n??o existe no sistema")->flash();
                echo json_encode(["redirect" => url("/admin/products/home")]);
                return;
            }

            $update->name = $data["name"];
            $update->status = $data["status"];
            $update->description = $data["description"];
            $update->code = $data["code"];
            $update->category_id = $data["category_id"];
            $update->additional = $data["additional"];
            $update->option = $data["option"];
            $update->max_option = $data["max_option"] ?? null;
            $update->flavors = $data["flavors"];
            $update->promotion = $data["promotion"];
            $update->max_flavors = $data["max_flavors"] ?? null;
            $update->max_additional = $data["max_additional"] ?? null;
            $update->price = saveMoney($data["price"]);
            $update->slug = str_slug($data["name"]);
            $update->user_id = $userId;
            $update->lastupdate = date("Y-m-d H:i:s");

            //upload cover
            if (!empty($_FILES["image"])) {
                $files = $_FILES["image"];
                $upload = new Upload();
                $image = $upload->image($files, $update->slug . time());

                if (!$image) {
                    $json["message"] = $upload->message()->render();
                    echo json_encode($json);
                    return;
                }
                $update->image = $image;
            }


            if (!$update->save()) {
                $json["message"] = $update->message()->render();
                echo json_encode($json);
                return;
            }


            $json["message"] = $this->message->success("Item atualizado com sucesso...")->render();
            echo json_encode($json);

            return;
        }

        $flavorsActive = null;
        $flavorsDesable = null;
        $update = null;
        $flavors = (new Flavors())->join(FlavorProduct::class, "id", "flavor_id", "LEFT")->find("enterprise_id = :di", "di={$enterpriseId}")->fetch(true);
        $options = (new Options())->join(OpitionProduct::class, "id", "option_id", "LEFT")->find("enterprise_id = :di", "di={$enterpriseId}")->fetch(true);
        if (!empty($data["id"])) {
            $productId = filter_var($data["id"], FILTER_VALIDATE_INT);
            $update = (new Products())->find("id = :di AND enterprise_id = :en", "di={$productId}&en={$enterpriseId}")->fetch();
            $flavorsActive = (new Flavors())->findCustom("SELECT * FROM flavors fv WHERE fv.enterprise_id=15 AND fv.id NOT IN (SELECT fp.flavor_id FROM flavor_product fp WHERE fp.product_id=14)")->fetch(true);
            $flavorsDesable = (new Flavors())->findCustom("SELECT * FROM flavors fv WHERE fv.enterprise_id=15 AND fv.id IN (SELECT fp.flavor_id FROM flavor_product fp WHERE fp.product_id=14)")->fetch(true);
        }
        $head = $this->seo->render(
            CONF_SITE_NAME . " Itens adicionais ",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );
        //var_dump($options);
        echo $this->view->render("widgets/products/manager", [
            "app" => "products/manager",
            "head" => $head,
            "categories" => $categories->fetch(true),
            "flavors" => $flavors,
            "flavorsActive" => $flavorsActive,
            "flavorsDesable" => $flavorsDesable,
            "product" => $update
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
                $this->message->error("Voc?? tentou remover um item que n??o existe ou j?? foi removida do sistema.")->flash();
                echo json_encode(["redirect" => url("/admin/additional/home")]);
                return;
            }

            $delete->destroy();
            $this->message->success("Item exclu??do com sucesso...")->flash();

            echo json_encode(["redirect" => url("/admin/additional/home")]);
            return;
        }
    }

    //INATIVA PRODUTO
    public function inactive(?array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $enterpriseId = user()->enterprise_id;
        $product = (new Products())->find("id = :di AND enterprise_id = :en", "di={$data["id"]}&en={$enterpriseId}")->fetch();
        if ($product) {
            $product->status =  $data["status"] == 'active' ? 'inactive' : 'active';
            $product->save();
            $json["message"] = $this->message->success("Voc?? alterou o status do produto com sucesso.")->flash();
            echo json_encode($json);
            return;
        }
    }



    public function category(?array $data):void{

        $enterpriseId = user()->enterprise_id;
        $categories = (new ProductCategories())->find("enterprise_id = :en", "en={$enterpriseId}");

        $pager = new Pager(url("/admin/products/category/"));
        $pager->pager($categories->count(), 20, (!empty($data["page"]) ? $data["page"] : 1));

        $head = $this->seo->render(
            CONF_SITE_NAME . " Minhas Categorias ",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/products/products-in-category", [
            "app" => "categories/home",
            "head" => $head,
            "categories" => $categories->order("category ASC")->limit($pager->limit())->offset($pager->offset())->fetch(true),
            "paginator" => $pager->render()
        ]);

    }
}
