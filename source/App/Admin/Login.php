<?php

namespace Source\App\Admin;

use Source\Core\Controller;
use Source\Models\Auth;
use Source\Models\ShopOpens\ShopOpens;

/**
 * Class Login
 * @package Source\App\Admin
 */
class Login extends Controller
{
    /**
     * Login constructor.
     */
    public function __construct()
    {
        parent::__construct(__DIR__ . "/../../../themes/" . CONF_VIEW_ADMIN . "/");
    }

    /**
     * Admin access redirect
     */
    public function root(): void
    {
        $user = Auth::user();

        if ($user && $user->level >= 3) {
            redirect("/admin/dash");
        } else {
            redirect("/admin/login");
        }
    }

    /**
     * @param array|null $data
     */
    public function login(?array $data): void
    {
        $user = Auth::user();

        if ($user && $user->level >= 3) {
            redirect("/admin/dash");
        }

        if (!empty($data["email"]) && !empty($data["password"])) {
         /*   if (request_limit("loginLogin", 3, 5 * 60)) {
                $json["message"] = $this->message->error("ACESSO NEGADO: Aguarde por 5 minutos para tentar novamente.")->render();
                echo json_encode($json);
                return;
            }*/

            $auth = new Auth();
            $login = $auth->login($data["email"], $data["password"], true, 3);

            if ($data["email"] != 'comercial@clickwebdesignertga.com.br') {
                if ($login) {
                    //AQUI
                    $enterpriseId = user()->enterprise_id;
                    $shop = (new ShopOpens)->find("enterprise_id = :e", "e={$enterpriseId}")->fetch();
                    if (!$shop) {
                        $shopCreate = new ShopOpens;
                        $shopCreate->day = date("Y-m-d");
                        $shopCreate->status = "open";
                        $shopCreate->enterprise_id = $enterpriseId;
                        $shopCreate->save();
                    } else {
                        $shop->status = "open";
                        $shop->day = date("Y-m-d");
                        $shop->save();
                    }
                    $json["redirect"] = url("/admin/dash");
                } else {
                    $json["message"] = $auth->message()->render();
                }
            } else {
                $json["redirect"] = url("/admin/enterprise/home");
            }

            echo json_encode($json);
            return;
        }

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Admin",
            CONF_SITE_DESC,
            url("/admin"),
            theme("/assets/images/image.jpg", CONF_VIEW_ADMIN),
            false
        );

        echo $this->view->render("widgets/login/login", [
            "head" => $head
        ]);
    }
}
