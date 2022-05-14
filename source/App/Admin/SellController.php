<?php


namespace Source\App\Admin;


use Source\Models\Orders\ItemsOrders;
use Source\Models\Orders\Orders;

class SellController extends Admin
{
    public function __construct()
    {
        parent::__construct();
    }


    public function home(?array $data): void
    {
        if (!empty($data["s"])) {
            $date = $data["s"];
            echo json_encode(["redirect" => url("/admin/sell/home/{$data["s"]}")]);
            return;
        }
        //FALTA FAZER A PESQUISA
        $enterprise_id = user()->enterprise_id;
        $date = ($data["search"] ?? date("Y-m-d"));
        $orders = (new Orders())->find(" enterprise_id = :di AND  date(created) = :d AND status = :s", "di={$enterprise_id}&d={$date}&s=4");

        $items = (new Orders())->findCustom("SELECT orders.id,  orders.created,orders.`status`,  orders_items.order_id,orders_items.id, orders_items.product_id, orders_items.product_amount
        FROM  orders INNER JOIN orders_items ON orders.id = orders_items.order_id  WHERE enterprise_id = :di AND  date(orders.created) = :d  AND orders.status = :st  ", "di={$enterprise_id}&d={$date}&st=4");

        if (!$orders->count() and !empty($data["search"])) {
            $this->message->warning("Sua pesquisa não retornou resultados")->flash();
            redirect("/admin/sell/home");
        }

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Minhas Vendas",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );
        echo $this->view->render("widgets/sell/day", [
            "app" => "sell/day",
            "head" => $head,
            "data" => date("d/m/Y", strtotime($date)),
            "orders" => $orders->fetch(true),
            "items" => $items->fetch(true),
        ]);
    }


    public function sellMonth(?array $data): void
    {
        $data = str_replace("/", "-", $data);
        if (!empty($data["s"])) {
            echo json_encode(["redirect" => url("/admin/sell/month/{$data["s"]}")]);
            return;
        }
        $enterprise_id = user()->enterprise_id;
        $data["search"] = !empty($data["search"]) ? $data["search"]: date('m-Y');
        list($month, $year) = explode("-", $data["search"]);
        $orders = (new Orders())->find(" enterprise_id = :di AND  MONTH(created) = :m AND YEAR(created) = :y AND status = :st", "di={$enterprise_id}&m={$month}&y={$year}&st=4");
        $items = (new Orders())->findCustom("SELECT orders.id,  orders.created,orders.`status`,  orders_items.order_id,orders_items.id, orders_items.product_id, orders_items.product_amount
        FROM  orders INNER JOIN orders_items ON orders.id = orders_items.order_id  WHERE enterprise_id = :di AND  MONTH(orders.created) = :m AND YEAR(orders.created) = :y   AND orders.status = :st  ", "di={$enterprise_id}&m={$month}&y={$year}&st=4");


        $head = $this->seo->render(
            CONF_SITE_NAME . " | Minhas Vendas do mês {$month}",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );
        echo $this->view->render("widgets/sell/month", [
            "app" => "sell/month",
            "head" => $head,
            "data" => $month . '/' . $year,
            "orders" => $orders->fetch(true),
            "items" => $items->fetch(true),
        ]);
    }
}