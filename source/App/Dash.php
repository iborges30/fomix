<?php

namespace Source\App\Admin;

use Source\Models\Additional\Additional;
use Source\Models\Auth;
use Source\Models\CafeApp\AppPlan;
use Source\Models\CafeApp\AppSubscription;
use Source\Models\CartItems\CartItems;
use Source\Models\Category;
use Source\Models\Clients\Clients;
use Source\Models\Enterprises\Enterprises;
use Source\Models\Flavors\Flavors;
use Source\Models\OptionalItems\OptionalItems;
use Source\Models\Options\Options;
use Source\Models\Orders\ItemsOrders;
use Source\Models\Orders\Orders;
use Source\Models\OrdersItems\OrdersItems;
use Source\Models\Post;
use Source\Models\Products\Products;
use Source\Models\Report\Online;
use Source\Models\User;
use Source\Support\Pager;
use WebPConvert\Options\Options as OptionsOptions;

/**
 * Class Dash
 * @package Source\App\Admin
 */
class Dash extends Admin
{
    /**
     * Dash constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     *
     */
    public function dash(): void
    {

        if(user()->level >= 5){
            redirect("/admin/enterprise/home");

        }else{
            redirect("/admin/dash/home");
        }


    }


    /*** LISTA OS PEDIDOS **/

    public function list(?array $data): void
    {
        $enterprise_id = user()->enterprise_id;
        $orders = (new Orders())->findCustom("SELECT
        u.id, u.enterprise_id, 
        u.total_orders,
        u.payment,
        u.status,
        u.note,
        e.client,
        e.whatsapp FROM
        orders u, clients e WHERE 
        u.client_id = e.id  
       AND (u.status != 4 AND u.status !=5) AND u.enterprise_id = $enterprise_id
        "
        );

        $totalOrdes = $orders->count();

        $confirmed = (new Orders())->find("status = :st AND enterprise_id = :en", "st=1&en={$enterprise_id}")->count();
        $kitchen = (new Orders())->find("status = :st AND enterprise_id = :en", "st=2&en={$enterprise_id}")->count();
        $send = (new Orders())->find("status = :st AND enterprise_id = :en", "st=3&en={$enterprise_id}")->count();
        $inSotre = (new Orders())->find("status = :st AND enterprise_id = :en", "st=6&en={$enterprise_id}")->count();

        $confirmed > 0 ? $percentConfirmed = ($confirmed / $totalOrdes) * 100 : null;
        $kitchen > 0 ? $percentKitchen = ($kitchen / $totalOrdes) * 100 : null;
        $send > 0 ? $percentSend = ($send / $totalOrdes) * 100 : null;
        $inSotre > 0 ? $percentInSotre = ($inSotre / $totalOrdes) * 100 : null;


        $pager = new Pager(url("/admin/dash/home/"));
        $pager->pager($orders->count(), 25, (!empty($data["page"]) ? $data["page"] : 1));

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Pedidos",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/dash/home", [
            "app" => "dash/home",
            "head" => $head,
            "confirmed" => $confirmed,
            "kitchen" => $kitchen,
            "send" => $send,
            "inSotre" => $inSotre,
            "user" => user()->level,
            "percentConfirmed" => $percentConfirmed ?? null,
            "percentKitchen" => $percentKitchen ?? null,
            "percentSend" => $percentSend ?? null,
            "percentInStore" => $percentInSotre ?? null,
            "orders" => $orders->limit($pager->limit())->offset($pager->offset())->order(" u.status ASC, u.id DESC")->fetch(true),
            "paginator" => $pager->render(),
            "UserEnterpriseId"=>user()->enterprise_id ?? null
        ]);
    }


    /*
    * IMPRIMIR PEDIDO
    */
    public function print(?array $data): void
    {
        $orderId = filter_var($data["id"], FILTER_VALIDATE_INT);
        $enterprise_id = user()->enterprise_id;
        //DADOS DO PEDIDO
        $dataUser = user();
        $enterprise = (new Enterprises())->findById($enterprise_id);
        $orders = (new Orders())->find("id = :di", "di={$orderId}")->fetch();
        $items = (new OrdersItems())->has(Products::class, "product_id")->find("order_id = :p", "p={$orderId}")->fetch(true);
        $client = (new Clients())->find("id = :di", "di={$orders->client_id}")->fetch();
        $itensOrderAdittionais = (new CartItems())->inner(Additional::class, "product_id")->find("order_id = :p AND category_items = :ad", "p={$orderId}&ad=A")->fetch(true);
        $itensOrderFlavors = (new CartItems())->inner(Flavors::class, "product_id")->find("order_id = :p AND category_items = :ad", "p={$orderId}&ad=S")->fetch(true);
        $itensOrderOptionalItems = (new CartItems())->inner(Options::class, "product_id")->find("order_id = :p AND category_items = :ad", "p={$orderId}&ad=O")->fetch(true);

        //SE NÃO EXISTIR O PEDIDO
        if (!$orders) {
            $json["message"] = $this->message->warning("você está tentando imprimir um pedido que não existe.")->flash();
            redirect(url("/admin/dash/home"));
            echo json_encode($json);
            return;
        }


        $head = $this->seo->render(
            CONF_SITE_NAME . " | Imprimir pedido",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/dash/orders-print", [
            "app" => "dash/orders-print",
            "head" => $head,
            "user" => $dataUser,
            "orders" => $orders,
            "client" => $client,
            "items" => $items,
            "additionals" => $itensOrderAdittionais,
            "flavors" => $itensOrderFlavors,
            "optional" => $itensOrderOptionalItems,
            "enterprise" => $enterprise
        ]);
    }


    /*
 * ALTERA O STATUS DO PEDIDO
 */
    public function changeStatus(?array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        if (!empty($data)) {
            $orderUpdate = (new Orders())->findById($data["order"]);
            $orderUpdate->status = $data["status"];
            $orderUpdate->created_by = user()->id;
            $orderUpdate->lastupdate = date("Y-m-d H:i:s");

            if (!$orderUpdate->save()) {
                $this->message->info("Erro ao atualizar status do pedido.")->render();
                $json["error"] = 'error';
                echo json_encode($json);
                return;
            }
            $orderUpdate->save();
            $json["success"] = 'success';
            $json["status"] = setStatusOrders($data["status"]);
            echo json_encode($json);
            return;
        }
    }




    public function alert(): void
    {
        $enterpriseId = user()->enterprise_id;
        $alertApp = (new Orders())->find("enterprise_id = :en AND status = :st AND notification = :a", "en={$enterpriseId}&st=1&a=open");
        if ($alertApp->count() >= 1) {
            $json['alert'] = true;
            $json['count'] = $alertApp->count();
            echo json_encode($json);
        }
    }

    public function finish(?array $data): void
    {
        $notification = (new Orders())->find("status = :st AND notification = :a", "st=1&a=open")->fetch(true);

        if ($notification) {
            foreach ($notification as $p) {
                $p->notification = "viewed";
                $p->save();
            }
            $json['viewed'] = true;
            echo json_encode($json);
        }
    }

    //INSERE A NOTA NO PEDIDO
    public function notes(?array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $orderId = filter_var($data["observatio_order_id"], FILTER_VALIDATE_INT);
        if (!empty($data)) {
            $order = (new Orders)->findById($orderId);
            $order->note = $data["note"];
            $order->save();
            if ($order->save()) {
                $json["message"] = "success";
                $json["note"] = $order->note;
                $json["id"] = $order->id;
                echo json_encode($json);
                return;
            }
        }
    }


    //MATA O LOGIN
    public function logoff(): void
    {
        $this->message->success("Você saiu com sucesso {$this->user->first_name}.")->flash();

        Auth::logout();
        redirect("/admin/login");
    }
}