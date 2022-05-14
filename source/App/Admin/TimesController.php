<?php


namespace Source\App\Admin;


use Source\Models\Auth;
use Source\Models\Enterprises\Enterprises;
use Source\Models\ShopOpens\ShopOpens;
use Source\Support\Pager;

class TimesController extends Admin
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
        $enterprises = (new ShopOpens())->findCustom("SELECT
	shop_opens.`status`, 
	shop_opens.id, 
	enterprises.enterprise 
 
FROM
	shop_opens
	INNER JOIN
	enterprises
	ON 
		shop_opens.enterprise_id = enterprises.id
WHERE
   	enterprises.`status` = 'active' ");

        $pager = new Pager(url("/admin/times/enterprise/"));
        $pager->pager($enterprises->count(), 15, (!empty($data["page"]) ? $data["page"] : 1));

        $head = $this->seo->render(
            CONF_SITE_NAME . " Gerenciar empresas ",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/times/home", [
            "app" => "time/home",
            "head" => $head,
            "enterprises" => $enterprises->order("status DESC")->limit($pager->limit())->offset($pager->offset())->fetch(true),
            "paginator" => $pager->render()
        ]);
    }

    public function close(?array $data): void
    {
       
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $shopId = filter_var($data['shopId'], FILTER_VALIDATE_INT);
        $shop = (new ShopOpens)->findById($shopId);
        $shop->status = $data["status"] == 'close' ? 'open' : 'close';
        $shop->save();
        if ($shop) {
            $this->message->success("Loja Fechada com sucesso.")->flash();
            echo json_encode(["redirect" => url("/admin/times/enterprise")]);
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

}