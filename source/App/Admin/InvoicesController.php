<?php


namespace Source\App\Admin;


use Source\Models\Invoices\Invoices;

class InvoicesController extends Admin
{
    public function __construct()
    {
        parent::__construct();
    }

    public function show(?array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        if (user()->level >= 6) {
            $invoices = (new Invoices())->find("enterprise_id = :di", "di={$data["enterprise_id"]}");
            echo $this->view->render("widgets/invoices/home", [
                "app" => "invoices/home",
                "head" => "",
                "invoices"=>$invoices->order(" status DESC, created DESC")->fetch(true)
            ]);
        }
    }


    public function edit(?array $data): void
    {
        if (user()->level >= 6) {
            $invoice = (new Invoices())->findById($data["invoice_id"]);

            if (!empty($data["action"]) && $data["action"] == "update") {
                $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

                $invoice->invoice = $data["invoice"];
                $invoice->status = $data["status"];
                $invoice->lastupdate = date("Y-m-d H:i:s");

                if(!$invoice->save()){
                    $json["message"] = $invoice->message()->render();
                    echo json_encode($json);
                    return;
                }

                $json["message"] = $this->message->success("Fatura atualizada com sucesso")->render();
                echo json_encode($json);
                return;

            }
                $head = $this->seo->render(
                CONF_SITE_NAME . " Faturas ",
                CONF_SITE_DESC,
                url("/admin"),
                url("/admin/assets/images/image.jpg"),
                false
            );
            echo $this->view->render("widgets/invoices/edit", [
                "app" => "invoices/home",
                "head" => $head,
                "invoice"=>$invoice
            ]);
        }
    }


    /*
     * PARTE DA EMPRESA
     */
    public function init(): void
    {
        if (user()->level >= 4) {
            $enterpriseId = user()->enterprise_id;
            $invoices = (new Invoices())->find("enterprise_id = :di", "di={$enterpriseId}");

            echo $this->view->render("widgets/invoices/enterprise_invoice", [
                "app" => "invoices/home",
                "head" => "",
                "invoices"=>$invoices->order(" status DESC, created DESC")->fetch(true)
            ]);
        }
    }


    public function create(?array $data): void
    {
        if (user()->level >= 4) {
            $user = user()->id;
            $enterprise = user()->enterprise_id;

            //CREATE
            if (!empty($data["action"]) && $data["action"] == "create") {
                $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
                $create = new Invoices();


                $create->user_id = $user;
                $create->enterprise_id = $enterprise;
                $create->invoice = $data["invoice"];
                $create->status = "onpay";
                $create->created = date("Y-m-d H:i:s");

                if (!$create->save()) {
                    $json["message"] = $create->message()->render();
                    echo json_encode($json);
                    return;
                }

                $this->message->success("Crédito cadastrado com sucesso.")->flash();
                echo json_encode(["redirect" => url("/admin/enterprise/invoice")]);
                return;

            }

            echo $this->view->render("widgets/invoices/invoices", [
                "app" => "invoices/home",
                "head" => ""
            ]);
        }
    }


}