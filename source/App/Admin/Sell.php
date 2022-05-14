<?php

namespace Source\App\Admin;

class Sell extends Admin
{
    public function __construct()
    {
        parent::__construct();
    }


    public function sellByDay(?array $data): void
    {

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Vendas por dia",
            CONF_SITE_DESC,
            url("/admin"),
            false
        );

        echo $this->view->render("widgets/sell/home", [
            "app" => "faq/home",
            "head" => $head
        ]);
    }


    public function sellByMonth(?array $data): void
    {

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Vendas por mês",
            CONF_SITE_DESC,
            url("/admin"),
            false
        );

        echo $this->view->render("widgets/sell/month", [
            "app" => "faq/home",
            "head" => $head
        ]);
    }
}
