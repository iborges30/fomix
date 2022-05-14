<?php

use Source\Models\Auth;

$levelUser = Auth::user()->level;
$nav = function ($title, $icon, $navItems) use ($app) {

    foreach ($navItems as $name => $url) {
        $active = ($app == $url ? " active" : null);
        $url = url("/admin/{$url}");
        $nav[] = "<a class=\"collapse-item{$active}\" href=\"{$url}\">{$name}</a>";
    }

    $id = ucfirst($title);
    $navItem = implode(null, $nav);

    $collapse = function ($if, $else) use ($app, $url) {
        return (explode("/", $app)[0] == explode("/", $url)[5] ? $if : $else);
    };

    return "<li class=\"nav-item{$collapse(" active", null)}\">
                <a class=\"nav-link {$collapse(" collapsed", null)}\" href=\"#\" 
                   data-toggle=\"collapse\" data-target=\"#collapse{$id}\" 
                   aria-expanded=\"{$collapse("true", "false")}\" aria-controls=\"collapse{$title}\">
                    <i class=\"{$icon}\"></i>
                    <span>{$id}</span>
                </a>
                <div id=\"collapse{$id}\" class=\"collapse{$collapse(" show", null)}\" aria-labelledby=\"heading" . ucfirst($title) . "\" data-parent=\"#accordionSidebar\">
                    <div class=\"bg-white py-2 collapse-inner rounded\">{$navItem}</div>
                </div>
            </li>";
};




if ($levelUser < 5) {
    echo $nav("Entregadores", "fas fa-motorcycle", [
        "Entregas" => "riders/home",
        "Listar entregas" => "race/enterprise/list",
        "Minha conta" => "enterprise/invoice"
    ]);


//VENDAS
echo $nav("Vendas", "fas fa-fw fa-credit-card", [
    "Diárias" => "sell/home",
    "Mensal" => "sell/month"
]);
//PEDIDOS
echo $nav("Pedidos", "fas fa-fw fa-receipt", [
    "Listar pedidos" => "reports/home"
]);

// Control Admin Master

    // Control

    echo $nav("Feed", "fas fa-comment", [
        "Feed" => "feed/home",
        "Novo post" => "feed/create",
        "Termos de uso"=>"../documents/termos-de-uso-usuario-feed.pdf"
    ]);


    echo $nav("Categorias", "fas fa-fw fa-tachometer-alt", [
        "Categorias" => "categories/home",
        "Nova categoria" => "categories/category"
    ]);


    echo $nav("Produtos", "fas fa-fw fa-pizza-slice", [
        "Produtos" => "products/category",
        "Inativos" => "products/inactive",
        "Novo produto" => "products/manager"
    ]);



    //COMPLEMENTOS
    echo $nav("Opcionais", "fas fa-fw fa-plus-circle", [
        "Opcionais" => "options/home",
        "Novo item opcional" => "options/option"
    ]);

    //COMPLEMENTOS
    echo $nav("Adicionais", "fas fa-fw fa-puzzle-piece", [
        "Adicionais" => "additional/home",
        "Novo item Adicional" => "additional/manager"
    ]);

    //COMPLEMENTOS
    echo $nav("Sabores", "fas fa-fw fa-cookie-bite", [
        "Sabores" => "flavors/home",
        "Novo sabor" => "flavors/manager"
    ]);
}


if ($levelUser >= 4) {
    echo $nav("Usuários", "fas fa-fw fa-user", [
        "Listar Usuário" => "enterprise/list/users",
        "Novo Usuário" => "enterprise/user/newuser"
    ]);
}
// Control Empresa
if ($levelUser == 4) {
    echo $nav("Empresas", "fas fa-fw fa-building", [
        "Meus Dados" => "enterprise/myenterprise"
    ]);

}

// Control Admin Master
if ($levelUser >= 5) {
    echo $nav("Empresas", "fas fa-fw fa-building", [
        "Listar Empresas" => "enterprise/home",
        "Nova empresa" => "enterprise/enterprises"
    ]);

    echo $nav("Gerenciar", "fas fa-door-open", [
        "Fechar lojas" => "times/enterprise",
    ]);


    echo $nav("Cupons", "fas fa-tags", [
        "Meus cupons" => "coupons/home",
        "Novo Cupom" => "coupons/coupons"
    ]);



    echo $nav("Entregadores", "fas fa-motorcycle", [
        "Entregadores" => "deliveries/home",
        "Novo Entregador" => "deliveries/create"
    ]);
}
