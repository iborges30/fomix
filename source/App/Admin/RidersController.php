<?php


namespace Source\App\Admin;


use Source\Models\Clients\Clients;
use Source\Models\Deliveries\Deliveries;
use Source\Models\DeliveriesEnterprise\DeliveriesEnterprise;
use Source\Models\Enterprises\Enterprises;
use Source\Models\Invoices\Invoices;
use Source\Models\Orders\Orders;
use Source\Models\Races\Races;
use Source\Support\Pager;

class RidersController extends Admin
{
    public function __construct()
    {
        parent::__construct();
    }


    public function home(): void
    {
        $enterpriseId = user()->enterprise_id;
        $online = (new Deliveries())->find("status = :s", "s=active")->count();

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Entregas",
            CONF_SITE_DESC,
            url("/admin"),
            false
        );

        echo $this->view->render("widgets/riders/home", [
            "app" => "riders/home",
            "head" => $head,
            "credit" => $this->credit($enterpriseId),
            "count" => $online
        ]);
    }


    public function rider(): void
    {

        $enterpriseId = user()->enterprise_id;

        if ($this->credit($enterpriseId) < 1) {
            $this->message->warning("Você não tem crédito suficiente para gerar uma entrega.")->flash();
            echo redirect(url("/admin/riders/home"));
            return;
        }

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Nova Entrega",
            CONF_SITE_DESC,
            url("/admin"),
            false
        );

        echo $this->view->render("widgets/riders/rider", [
            "app" => "riders/rider",
            "head" => $head
        ]);
    }


    public function modal(): void
    {
        $enterpriseId = user()->enterprise_id;
        $orders = (new Orders())->find("enterprise_id = :ent AND status <= :st", "ent={$enterpriseId}&st=3");

        echo $this->view->render("widgets/riders/modal", [
            "app" => "riders/rider",
            "head" => '',
            "orders" => $orders->order("id ASC")->limit(5)->fetch(true)
        ]);
    }


    public function searchOrder($data): void
    {
        $orderId = filter_var($data['order_id'], FILTER_VALIDATE_INT);
        $order = (new Orders())->findById($orderId, "client_id, delivery_rate");
        $client = (new Clients())->findById($order->client_id);

        if ($client) {
            $json["client"] = true;
            $json["arrival"] = $client->square;
            $json["price"] = str_price($order->delivery_rate);
            echo json_encode($json);
        }
    }


    public function create($data): void
    {

        $enterpriseId = user()->enterprise_id;
        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $commission = (saveMoney($data["race_price"]) * 0.2);
            $racePrice = saveMoney($data["race_price"]) - $commission;

            if ($data["race_price"] < 7) {
                $json["race"]= ("O valor mínimo para esta entrega é de 7,00");
                echo json_encode($json);
                return;
            }

            //VERIFICA SE O SALDO É SUFICIENTE PARA FAZER A OPERAÇÃO
            $checkCredit = $commission + $racePrice;
            if ($this->credit($enterpriseId) < $checkCredit) {
                $this->message->warning("Seu saldo é insulficiente para gerar essa entrega.")->flash();
                echo json_encode(["redirect" => url("/admin/riders/rider")]);
                return;
            }


            $create = new DeliveriesEnterprise();
            $create->enterprise_id = $enterpriseId;
            $create->user_id = user()->id;
            $create->race_origin = $data["race_origin"];
            $create->arrival = $data["arrival"];
            $create->race_price = $racePrice;
            $create->commission = $commission;
            $create->vehicle = $data["vehicle"];
            $create->type_box = $data["type_box"];
            $create->back = $data["back"];
            $create->observations = $data["observations"] ?? null;
            $create->created = date("Y-m-d H:i:s");
            $create->status = "open";

            if (!$create->save()) {
                $json["message"] = $create->message()->render();
                echo json_encode($json);
                return;
            }
            $this->message->success("Entrega criada com sucesso.")->flash();
            echo json_encode(["success" => url("/admin/riders/home")]);
            return;
        }
    }


    public function credit($enterpriseId)
    {
        $credit = (new Invoices())->find("enterprise_id = :ent AND status = :st", "ent={$enterpriseId}&st=credit")->fetch(true);
        $expense = (new DeliveriesEnterprise())->find("enterprise_id = :ent AND status != :st", "ent={$enterpriseId}&st=canceled")->fetch(true);

        $totalCredit = 0;
        $totalExpense = 0;

        if ($credit) {
            foreach ($credit as $c):
                $totalCredit += $c->invoice;
            endforeach;
        }

        if ($expense) {
            foreach ($expense as $e):
                $totalExpense += ($e->race_price + $e->commission);
            endforeach;
        }

        $total = $totalCredit - $totalExpense;
        return $total ?? 0;

    }


    public function acceptDelivery(): void
    {
        $enterpriseId = user()->enterprise_id;

        $riders = (new DeliveriesEnterprise())->findCustom("SELECT
            e.enterprise, 
            d.race_price, 
            d.`status`, 
            d.created,
            d.arrival,
            d.back,
            d.id,
            d.commission,
            
            deliveries.first_name,
            deliveries.last_name,
            deliveries.vehicle,
            deliveries.image,
            deliveries.phone
FROM
	deliveries_enterprise AS d
	INNER JOIN
	enterprises AS e
	ON 
		d.enterprise_id = e.id
	INNER JOIN
	deliveries
	ON 
		d.deliveryman_id = deliveries.id
WHERE
	d.enterprise_id = {$enterpriseId} AND
	d.`status` = 'in_race'");

        echo $this->view->render("widgets/riders/races", [
            "app" => "riders/rider",
            "head" => '',
            "riders" => $riders->order("created ASC")->fetch(true)
        ]);
    }


    public function finish(?array $data): void
    {
        $data = filter_var($data['raceId'], FILTER_VALIDATE_INT);
        $deliveryInRace = (new DeliveriesEnterprise())->findById($data);
        $race = (new Races())->find("delivery_id = :di", "di={$data}")->fetch();

        $deliveryInRace->status = 'finish';
        $deliveryInRace->save();

        $race->status = 'finish';
        $race->save();

        $json["success"] = true;
        echo json_encode($json);
    }


    public function listDeliveries(?array $data): void
    {

        $enterpriseId = user()->enterprise_id;
        $deliveries = (new DeliveriesEnterprise())->find("enterprise_id = :di", "di={$enterpriseId}");
        $pager = new Pager(url("/admin/race/enterprise/list/"));
        $pager->pager($deliveries->count(), 20, (!empty($data["page"]) ? $data["page"] : 1));

        echo $this->view->render("widgets/riders/list", [
            "app" => "riders/rider",
            "head" => '',
            "deliveries" => $deliveries->order("id DESC, created DESC")->limit($pager->limit())->offset($pager->offset())->fetch(true),
            "paginator" => $pager->render()
        ]);

    }


    public function edit(?array $data): void
    {
        $data["id"] = filter_var($data['id'], FILTER_VALIDATE_INT);
        $race = (new DeliveriesEnterprise())->findById($data["id"]);

        if ($race->status != 'open') {
            $this->message->warning("Você não pode editar uma entrega que já foi finalizada.")->flash();
            echo redirect(url("/admin/riders/home"));
            return;
        }

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Nova Entrega",
            CONF_SITE_DESC,
            url("/admin"),
            false
        );

        echo $this->view->render("widgets/riders/rider", [
            "app" => "riders/rider",
            "head" => $head,
            "race" => $race
        ]);
    }


    public function update($data): void
    {
        $enterpriseId = user()->enterprise_id;
        if (!empty($data["action"]) && $data["action"] == "update") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $commission = (saveMoney($data["race_price"]) * 0.2);
            $racePrice = saveMoney($data["race_price"]) - $commission;
            $update = (new DeliveriesEnterprise())->findById($data["id"]);

            //VERIFICA SE O SALDO É SUFICIENTE PARA FAZER A OPERAÇÃO
            $checkCredit = $commission + $racePrice;

            if ($this->credit($enterpriseId) < $checkCredit) {
                $this->message->warning("Seu saldo é insulficiente para gerar essa entrega.")->flash();
                echo json_encode(["redirect" => url("/admin/riders/rider")]);
                return;
            }


            $update->enterprise_id = $enterpriseId;
            $update->user_id = user()->id;
            $update->race_origin = $data["race_origin"];
            $update->arrival = $data["arrival"];
            $update->race_price = $racePrice;
            $update->commission = $commission;
            $update->vehicle = $data["vehicle"];
            $update->type_box = $data["type_box"];
            $update->back = $data["back"];
            $update->observations = $data["observations"] ?? null;
            $update->lastupdate = date("Y-m-d H:i:s");
            $update->status = "open";

            if (!$update->save()) {
                $json["message"] = $update->message()->render();
                echo json_encode($json);
                return;
            }
            $this->message->success("Entrega atualizada com sucesso.")->flash();
            echo json_encode(["redirect" => url("/admin/riders/rider/{$update->id}/" . base64_encode($update->status))]);
            return;
        }
    }


}