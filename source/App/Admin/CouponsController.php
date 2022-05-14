<?php

namespace Source\App\Admin;

use Source\Models\Coupons\Coupons;
use Source\Models\Enterprises\Enterprises;
use Source\Models\EnterprisesCoupons\EnterprisesCoupons;

class CouponsController extends Admin
{
    public function __construct()
    {
        parent::__construct();
    }


    //EXIBE O FORMULÁRIO
    public function home(): void
    {

        $item = (new Coupons())->findById(1);
        $coupons = (new Coupons())->findCustom("SELECT
	enterprises.enterprise, 
	coupons.name, 
	enterprises_coupons.enterprise_id, 
	coupons.id,
	enterprises_coupons.id
FROM
	enterprises_coupons
	INNER JOIN
	coupons
	ON 
		enterprises_coupons.coupon_id = coupons.id
	INNER JOIN
	enterprises
	ON 
		enterprises.id = enterprises_coupons.enterprise_id")->fetch(true);
        $head = $this->seo->render(
            CONF_SITE_NAME . " Meus Cupons ",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/coupons/home", [
            "app" => "coupons/home",
            "head" => $head,
            "coupons" => $coupons,
            "item"=>$item
        ]);
    }

    //EXIBE O FORMULÁRIO
    public function coupons(): void
    {
        $head = $this->seo->render(
            CONF_SITE_NAME . " Meus Sabores ",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/coupons/coupons", [
            "app" => "coupons/coupons",
            "head" => $head

        ]);
    }

    //CRIA O CUPOM
    public function create(?array $data): void
    {

        //CREATE
        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $create = new Coupons;
            $create->name = $data["name"];
            $create->slug = str_slug($data["name"]);
            $create->disconunt = $data["disconunt"];
            $create->minimum = $data["minimum"];
            $create->minimum_price = ($data["minimum_price"]);
            $create->maximum = $data["maximum"];
            $create->maximum_discount = saveMoney($data["maximum_discount"]);
            $create->initial_date = $data["initial_date"];
            $create->end_date = $data["end_date"];
            $create->amount = $data["amount"];
            $create->status = "active";
            $create->user_id = user()->id;
            $create->created = date("Y-m-d H:i:s");

            if (!$create->save()) {
                $json["message"] = $create->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Cupom Cadastrado com sucesso.")->flash();
            echo json_encode(["redirect" => url("/admin/coupons/coupons/{$create->id}")]);
            return;
        }
    }


    //FORMULÁRIO DE EDIÇÃO
    public function show(?array $data): void
    {
        $cupomId = filter_var($data["id"], FILTER_VALIDATE_INT);
        $cupom = (new Coupons)->findById($cupomId);
        $head = $this->seo->render(
            CONF_SITE_NAME . " Meus Sabores ",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/coupons/coupons", [
            "app" => "coupons/coupons",
            "head" => $head,
            "cupom" => $cupom
        ]);
    }


    //ATUALIZA OS CUPOSNS
    public function update(?array $data): void
    {

        //CREATE
        if (!empty($data["action"]) && $data["action"] == "update") {

            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $update = (new Coupons())->findById($data['id']);
            //VERIFICA SE EXISTE
            if (!$update) {
                $this->message->warning("Você tentou um cupom que não existe.")->flash();
                echo json_encode(["redirect" => url("/admin/coupons/home")]);
                return;
            }
            $update->name = $data["name"];
            $update->slug = str_slug($data["name"]);
            $update->disconunt = $data["disconunt"];
            $update->minimum = $data["minimum"];
            $update->minimum_price = saveMoney($data["minimum_price"]);
            $update->maximum = $data["maximum"];
            $update->maximum_discount = saveMoney($data["maximum_discount"]);
            $update->initial_date = date_fmt_back($data["initial_date"]);
            $update->end_date = date_fmt_back($data["end_date"]);
            $update->amount = $data["amount"];
            $update->status = $data["status"];
            $update->user_id = user()->id;
            $update->lastupdate = date("Y-m-d H:i:s");

            if ($update->save()) {
                $json["message"] = $this->message->success("Cupom atualizado com sucesso...")->render();
                echo json_encode($json);
                return;
            }

        }

    }


    //EXIBE O FORMULÁRIO
    public function enterprise(?array $data): void
    {

        $coupon = (new Coupons())->findById($data["id"]);
        $enterprises = (new Enterprises())->find("status = :st", "st=active", "id, city, enterprise");
        $head = $this->seo->render(
            CONF_SITE_NAME . " Relacionamento empresa cupom ",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/coupons/related-enterprises", [
            "app" => "coupons/home",
            "head" => $head,
            "enterprises" => $enterprises->order("city ASC, enterprise ASC")->fetch(true),
            "coupon" => $coupon
        ]);
    }

    public function related(?array $data): void
    {
        if (!empty($data["action"]) && $data["action"] == "create") {
            $create = new EnterprisesCoupons();
            $create->coupon_id = $data["couponId"];
            $create->enterprise_id = $data["enterpriseId"];

            if (!$create->save()) {
                $json["message"] = $create->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Cupom Cadastrado com sucesso.")->flash();
            echo json_encode(["redirect" => url("/admin/coupon/enterprise/{$create->coupon_id}")]);
            return;
        }
    }

    public function deleteRelated(?array $data):void{
        $deleteId = filter_var($data["related_id"], FILTER_VALIDATE_INT);
        $datele = (new EnterprisesCoupons())->findById($deleteId);
        $datele->destroy();
        $this->message->success("Removido o vínculo com sucesso")->flash();

        echo json_encode(["redirect" => url("/admin/coupons/home")]);
        return;
    }
}
