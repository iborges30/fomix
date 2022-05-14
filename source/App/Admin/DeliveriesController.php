<?php


namespace Source\App\Admin;


use Source\Models\Auth;
use Source\Models\Deliveries\Deliveries;
use Source\Models\Enterprises\Enterprises;
use Source\Models\Races\Races;
use Source\Support\Pager;
use Source\Support\Thumb;
use Source\Support\Upload;

class DeliveriesController extends Admin
{
    public function __construct()
    {
        parent::__construct();
        if ($this->levelUser()) {
            die();
        }
    }


    public function home(?array $data): void
    {

        $deliveries = (new Deliveries())->find();
        $pager = new Pager(url("/admin/deliveries/home/"));
        $pager->pager($deliveries->count(), 20, (!empty($data["page"]) ? $data["page"] : 1));

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Entregadores",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/deliveries/home", [
            "app" => "deliveries/home",
            "head" => $head,
            "deliveries" => $deliveries->order(" status ASC, first_name ASC")->limit($pager->limit())->offset($pager->offset())->fetch(true),
            "paginator" => $pager->render()
        ]);
    }


    public function show(): void
    {
        $head = $this->seo->render(
            CONF_SITE_NAME . " | Entregadores",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/deliveries/delivery", [
            "app" => "faq/home",
            "head" => $head
        ]);
    }


    public function create(?array $data): void
    {
        if (!empty($data["action"]) && $data["action"] == "create") {

            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $data["document"] = preg_replace("/[^0-9]/", "", $data["document"]);
            $data["phone"] = preg_replace("/[^0-9]/", "", $data["phone"]);
            $data["zipcode"] = preg_replace("/[^0-9]/", "", $data["zipcode"]);

            $create = new Deliveries();
            $create->first_name = $data["first_name"];
            $create->last_name = $data["last_name"];
            $create->zipcode = $data["zipcode"];
            $create->city = $data["city"];
            $create->slug_city = str_slug($data["city"]);
            $create->state = $data["state"];
            $create->genre = $data["genre"];
            $create->datebirth = date_fmt_back($data["datebirth"]);
            $create->document = $data["document"];
            $create->phone = $data["phone"];
            $create->vehicle = $data["vehicle"];

            $create->license = $data["license"];
            $create->type = $data["type"];
            $create->password = passwd($data["password"]);
            $create->status = 'inactive';
            $create->key_pix = $data["key_pix"];
            $create->created = date("Y-m-d H:i:s");


            //upload image
            if (!empty($_FILES["image"])) {
                $files = $_FILES["image"];
                $upload = new Upload();
                $image = $upload->image($files, $create->fullName() . time(), 600);

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

            $this->message->success("Canal cadastrado com sucesso...")->flash();
            echo json_encode(["redirect" => url("/admin/deliveries/update/{$create->id}")]);
            return;
        }

    }


    public function edit($data): void
    {
        $deliveryId = filter_var($data['id'], FILTER_VALIDATE_INT);
        $delivery = (new Deliveries())->findById($deliveryId);
        $head = $this->seo->render(
            CONF_SITE_NAME . " | Entregadores",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/deliveries/delivery", [
            "app" => "faq/home",
            "head" => $head,
            "delivery" => $delivery
        ]);
    }


    public function update(?array $data): void
    {
        if (!empty($data["action"]) && $data["action"] == "update") {

            $deliveryId = filter_var($data['id'], FILTER_VALIDATE_INT);
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $data["document"] = preg_replace("/[^0-9]/", "", $data["document"]);
            $data["phone"] = preg_replace("/[^0-9]/", "", $data["phone"]);
            $data["zipcode"] = preg_replace("/[^0-9]/", "", $data["zipcode"]);

            $update = (new Deliveries())->findById($deliveryId);
            $update->first_name = $data["first_name"];
            $update->last_name = $data["last_name"];
            $update->zipcode = $data["zipcode"];
            $update->city = $data["city"];
            $update->slug_city = str_slug($data["city"]);
            $update->state = $data["state"];
            $update->genre = $data["genre"];
            $update->datebirth = date_fmt_back($data["datebirth"]);
            $update->document = $data["document"];
            $update->phone = $data["phone"];
            $update->vehicle = $data["vehicle"];

            $update->license = $data["license"];
            $update->type = $data["type"];
            $update->password = passwd($data["password"]);
            $update->status = $data["status"];
            $update->key_pix = $data["key_pix"];
            $update->lastupdate = date("Y-m-d H:i:s");


            //upload photo
            if (!empty($_FILES["image"])) {
                if ($update->image && file_exists(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$update->image}")) {
                    unlink(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$update->image}");
                    (new Thumb())->flush($update->image);
                }
                $files = $_FILES["image"];
                $upload = new Upload();
                $image = $upload->image($files, $update->fullName() . time(), 600);
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

            $json["message"] = $this->message->success("Entregador atualizado com sucesso.")->render();
            echo json_encode($json);
            return;
        }

    }


    public function levelUser()
    {
        $user = Auth::user();
        if ($user->level < 5) {
            unset($_SESSION["authUser"]);
            redirect("/admin/login");
        }
    }


    public function wallet(?array $data): void
    {
        $deliveryId = filter_var($data['id'], FILTER_VALIDATE_INT);
        $profile = (new Deliveries())->findById($deliveryId);
        $invoices = (new Races())->inner(Enterprises::class, "enterprise_id")
            ->find("deliveryman_id = :d and status = :st", "d={$deliveryId}&st=finish");
        $head = $this->seo->render(
            CONF_SITE_NAME . " | Repasses",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/deliveries/wallet", [
            "app" => "faq/home",
            "head" => $head,
            "profile" => $profile,
            "invoices" => $invoices->order('created DESC, status ASC')->fetch(true)

        ]);
    }


    public function reportWallet(?array $data): void
    {
        $deliveryId = filter_var($data['id'], FILTER_VALIDATE_INT);
        $profile = (new Deliveries())->findById($deliveryId);
        $invoices = (new Races())->inner(Enterprises::class, "enterprise_id")
            ->find("deliveryman_id = :d", "d={$deliveryId}");
        $head = $this->seo->render(
            CONF_SITE_NAME . " | Histórico de faturas",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/deliveries/report", [
            "app" => "faq/home",
            "head" => $head,
            "profile" => $profile,
            "invoices" => $invoices->order('created DESC, status ASC')->fetch(true)

        ]);
    }



    public function payment(?array $data): void
    {
        $deliveryId = filter_var($data['id'], FILTER_VALIDATE_INT);
        $payment = (new Races())->find("deliveryman_id = :man AND status = :st", "man={$deliveryId}&st=finish")->fetch(true);

        if (!$payment) {
            $json["erros"] = "erro ao atualizar";
            echo json_encode($json);
            return;
        }

        foreach ($payment as $p) {
            $p->status = 'pay';
            $p->save();
        }
        $json["success"] = true;
        echo json_encode($json);
    }
}