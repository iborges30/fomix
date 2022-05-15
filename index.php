<?php
// server should keep session data for AT LEAST 1 hour
ini_set('session.gc_maxlifetime', 3600*5);

// each client should remember their session id for EXACTLY 1 hour
session_set_cookie_params(3600*5); 
ob_start();

require __DIR__ . "/vendor/autoload.php";

/**
 * BOOTSTRAP
 */

use CoffeeCode\Router\Router;
use Source\Core\Session;

$session = new Session();
$route = new Router(url(), ":");
$route->namespace("Source\App");


/**
 * WEB ROUTES
 */
$route->group(null);
$route->get("/", "Web:cities");
$route->get("/cidades/{p}", "Web:shops");
$route->get("/{slug}", "Web:home");
$route->get("/{slug}/checkout", "Web:checkout");
$route->get("/{slug}/pedido/meus-dados", "Web:client");
$route->get("/{slug}/my-request/{token}", "Web:myRequest");
$route->get("/{slug}/my-request-ajax/{token}", "Web:myRequestAjax");
$route->get("/segmentos", "Web:segment");
$route->get("/meus-pedidos/{client_id}", "Web:allRequestClient");
$route->get("/meus-pedidos/{client_id}/{p}", "Web:allRequestClient");


$route->post("/avalia/pedido/client", "Web:evaluation");
$route->post("/verifica/pedido/modal", "Web:checkEvaluation");
$route->post("/request-observation", "Web:requestObservation");
$route->post("/account", "Account:account");
$route->post("/search/product", "Web:searchProduct");
$route->post("/category/slug", "Web:category");
$route->post("/product/{id}", "Web:product");

$route->post("/bag", "Web:bag");
$route->post("/check-flavor", "Web:checkFlavor");

$route->get("/my-request/{token}", "Web:myRequest");
$route->get("/enterprise/{slug}/{enterprise_id}", "Web:listRequestEnterprise");

$route->post("/enterprise/status", "Web:changeStatusMobile");


//APLICA CUPOM
$route->post("/apply-coupom", "Web:applyCoupom");


//FEED
$route->get("/feed/{slug_city}", "Web:feed");

//LIKE
$route->post("/feed/like", "Web:like");

//CONVÊNIO
$route->get("/convenio/cadastro", "Web:register");
$route->post("/convenio/cadastro", "Web:createFriend");

/**
 * VALIDAÇÔES
 */
$route->post("/add-flavor", "Web:addFlavor");
$route->post("/remove-flavor", "Web:removeFlavor");

$route->post("/options", "Web:addOption");
$route->post("/remove-options", "Web:removeOptions");

$route->post("/add-additional", "Web:additionalItems");
$route->post("/remove-additional", "Web:removeAdditionalItems");
/*
REMOVE ITEM CHECKOUT
 */
$route->post("/remove-item-checkout", 'Web:removeItemChecout');
/*
REMOVE A SESSÃO PARA REINICIAR O PEDIDO
 */
$route->post("/refazer-pedido", 'Web:refazerPedido');
/*
REMOVE A SESSION CASO SAIA DO PRODUTO
*/
$route->post("/remove-session", "Web:removeItemSession");

/*
*VALIDAÇÂO DE ITEMS*
*/
$route->post("/flavors", "Web:flavors");

/*
* Salvar cadastro e pedido
*/
$route->post('/send-order', "Web:saveOrder");
/*
* RETORNA DADOS DO CLIENTE
*/
$route->post("/address", "Web:address");


/***************************************
 * *************************************
 * *********** FOMIX DELIVERY ***********
 ***************************************/
$route->get("/d/user/login", "AppDelivery:formLogin");
$route->get("/delivery/user/{id}", "AppDelivery:home");
$route->get("/delivery/user/in_race/{id}", "AppDelivery:inRace");
$route->get("/delivery/user/report/{id}", "AppDelivery:report");
$route->get("/delivery/user/historic/{id}", "AppDelivery:historic");
$route->get("/delivery/user/historic/{id}/{page}", "AppDelivery:historic");

$route->post("/login/delivery/auth", "AppDelivery:auth");
$route->post("/request/delivery/race", "AppDelivery:raceAccept");
$route->post("/delivery/user/{id}", "AppDelivery:getDeliveries");
$route->post("/delivery/user/status", "AppDelivery:statusDelivery");




//blog
$route->group("/blog");
$route->get("/", "Web:blog");
$route->get("/p/{page}", "Web:blog");
$route->get("/{uri}", "Web:blogPost");
$route->post("/buscar", "Web:blogSearch");
$route->get("/buscar/{search}/{page}", "Web:blogSearch");
$route->get("/em/{category}", "Web:blogCategory");
$route->get("/em/{category}/{page}", "Web:blogCategory");

//auth
$route->group(null);
$route->get("/entrar", "Web:login");
$route->post("/entrar", "Web:login");
$route->get("/cadastrar", "Web:register");
$route->post("/cadastrar", "Web:register");
$route->get("/recuperar", "Web:forget");
$route->post("/recuperar", "Web:forget");
$route->get("/recuperar/{code}", "Web:reset");
$route->post("/recuperar/resetar", "Web:reset");

//optin
$route->group(null);
$route->get("/confirma", "Web:confirm");
$route->get("/obrigado/{email}", "Web:success");

//services
$route->group(null);
$route->get("/termos", "Web:terms");

/**
 * APP
 */
$route->group("/app");
$route->get("/", "App:home");
$route->get("/receber", "App:income");
$route->get("/receber/{status}/{category}/{date}", "App:income");
$route->get("/pagar", "App:expense");
$route->get("/pagar/{status}/{category}/{date}", "App:expense");
$route->get("/fixas", "App:fixed");
$route->get("/carteiras", "App:wallets");
$route->get("/fatura/{invoice}", "App:invoice");
$route->get("/perfil", "App:profile");
$route->get("/assinatura", "App:signature");
$route->get("/sair", "App:logout");

$route->post("/dash", "App:dash");
$route->post("/launch", "App:launch");
$route->post("/invoice/{invoice}", "App:invoice");
$route->post("/remove/{invoice}", "App:remove");
$route->post("/support", "App:support");
$route->post("/onpaid", "App:onpaid");
$route->post("/filter", "App:filter");
$route->post("/profile", "App:profile");
$route->post("/wallets/{wallet}", "App:wallets");

/**
 * ADMIN ROUTES
 */
$route->namespace("Source\App\Admin");
$route->group("/admin");

//login
$route->get("/", "Login:root");
$route->get("/login", "Login:login");
$route->post("/login", "Login:login");

//dash
$route->get("/dash", "Dash:dash");
$route->get("/dash/home", "Dash:list");
$route->post("/dash/home", "Dash:list");
$route->get("/logoff", "Dash:logoff");
$route->post("/dash/status", "Dash:changeStatus");
$route->post("/dash/alert", "Dash:alert");
$route->post("/dash/finish", "Dash:finish");
$route->get("/dash/orders-print/{id}", "Dash:print");

$route->post("/dash/notes", "Dash:notes");
$route->post("/dash/status-shop", "Dash:shop");








/***************************************
 * *************************************
 * *********** FOMIX *******************
 ***************************************/


//CATEGORIAS
$route->get("/categories/home", "CategoryController:home");
$route->get("/categories/home/{page}", "CategoryController:home");
$route->get("/categories/category", "CategoryController:category");
$route->get("/categories/category/{id}", "CategoryController:category");

$route->post("/categories/category", "CategoryController:category");
$route->post("/categories/category/{id}", "CategoryController:category");
$route->post("/category/products", "CategoryController:createInModalProduct");


//OPCIONAIS
$route->get("/options/home", "OptionController:home");
$route->get("/options/home/{page}", "OptionController:home");
$route->get("/options/option", "OptionController:option");
$route->get("/options/option/{id}", "OptionController:option");

$route->post("/options/option", "OptionController:option");
$route->post("/options/option/{id}", "OptionController:option");
$route->post("/options/related", "OptionController:related");
$route->post("/options-items/modal", "OptionController:modal");
$route->post("/options-items/relationship", "OptionController:relationship");
$route->post("/options-items/delete/{id}", "OptionController:delete");
$route->post("/options/inactive/{id}", "OptionController:inactive");


//ADICIONAIS
$route->get("/additional/home", "AdditionalController:home");
$route->get("/additional/home/{page}", "AdditionalController:home");
$route->get("/additional/manager", "AdditionalController:manager");
$route->get("/additional/manager/{id}", "AdditionalController:manager");

$route->post("/additional/manager", "AdditionalController:manager");
$route->post("/additional/manager/{id}", "AdditionalController:manager");
$route->post("/additional/delete/{id}", "AdditionalController:delete");

$route->post("/additional/related", "AdditionalController:related");
$route->post("/additional-items/modal", "AdditionalController:modal");
$route->post("/additional-items/relationship", "AdditionalController:relationship");
$route->post("/additional-items/delete/{id}", "AdditionalController:deleteItems");


//FLAVORS
$route->get("/flavors/home", "FlavorController:home");
$route->get("/flavors/home/{page}", "FlavorController:home");
$route->get("/flavors/manager", "FlavorController:manager");
$route->get("/flavors/manager/{id}", "FlavorController:manager");

$route->post("/flavors/manager", "FlavorController:manager");
$route->post("/flavors/manager/{id}", "FlavorController:manager");
$route->post("/flavors/delete/{id}", "FlavorController:delete");

$route->post("/flavors/related", "FlavorController:related");
$route->post("/flavors-items/modal", "FlavorController:modal");
$route->post("/flavors-items/relationship", "FlavorController:relationship");
$route->post("/flavors-items/delete/{id}", "FlavorController:deleteItems");


//PRODUTOS

$route->get("/products/category/{category_id}/home", "ProductController:home");

$route->get("/products/category/{category_id}/home/{page}", "ProductController:home");

$route->get("/products/manager", "ProductController:manager");
$route->get("/products/manager/{id}", "ProductController:manager");

$route->get("/products/category", "ProductController:category");
$route->get("/products/category/{page}", "ProductController:category");

$route->get("/products/inactive", "ProductController:showInactive");
$route->get("/products/inactive/{page}", "ProductController:showInactive");

$route->post("/products/manager", "ProductController:manager");
$route->post("/products/manager/{id}", "ProductController:manager");
$route->post("/products/delete/{id}", "ProductController:manager");
$route->post("/products/inactive/{id}", "ProductController:inactive");


//VENDAS
$route->get("/sell/home", "SellController:home");
$route->post("/sell/home", "SellController:home");
$route->get("/sell/home/{search}", "SellController:home");

$route->get("/sell/month", "SellController:sellMonth");
$route->post("/sell/month", "SellController:sellMonth");
$route->get("/sell/month/{search}", "SellController:sellMonth");
//RELATÓRIO DE VENDAS
$route->get("/reports/home", "ReportsController:home");
$route->get("/reports/home/{page}", "ReportsController:home");
$route->post("/reports/home", "ReportsController:home");

//ENTERPRISE MASTER
$route->get("/enterprise/home", "AdminMaster:home");
$route->get("/enterprise/home/{page}", "AdminMaster:home");
$route->get("/enterprise/users/{enterprise_id}", "AdminMaster:users");
$route->get("/enterprise/users/{enterprise_id}/{page}", "AdminMaster:users");
$route->get("/enterprise/restaurant", "AdminMaster:restaurant");
$route->get("/enterprise/enterprises", "AdminMaster:enterprises");
$route->get("/enterprise/enterprises/{id}", "AdminMaster:enterprises");
$route->post("/enterprise/create", "AdminMaster:enterprises");
$route->post("/enterprise/update/{id}", "AdminMaster:update");
$route->post("/entreprise/delete/{id}", "AdminMaster:delete");


//CUPONS DE DESCONTO
$route->get("/coupons/home", "CouponsController:home");
$route->get("/coupons/coupons", "CouponsController:coupons");
$route->get("/coupons/coupons/{id}", "CouponsController:show");
$route->get("/coupon/enterprise/{id}", "CouponsController:enterprise");


$route->post("/coupons/coupons", "CouponsController:create");
$route->post("/coupons/coupons/{id}", "CouponsController:update");
$route->post("/coupons/related", "CouponsController:related");
$route->post("/coupon/delete/related", "CouponsController:deleteRelated");


$route->get("/riders/home", "RidersController:home");
$route->get("/riders/rider", "RidersController:rider");
$route->get("/riders/rider/{id}/{status}", "RidersController:edit");
$route->get("/race/enterprise/list", "RidersController:listDeliveries");
$route->get("/race/enterprise/list/{page}", "RidersController:listDeliveries");

$route->post("/modal/race", "RidersController:modal");
$route->post("/riders/modal/client", "RidersController:searchOrder");
$route->post("/ride/create", "RidersController:create");
$route->post("/ride/update/{id}", "RidersController:update");


$route->post("/race/enterprise/acceppt", "RidersController:acceptDelivery");
$route->post("/race/enterprise/finish", "RidersController:finish");

//Controlar abre/fecha
$route->get("/times/enterprise", "TimesController:home");
$route->get("/times/enterprise/{page}", "TimesController:home");
$route->post("/times/close", "TimesController:close");


//BALANCE
$route->get("/user/invoices/{enterprise_id}", "InvoicesController:show");
$route->get("/user/invoices/edit/{invoice_id}", "InvoicesController:edit");
$route->post("/user/invoices/edit/{invoice_id}", "InvoicesController:edit");


$route->get("/enterprise/invoice", "InvoicesController:init");
$route->get("/enterprise/invoice/create", "InvoicesController:create");
$route->post("/enterprise/invoice/create", "InvoicesController:create");




//ENTERPRISE LIST USERS
$route->get("/enterprise/myenterprise", "EnterpriseController:myenterprise");
$route->get("/enterprise/list/users", "EnterpriseController:listuser");
$route->get("/enterprise/user/update/{iduser}", "EnterpriseController:dataEditUser");
$route->post("/enterprise/user/userupdate/{user_id}", "EnterpriseController:updateUser");
$route->post("/enterprise/user/usercreate", "EnterpriseController:createUser");
$route->get("/enterprise/user/newuser", "EnterpriseController:viewUser");
$route->post("/enterprise/myenterprise/update", "EnterpriseController:update");
$route->post("/entreprise/user/delete/{id}", "EnterpriseController:delete");
$route->post("/enterprise/myenterprise/update-cover", "EnterpriseController:updateCover");
$route->post("/enterprise/myenterprise/update-config", "EnterpriseController:updateConfig");
$route->post("/enterprise/myenterprise/update-free-delivery", "EnterpriseController:freeDelivery");
$route->post("/enterprise/myenterprise/update-param-products", "EnterpriseController:parameterizeProducts");





//CADASTRO DOS ENTREGADORES
$route->get("/deliveries/home", "DeliveriesController:home");
$route->get("/deliveries/home/{page}", "DeliveriesController:home");
$route->get("/deliveries/create", "DeliveriesController:show");
$route->get("/deliveries/update/{id}", "DeliveriesController:edit");
$route->get("/deliveries/wallet/{id}", "DeliveriesController:wallet");
$route->get("/deliveries/report/{id}", "DeliveriesController:reportWallet");

$route->post("/deliveries/payment/delivery", "DeliveriesController:payment");

$route->post("/delivery/user/create", "DeliveriesController:create");
$route->post("/delivery/user/update/{id}", "DeliveriesController:update");

//FEED
$route->get("/feed/home", "FeedController:home");
$route->get("/feed/home/{page}", "FeedController:home");
$route->get("/feed/create", "FeedController:show");
$route->get("/feed/create/{id}", "FeedController:edit");

$route->post("/feed/post", "FeedController:create");
$route->post("/feed/post/{id}", "FeedController:update");
$route->post("/feed/delete/{id}", "FeedController:delete");


//control
$route->get("/control/home", "Control:home");
$route->get("/control/subscriptions", "Control:subscriptions");
$route->post("/control/subscriptions", "Control:subscriptions");
$route->get("/control/subscriptions/{search}/{page}", "Control:subscriptions");
$route->get("/control/subscription/{id}", "Control:subscription");
$route->post("/control/subscription/{id}", "Control:subscription");
$route->get("/control/plans", "Control:plans");
$route->get("/control/plans/{page}", "Control:plans");
$route->get("/control/plan", "Control:plan");
$route->post("/control/plan", "Control:plan");
$route->get("/control/plan/{plan_id}", "Control:plan");
$route->post("/control/plan/{plan_id}", "Control:plan");

//blog
$route->get("/blog/home", "Blog:home");
$route->post("/blog/home", "Blog:home");
$route->get("/blog/home/{search}/{page}", "Blog:home");
$route->get("/blog/post", "Blog:post");
$route->post("/blog/post", "Blog:post");
$route->get("/blog/post/{post_id}", "Blog:post");
$route->post("/blog/post/{post_id}", "Blog:post");
$route->get("/blog/categories", "Blog:categories");
$route->get("/blog/categories/{page}", "Blog:categories");
$route->get("/blog/category", "Blog:category");
$route->post("/blog/category", "Blog:category");
$route->get("/blog/category/{category_id}", "Blog:category");
$route->post("/blog/category/{category_id}", "Blog:category");

//faqs
$route->get("/faq/home", "Faq:home");
$route->get("/faq/home/{page}", "Faq:home");
$route->get("/faq/channel", "Faq:channel");
$route->post("/faq/channel", "Faq:channel");
$route->get("/faq/channel/{channel_id}", "Faq:channel");
$route->post("/faq/channel/{channel_id}", "Faq:channel");
$route->get("/faq/question/{channel_id}", "Faq:question");
$route->post("/faq/question/{channel_id}", "Faq:question");
$route->get("/faq/question/{channel_id}/{question_id}", "Faq:question");
$route->post("/faq/question/{channel_id}/{question_id}", "Faq:question");

//users
$route->get("/users/home", "Users:home");
$route->post("/users/home", "Users:home");
$route->get("/users/home/{search}/{page}", "Users:home");
$route->get("/users/user", "Users:user");
$route->post("/users/user", "Users:user");
$route->get("/users/user/{user_id}", "Users:user");
$route->post("/users/user/{user_id}", "Users:user");

//notification center
$route->post("/notifications/count", "Notifications:count");
$route->post("/notifications/list", "Notifications:list");

//END ADMIN
$route->namespace("Source\App");

/**
 * PAY ROUTES
 */
$route->group("/pay");
$route->post("/create", "Pay:create");
$route->post("/update", "Pay:update");



/*
 * RIDES (ENTEGAS)
 */



/**
 * ERROR ROUTES
 */
$route->group("/ops");
$route->get("/{errcode}", "Web:error");

/**
 * ROUTE
 */
$route->dispatch();

/**
 * ERROR REDIRECT
 */
if ($route->error()) {

    $route->redirect("/ops/{$route->error()}");
}

ob_end_flush();
