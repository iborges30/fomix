<?php

namespace Source\App;

use Source\Core\Controller;
use Source\Models\Additional\Additional;
use Source\Models\CartItems\CartItems;

use Source\Models\Clients\Clients;
use Source\Models\Coupons\Coupons;
use Source\Models\Enterprises\Enterprises;
use Source\Models\EnterprisesCoupons\EnterprisesCoupons;
use Source\Models\Evaluation\Evaluation;
use Source\Models\Feed\Feed;
use Source\Models\Flavors\Flavors;
use Source\Models\Options\Options;
use Source\Models\ProductCategories\ProductCategories;
use Source\Models\Products\Products;
use Source\Models\Clients\ClientRepository;
use Source\Models\Orders\Orders;
use Source\Models\Orders\OrdersRepository;
use Source\Models\OrdersItems\OrdersItems;
use Source\Models\Report\Access;
use Source\Models\ShopOpens\ShopOpens;
use Source\Support\Pager;

/**
 * Web Controller
 * @package Source\App
 */
class Web extends Controller
{
    /**
     * Web constructor.
     */
    public function __construct()
    {
        parent::__construct(__DIR__ . "/../../themes/" . CONF_VIEW_THEME . "/");
        (new Access())->report();
    }


    /**
     * TODOS OS SEGMENTOS
     *
     */

    public function segment(): void
    {
        $head = $this->seo->render(
            CONF_SITE_NAME . " - " . CONF_SITE_TITLE,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg")
        );
        echo $this->view->render("segments", [
            "head" => $head,
        ]);
    }


    public function cities(): void
    {

        $enterprises = (new Enterprises)->find("status = :s GROUP BY city", "s=active", "city, slug_city")->order("city ASC")->fetch(true);
        $head = $this->seo->render(
            CONF_SITE_NAME . " - " . CONF_SITE_TITLE,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg")
        );
        echo $this->view->render("cities", [
            "head" => $head,
            "enterprises" => $enterprises
        ]);
    }


    /**
     * TODOS OS MERCADOS
     */
    public function shops(?array $data): void
    {

        //LIMPA A SESSION CART SEMPRE QUE ENTRA NO SHOP
        if (!empty($_SESSION["cart"])) {
            unset($_SESSION["cart"]);
        }

        $enterprises = (new Enterprises())->enterpriseAll($data['p']);
        $feed = (new Feed())->feed($data['p'], 10);

        $pager = new Pager(url("/admin/enterprise/home/"));
        $pager->pager($enterprises->count(), 20, (!empty($data["page"]) ? $data["page"] : 1));


        $cupons = (new Coupons())->find("status = :st", "st=active")->fetch();
        $couponsRelated = (new EnterprisesCoupons())->find("coupon_id = :di", "di={$cupons->id}")->fetch(true);

        $head = $this->seo->render(
            CONF_SITE_NAME . " - " . CONF_SITE_TITLE,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg")
        );

        echo $this->view->render("shops", [
            "head" => $head,
            'data' => $enterprises->order("shop_opens.status DESC, views DESC, enterprise ASC")->limit($pager->limit())->offset($pager->offset())->fetch(true),
            "paginator" => $pager->render(),
            "coupons" => $couponsRelated ?? null,
            "disconunt" => $cupons ?? null,
            "feed" => $feed,
            "city" => $data['p']

        ]);
    }

    /**
     * SITE HOME
     */
    public function home(?array $data): void
    {

        $enterprise = (new Enterprises)->find("slug = :s", "s={$data['slug']}")->fetch();
        $categories = (new Products())->categories($enterprise->id);
        $products = (new Products)->all($enterprise->id);

        $param = $enterprise->parameterize_products == 'active' ? " position ASC, price ASC, name ASC" : " views DESC, price ASC, name ASC";

        //SOMA +1 VIEWS PARA O LOJA
        $enterprise->views += 1;
        $enterprise->save();


        $getCouponId = (new Coupons())->find("status = :st", "st=active")->fetch();

        if ($getCouponId) {
            $coupon = (new EnterprisesCoupons())->find("coupon_id = :di AND enterprise_id = :en", "di={$getCouponId->id}&en={$enterprise->id}")->fetch();

        }

        $shop = (new ShopOpens)->find("enterprise_id = :s", "s={$enterprise->id}");

        if (!$enterprise) {
            redirect("/");
        }

        $_SESSION['slug_enterprise'] = $data['slug'];
        $_SESSION['enterprise_id'] = $enterprise;

        $head = $this->seo->render(
            CONF_SITE_NAME . " - " . CONF_SITE_TITLE,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg")
        );

        echo $this->view->render("home", [
            "head" => $head,
            "categories" => $categories->order("position ASC, category ASC")->fetch(true),
            "products" => $products->order($param)->limit(65)->fetch(true),
            "enterprise" => $enterprise,
            "shop" => $shop->fetch(),
            "promotions" => $products->find("status = :st AND enterprise_id = :p AND promotion = :m", "st=active&p={$enterprise->id}&m=yes")->order("price ASC, name asc")->limit(5)->fetch(true),
            "coupom" => $coupon ?? null,
            "couponName" => $getCouponId ?? null
        ]);
    }

    /**
     ************************************
     ************ BUSCA A CATEGORIA
     ***********************************/
    public function category(?array $data): void
    {
        $categoryId = filter_var($data['categoryId'], FILTER_VALIDATE_INT);
        if (!empty($categoryId)) {
            $products = (new Products)->find("category_id = :di AND status = :st ", "di={$categoryId}&st=active");

            echo $this->view->render("products", [
                "products" => $products->order("price DESC")->fetch(true)

            ]);
        }
    }

    /**
     ************************************
     ************ BUSCA o PRODUTO
     ***********************************/
    public function product(?array $data): void
    {
        $enterpriseId = $_SESSION['enterprise_id']->id;
        //CRIA UMA SESS??O AO INICIAR O PRODUTO
        $_SESSION['product_id'] = $data['id'] . '-' . md5(uniqid(rand(), true));

        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $productId = filter_var($data['id'], FILTER_SANITIZE_STRIPPED);
        $product = (new Products)->findById($productId);

        //TRAZ OS ITENS COM BASE NA CATEGORIA DO PRODUTO
        $flavors = (new Flavors)->find("category_id = :c AND status = :st", "c={$product->category_id}&st=active");
        $options = (new Options)->find("category_id = :c AND status = :st", "c={$product->category_id}&st=active");
        $additional = (new Additional)->find("category_id = :c AND status = :st", "c={$product->category_id}&st=active");


        //CRIA A SESSION QUANDO ?? ABERTO A P??GINA DE LEITURA DO PRODUTO

        $_SESSION["cart"][$_SESSION['product_id']] = $data;
        $_SESSION["cart"][$_SESSION['product_id']]['product_id'] = $_SESSION['product_id'];

        //SOMA +1 VIEWS PARA O PRODUTO
        $product->views += 1;
        $product->save();

        echo $this->view->render("modal", [
            "product" => $product,
            "flavors" => $flavors->order("flavor ASC")->fetch(true) ?? null,
            "options" => $options->order("item ASC")->fetch(true) ?? null,
            "add" => $additional->order("additional ASC")->fetch(true) ?? null
        ]);
    }

    /**
     *********************************************
     ************ REMOVER INDICE DA SESSION
     *********************************************/
    public function removeItemSession(?array $data): void
    {

        //REMOVE A SESSION CASO A PAGINA DE LEITURA SEJA FECHADA
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        if (isset($_SESSION["cart"])) {
            unset($_SESSION['cart'][$data['id']]);
        }
    }

    /**
     *********************************************
     ************ CONTROLE DOS SABORES
     *********************************************/
    public function addFlavor(?array $data): void
    {
        $data['id'] = $_SESSION['product_id']; //ADICIONADO PARA TESTE

        $maxItem = $data["maxItemSelected"];
        if (isset($_SESSION["cart"][$data['id']])) {
            $count = count($_SESSION['flavors'][$data['id']] ?? []);
            //echo $count;
            if ($count < $maxItem) {
                $_SESSION['flavors'][$data['id']][$data["flavorIdItem"]] = $data['flavorname'] . '.????@.' . $data["flavorIdItem"];
                $_SESSION["cart"][$data["id"]]["flavors"][] = $data["flavorIdItem"];
            } else {
                $json["remove"] = true;
                $json["max"] = true;
                echo json_encode($json);
            }
        }
    }


    /**
     *********************************************
     ************ REMOVE SABORES
     *********************************************/
    public function removeFlavor(?array $data): void
    {
        $data['id'] = $_SESSION['product_id']; //ADICIONADO PARA TESTE
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        unset($_SESSION['flavors'][$data['id']][$data["flavorIdItem"]]);
        $json['remove_flavor'] = true;
        echo json_encode($json);
        return;
    }


    /**
     *********************************************
     ************ CONTROLE DOS OPTIONS
     *********************************************/

    public function addOption(?array $data): void
    {

        $idOptional = $data['option'];
        $totalAmount = $data['totalAmount'] ?? 0;
        $data['id'] = $_SESSION['product_id']; //ADICIONADO PARA TESTE

        $maxItem = $data["maxOptions"];

        $count = count($_SESSION["optional"][$data["id"]] ?? []);

        if (isset($_SESSION["cart"][$data['id']])) {
            if (!empty($_SESSION['optional'][$data['id']])) :
                if (!empty($_SESSION['optional_amount'][$data['id']])) :
                    foreach ($_SESSION['optional_amount'][$data['id']] as $value) {
                        //  $count += $value;
                    }
                endif;
            endif;

            if ($count < $maxItem) {
                $_SESSION['optional'][$data['id']][$idOptional] = $data['nameitem'] . '.????@.' . $idOptional . '.????@.' . ($totalAmount + 1);
                $_SESSION['optional_amount'][$data['id']][$idOptional] = $totalAmount + 1;

                $json["totalamount"] = $totalAmount + 1;
                $json["remove"] = false;
            } else {
                $json["totalamount"] = $totalAmount;
                $json["remove"] = true;
                $json["max"] = true;
            }
            echo json_encode($json);
        }
    }


    //REMOVE OS OPCIONAIS DESMARCADOS
    public function removeOptions(?array $data): void
    {

        $idOptional = $data['option'];
        $data['id'] = $_SESSION['product_id']; //ADICIONADO PARA TESTE
        $totalamount = $data['totalamount'] ?? 0;

        if (isset($_SESSION["cart"][$data['id']])) {
            if (!empty($_SESSION['optional_amount'][$data['id']][$idOptional])) :
                //SE A QAUNTIDADE DESSE OPCIONAL FOR MAIOR QUE 1 SERA REMOVIDO 1 AMOUNT
                if ($_SESSION['optional_amount'][$data['id']][$idOptional] > 1) :
                    $_SESSION['optional_amount'][$data['id']][$idOptional] = $totalamount - 1;
                    $_SESSION['optional'][$data['id']][$idOptional] = $data['nameitem'] . '.????@.' . $idOptional . '.????@.' . ($totalamount - 1);

                    $json["totalamount"] = $totalamount - 1;
                    $json["remove"] = false;
                else :
                    $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
                    unset($_SESSION['optional'][$data['id']][$idOptional]);
                    unset($_SESSION['optional_amount'][$data['id']][$idOptional]);
                    $json["totalamount"] = 0;
                    $json["remove"] = false;
                    $json["max"] = true;
                endif;
            endif;
        }
        echo json_encode($json);
    }


    //ADICIONAIS
    public function additionalItems(?array $data): void
    {
        // var_dump($data);
        $idAdditional = $data['additionalId'];
        $data['id'] = $_SESSION['product_id']; //ADICIONADO PARA TESTE
        // VRIFICA SE EXISTE A SESS??O CART
        if (isset($_SESSION['cart'][$data['id']])) {
            //ADIOCIONA +1 AO ADICIONAL
            $_SESSION['aditionalsAmount'][$data['id']][$data['additionalId']] = $data['amount'] + 1;
            $amount = $_SESSION['aditionalsAmount'][$data['id']][$data['additionalId']];
            //CALCULA O TOTAL DE ITENS
            $totalItems = 0;
            if (!empty($_SESSION['aditionalsAmount'][$data['id']])) :
                foreach ($_SESSION['aditionalsAmount'][$data['id']] as $qnt) {
                    $totalItems += $qnt;
                    //  echo $qnt.'<br>';
                }
            endif;

            if (!$this->validadteTotalItemAmount($data)) {
                $json['error'] = "Voc?? voc?? atingiu o m??ximo deste item para este produto.";
                $amount = $amount - 1;
                $totalItems = $totalItems - 1;
            }

            if (!$this->validadteTotalItems($data, $totalItems)) {
                $json['error'] = "Voc?? n??o pode adicionar mais itens a este produto.";
                $amount = $amount - 1;
                $totalItems = $totalItems - 1;
            }


            $_SESSION['aditionals'][$data['id']][$data['additionalId']] = $data["price"] . '.????@.' . $amount . '.????@.' . $data["additionalName"] . '.????@.' . $idAdditional;


            $count = $amount;

            $json['amount'] = $amount;
            $json['count'] = $count;
            $json['totalItem'] = $totalItems ?? [];
            echo json_encode($json);
        }
    }


    public function removeAdditionalItems(?array $data): void
    {
        $data['id'] = $_SESSION['product_id']; //ADICIONADO PARA TESTE
        // var_dump($data);
        //$_SESSION['cart'][$data['id']]['aditionals'][$data['additionalId']]['amount'] = $data['amount'] < 1 ? 0 : $data['amount'] - 1;
        $amount = $data['amount'] < 1 ? 0 : $data['amount'] - 1;
        $_SESSION['aditionalsAmount'][$data['id']][$data['additionalId']] = $amount;
        $_SESSION['aditionals'][$data['id']][$data['additionalId']] = $data["price"] . '.????@.' . $amount . '.????@.' . $data["additionalName"];


        if ($amount == 0) {
            unset($_SESSION['aditionals'][$data['id']][$data['additionalId']]);
            unset($_SESSION['aditionalsAmount'][$data['id']][$data['additionalId']]);
        }
        $json['amount'] = $amount;
        echo json_encode($json);
    }

    //VALIDA O TOTAL DE ITENS
    private function validadteTotalItems($data, $amount)
    {
        $data['id'] = $_SESSION['product_id']; //PRODUCT ID
        $amountitem = $_SESSION['aditionalsAmount'][$data['id']][$data['additionalId']];
        if ($amount > $data['maxItem']) {
            if ($_SESSION['aditionalsAmount'][$data['id']][$data['additionalId']] <= 1) :
                unset($_SESSION['aditionalsAmount'][$data['id']][$data['additionalId']]);
                unset($_SESSION['aditionals'][$data['id']][$data['additionalId']]);
            endif;
            $_SESSION['aditionalsAmount'][$data['id']][$data['additionalId']] = ($amountitem - 1);
            return false;
        } else {
            $this->validadteTotalItemAmount($data);
        }
        return true;
    }

    //NUMERO M??XIMO DO ITEM ISOLADO
    private function validadteTotalItemAmount($data)
    {
        $data['id'] = $_SESSION['product_id']; //ADICIONADO PARA TESTE
        //$amount = isset($_SESSION['cart'][$data['id']]['aditionals'][$data['additionalId']]['amount']['price']) ? $_SESSION['cart'][$data['id']]['aditionals'][$data['additionalId']]['amount']['price'] : 0;
        $amount = $_SESSION['aditionalsAmount'][$data['id']][$data['additionalId']];
        //echo '---'.$amount;
        if ($amount > $data['maxItemAllow']) {
            $_SESSION['aditionalsAmount'][$data['id']][$data['additionalId']] = $amount ? $amount - 1 : 0;
            return false;
        }
        return true;
    }

    public function checkFlavor(): void
    {
        $data['id'] = $_SESSION['product_id']; //ADICIONADO PARA TESTE
        $count = count($_SESSION['flavors'][$data['id']] ?? []);
        if ($count > 0) :
            $json['flavors'] = true;
        else :
            $json['flavors'] = false;
        endif;
        echo json_encode($json);
    }

    /**
     ************************************
     ************ GERA A BG
     ***********************************/
    public function bag(?array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $data["amountProduct"] = filter_var($data["amountProduct"], FILTER_VALIDATE_INT);
        $flavors = filter_var($data["flavors"], FILTER_VALIDATE_INT);
        $options = filter_var($data["options"], FILTER_VALIDATE_INT);
        $qntflavors = $data['qntflavors'] ?? '0';
        $data['id'] = $_SESSION['product_id']; //ADICIONADO PARA TESTE


        $sabores = $_SESSION['flavors'][$data['id']] ?? []; //$_SESSION['cart'][$data['id']]["flavors"] ?? [];
        $opcionais = $_SESSION['cart'][$data['id']]["option"] ?? [];

        //SE A QUANTIDADE DE SABORES FOR MAIOR QUE 0 FAZ A VERIFICA????O
        if (!empty($qntflavors) > 0) :
            //VALIDA SABORES
            $verificaSabores = $this->validadeInsertCartFlavors($data['id'], $flavors, $sabores, $qntflavors);
            if (!$verificaSabores) {
                echo 'flavors';
                return;
            }
        endif;
        //passa a observa????o para o produto
        if (!empty($data["observations"])) {
            $observations = $_SESSION['cart'][$data['id']]["observations"] = $data["observations"];
        }
        //passa a quantidade do produto
        $amountProdut = $_SESSION['cart'][$data['id']]['amountProduct'] = $data["amountProduct"];

        //PASSA O NOME DO PRODUTO

        $productName = $_SESSION['cart'][$data['id']]['productName'] = $data["productName"];

        //PASSA O VALOR DO PRODUTO
        $productPrice = $_SESSION['cart'][$data['id']]['productPrice'] = $data["productPrice"];


        //VALIDA OPCIONAIS
        $validateOptions = $this->validadeInsertCartOptions($data['id'], $options, $opcionais);
        if (!$validateOptions) {
            echo 'options';
            return;
        }
        //QUANTIDADE DE ITENS NO CARRINHO
        $count = 0;
        //SOMA VALOR DOS ITENS DO CARRINHO
        $total = 0;
        $totalAdditionals = 0;
        $totalConta = 0;

        foreach ($_SESSION['cart'] as $p) {
            if (isset($p['productPrice'])) :
                //FAZ A CONTAGEM DE INTENS NO PEDIDO
                $count = $count + $p["amountProduct"];
                //VERIFICA SE O PRODUTO FOI INCLUINDO NO CARRINHO
                $total += ($p['productPrice'] * $p["amountProduct"]);
                if (isset($_SESSION['aditionals'][$p["product_id"]])) {
                    foreach ($_SESSION['aditionals'][$p["product_id"]] as $value) :
                        $Additionais = explode('.????@.', $value);
                        $valorAdditionais = str_replace(",", ".", $Additionais[0]);
                        $qntAdditionais = $Additionais[1];
                        $totalAdditionals += $p["amountProduct"] * ($qntAdditionais * $valorAdditionais);
                    endforeach;
                }
                $totalConta = ($totalConta + $total + $totalAdditionals);
                $totalAdditionals = 0;
                $total = 0;
            endif;
        }


        echo $this->view->render("bag", [
            "amountInBag" => $count ?? 0,
            "productPrice" => 'R$ ' . str_price($totalConta),
            "url" => $data['url']
        ]);

        //unset($_SESSION["cart"]);
    }


    /**
     * VERIFICA SE EXISTE O SABOR DA PIZZA
     */
    public function validadeInsertCartFlavors($productId, $issetFlavor, $flavors, $qntflavors): bool
    {
        $coutFlavors = count($flavors);
        if (isset($_SESSION['cart'][$productId]) and $coutFlavors < 1) {
            return false;
        }
        return true;
    }

    /**
     * VERIFICA SE EXISTE OS ITENS OPCIONAIS
     */

    public function validadeInsertCartOptions($productId, $issetOption, $options): bool
    {
        //
        if (isset($_SESSION['cart'][$productId]) and $issetOption == 1 and empty($options)) {
            return true;
        }
        return true;
    }

    /**
     * CHECKOUT
     */
    public function checkout(?array $data): void
    {

        $head = $this->seo->render(
            CONF_SITE_NAME . " - " . CONF_SITE_TITLE,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg")
        );

        echo $this->view->render("checkout", [
            "head" => $head,
            "p" => null

        ]);
    }

    /**
     * REFAZER PEDIDO
     */
    public function refazerPedido()
    {
        unset($_SESSION["cart"]);
        unset($_SESSION["aditionals"]);
        unset($_SESSION["optional"]);
        unset($_SESSION["flavors"]);
        unset($_SESSION['requestobservation']);
    }

    /**
     * CLIENT
     */
    public function client(?array $data): void
    {

        //VOC?? PODE COLOCAR A VALIDA????O PARA A DATA AQUI TAMB??M -- VER DEPOIS
        $coupon = (new Coupons())->find("status = :st", "st=active")->fetch();
        $head = $this->seo->render(
            CONF_SITE_NAME . " - " . CONF_SITE_TITLE,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg")
        );

        echo $this->view->render("client", [
            "head" => $head,
            "enterprise" => $_SESSION['enterprise_id'],
            "coupon" => $coupon ?? null
        ]);
    }

    public function removeItemChecout(?array $data): void
    {

        unset($_SESSION["cart"][$data['idSession']]);
        echo true;
    }

    /**
     ***************************************
     ************ METODO PARA REMOVER ITENS
     **************************************/

    public function removeItem($idSession, $nameItem, $idItem): void
    {
        if (($key = array_search($idItem, $_SESSION['cart'][$idSession][$nameItem])) !== false) {
            unset($_SESSION['cart'][$idSession][$nameItem][$key]);
        }
    }


    /**
     ***************************************
     ************ RETORNA ENDERE??O DO CLIENTE
     **************************************/

    public function address(?array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $data["document"] = preg_replace('/[^0-9]/', '', $data["document"]);
        $client = (new Clients)->find("document = :doc", "doc={$data['document']}")->fetch();

        if ($client) {
            $json['client'][] = [
                "client" => $client->client,
                "whatsapp" => $client->whatsapp,
                "address" => $client->address,
                "square" => $client->square,
                "number" => $client->number,
                "complement" => $client->complement,
                "reference" => $client->reference,
            ];
        } else {
            $json["clear"] = 'clear';
        }
        echo json_encode($json);
    }

    //SALVAR CADASTRO CLIENTE CLIENTE
    public function saveOrder(?array $data): void
    {
        $saveCliente = (new ClientRepository())->save($data);
        $this->ordersCompleted($data);
    }

    //FINALIZA O PEDIFO

    public function ordersCompleted(?array $data): void
    {

        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $data["document"] = preg_replace('/[^0-9]/', '', $data["document"]);
        $data["whatsapp"] = preg_replace('/[^0-9]/', '', $data["whatsapp"]);

        //PASSA O 20 PARA A DATA DO CART??O DE CR??DITO


        if (empty($data['csrf'])) {
            echo "Requisi????o inv??lida";
            die();
        }


        //ZERA A TAXA NO CASO DE RETIRADA NA LOJA
        if ($data['sendOrders'] == 'store') :
            $data["delivery_rate"] = 0;
        else :
            $data["delivery_rate"] = $data["rate"];
        endif;
        $paymentId = null;

        $orderRepository = new OrdersRepository();
        $requestobservation = $_SESSION['requestobservation'] ?? [];
        $data['payment_id'] = $paymentId;
        $data['transaction_code'] = $data['transaction_code'] ?? null;
        $clientRepository = new ClientRepository();
        $client = $clientRepository->save($data);
        $data['id'] = $client->id;

        $order = $orderRepository->create($data, $_SESSION['cart'] ?? [], $_SESSION['optional'] ?? [], $_SESSION['aditionals'] ?? [], $_SESSION['flavors'] ?? [], $_SESSION['enterprise_id'] ?? [], $requestobservation);
        $send = $order->send == 'store' ? "Retirar na loja" : "Entrega ?? domic??lio";


        //LIMPA A SESSION
        $this->refazerPedido();

        $setOrders = base64_encode($order->id);
        $url = url("/receipt/{$setOrders}");
        $transaction_key = $order->transaction_key;

        //FORMA A M URL E A MENSAGEM
        $json["completed"] = true;
        $json["url"] = $url;
        $json['transaction_key'] = $transaction_key;
        $json["message"] = "Pedido cadastrado com sucesso.";
        $json["slug"] = $_SESSION['slug_enterprise'];
        $json["phone"] = $_SESSION["enterprise_id"]->phone;
        $json["enterprise_id"] = base64_encode($order->enterprise_id);
        $json["client"] = $data["whatsapp"];
        $json["client_id"] = base64_encode($client->id);


        echo json_encode($json);
        return;
    }

    /*
    * GERA O RECIBO
    */
    public function receipt(array $data): void
    {

        $data["orders_id"] = base64_decode($data["orders_id"]);
        $data["orders_id"] = filter_var($data["orders_id"], FILTER_VALIDATE_INT);
        $order = (new Orders())->findById($data["orders_id"]);
        $items = (new OrdersItems())->findCustom("SELECT
            products.price, 
            products.`name`, 
            orders_items.product_amount, 
            orders_items.product_code
        FROM
            orders_items,
            products

        WHERE
        orders_items.product_id = products.id AND orders_items.order_id = :p", "p={$order->id}")->order("products.name ASC")->fetch(true);

        if (!empty($data)) {
            echo $this->view->render("receipt", [
                "order" => $order,
                "items" => $items
            ]);
        }
    }

    //PESQUISA
    public function searchProduct(?array $data): void
    {

        $enterpriseId = filter_var($data['enterpriseId'], FILTER_VALIDATE_INT);
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        if (!empty($data)) {
            $product = (new Products())->findCustom("SELECT name, slug, image, price, code, id
        FROM products  WHERE name LIKE '%{$data['product']}%' AND status = 'active' AND enterprise_id = :di", "di={$enterpriseId}")->order("name ASC, price ASC")->limit(8)->fetch(true);

            if ($product) {
                foreach ($product as $p) {
                    $json['product'][] = ["id" => $p->id, "price" => $p->price, "name" => $p->name, "slug" => $p->slug, "image" => $p->image];
                }
            } else {
                $json['clear'] = true;
            }
        } else {
            $json['clear'] = true;
        }
        echo json_encode($json);
        return;
    }

    //ACOMPANHAMENTO PEDIDO
    public function myRequest(?array $data): void
    {
        $transaction_key = $data['token'];
        $orders = (new Orders())->findCustom(
            "SELECT
                    u.id, u.enterprise_id, 
                    u.total_orders,
                    u.payment,
                    u.status,
                    u.send,
                    e.client,
                    e.whatsapp FROM
                    orders u, clients e WHERE 
                    u.client_id = e.id  
                AND u.transaction_key = '$transaction_key'
                    "
        )->fetch(true);

        $orderId = $orders[0]->id;

        $order = (new Orders())->find("id = :di", "di={$orderId}")->fetch();
        $items = (new OrdersItems())->has(Products::class, "product_id")->find("order_id = :p", "p={$orderId}")->fetch(true);
        $client = (new Clients())->find("id = :di", "di={$order->client_id}")->fetch();
        $itensOrderAdittionais = (new CartItems())->inner(Additional::class, "product_id")->find("order_id = :p AND category_items = :ad", "p={$orderId}&ad=A")->fetch(true);
        $itensOrderFlavors = (new CartItems())->inner(Flavors::class, "product_id")->find("order_id = :p AND category_items = :ad", "p={$orderId}&ad=S")->fetch(true);
        $itensOrderOptionalItems = (new CartItems())->inner(Options::class, "product_id")->find("order_id = :p AND category_items = :ad", "p={$orderId}&ad=O")->fetch(true);

        $head = $this->seo->render(
            CONF_SITE_NAME . " - " . CONF_SITE_TITLE,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg")
        );

        echo $this->view->render("my-request", [
            "head" => $head,
            "order" => $orders,
            "orders" => $order,
            "client" => $client,
            "items" => $items,
            "additionals" => $itensOrderAdittionais,
            "flavors" => $itensOrderFlavors,
            "optional" => $itensOrderOptionalItems
        ]);
    }

    public function myRequestAjax(?array $data): void
    {
        $transaction_key = $data['token'];
        $orders = (new Orders())->findCustom(
            "SELECT
                    u.id, u.enterprise_id, 
                    u.total_orders,
                    u.payment,
                    u.status,
                    u.send,
                    e.client,
                    e.whatsapp FROM
                    orders u, clients e WHERE 
                    u.client_id = e.id  
                AND u.transaction_key = '$transaction_key'
                    "
        )->fetch(true);

        $orderId = $orders[0]->id;

        $order = (new Orders())->find("id = :di", "di={$orderId}")->fetch();
        $items = (new OrdersItems())->has(Products::class, "product_id")->find("order_id = :p", "p={$orderId}")->fetch(true);
        $client = (new Clients())->find("id = :di", "di={$order->client_id}")->fetch();
        $itensOrderAdittionais = (new CartItems())->inner(Additional::class, "product_id")->find("order_id = :p AND category_items = :ad", "p={$orderId}&ad=A")->fetch(true);
        $itensOrderFlavors = (new CartItems())->inner(Flavors::class, "product_id")->find("order_id = :p AND category_items = :ad", "p={$orderId}&ad=S")->fetch(true);
        $itensOrderOptionalItems = (new CartItems())->inner(Options::class, "product_id")->find("order_id = :p AND category_items = :ad", "p={$orderId}&ad=O")->fetch(true);

        $head = $this->seo->render(
            CONF_SITE_NAME . " - " . CONF_SITE_TITLE,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg")
        );

        echo $this->view->render("my-request-ajax", [
            "head" => $head,
            "order" => $orders,
            "orders" => $order,
            "client" => $client,
            "items" => $items,
            "additionals" => $itensOrderAdittionais,
            "flavors" => $itensOrderFlavors,
            "optional" => $itensOrderOptionalItems
        ]);
    }

    public function requestObservation(?array $data): void
    {
        echo $data['observation'];
        $data['id'] = $_SESSION['product_id']; //ADICIONADO PARA TESTE
        $_SESSION['requestobservation'] = $data['observation'];
    }


    /*
     * APLICA CUPOM DE DESCONTO
     */
    public function applyCoupom(?array $data): void
    {

        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $data["total"] = str_replace(",", ".", $data["total"]);


        //LER A TABELA DE RELACIONADOS
        $relatedCoupon = (new EnterprisesCoupons())->findCustom("SELECT
	enterprises_coupons.coupon_id, 
	enterprises_coupons.enterprise_id, 
	coupons.minimum, 
	coupons.id, 
	coupons.minimum_price, 
	coupons.disconunt, 
	coupons.amount, 
	coupons.`name`, 
	coupons.maximum, 
	coupons.maximum_discount
FROM
	enterprises_coupons,
	coupons
WHERE
	coupons.`status` = 'active' AND
	DATE(coupons.end_date) >= NOW() AND
	enterprises_coupons.coupon_id = {$data["couponId"]} AND
	enterprises_coupons.enterprise_id = {$data["enterpriseId"]}")->fetch();

        //PRIMEIRA REGRA - EMPRESA N??O CADASTRADA NO CUPOM
        if (!$relatedCoupon) {
            $json["message"] = "Opss. Este cupom de desconto n??o est?? dispon??vel para esta empresa.";
            echo json_encode($json);
            return;
        }

        //VERIFICA VALOR M??NIMO
        if ($data["total"] < $relatedCoupon->minimum_price) {
            $json["message"] = "O valor do seu pedido ?? inferior ao m??nimo exigido para ativar o cupom.";
            echo json_encode($json);
            return;
        }

        //VERIFICA A QUANTIDADE DE USO DO CUPOM
        $coupomAmount = $this->updateCoupmAmount($relatedCoupon->id);

        if (!$coupomAmount) {
            $json["message"] = "Opss. Quantidade de uso deste cupom foi esgotada.";
            echo json_encode($json);
            return;
        }

        //REGRA VERIFICAR O VALOR M??NIMO E M??XIMO SE ESTIVER ATIVADO
        if ($relatedCoupon->minimum == 'yes') {
            //VERIFICA VALOR M??NIMO
            if ($data["total"] < $relatedCoupon->minimum_price) {
                $json["message"] = "O valor do seu pedido ?? inferior ao m??nimo exigido para ativar o cupom.";
                echo json_encode($json);
                return;
            }

            if ($data["total"] >= $relatedCoupon->minimum_price) {
                //FAZ O C??LCULO DA PORCENTAGEM
                $calculeDiscount = round(($data["total"] * $relatedCoupon->disconunt) / 100, 2);

                //VERIFICA SE O M??XIMO DESCONTO EST?? ATIVADO
                if ($relatedCoupon->maximum == 'yes') {
                    if ($calculeDiscount >= $relatedCoupon->maximum_discount) {
                        $applyDiscont = round($data["total"] - $relatedCoupon->maximum_discount, 2);
                        $json["discount"] = $relatedCoupon->maximum_discount;
                        $json["price"] = $applyDiscont;
                        $json["couponId"] = $relatedCoupon->id;
                        $json["coupon"] = $relatedCoupon->name;
                        echo json_encode($json);
                        return;
                    } else {
                        $applyDiscont = round($data["total"] - $calculeDiscount, 2);
                        $json["discount"] = $calculeDiscount;
                        $json["price"] = $applyDiscont;
                        $json["couponId"] = $relatedCoupon->id;
                        $json["coupon"] = $relatedCoupon->name;
                        echo json_encode($json);
                        return;
                    }
                } else {
                    //SE O M??XIMO N??O ESTIVER ATIVADO
                    $applyDiscont = round($data["total"] - $calculeDiscount, 2);
                    $json["discount"] = $calculeDiscount;
                    $json["price"] = $applyDiscont;
                    $json["couponId"] = $relatedCoupon->id;
                    $json["coupon"] = $relatedCoupon->name;
                    echo json_encode($json);
                    return;
                }
            }


        }
    }

    /*
    * ALTERA O STATUS DO PEDIDO DIRETO DA P??GINA DE LISTAGEM DE PEDIDOS
    */
    public function listRequestEnterprise(?array $data): void
    {

        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $enterpriseId = base64_decode($data["enterprise_id"]);
        $request = (new Orders())->find("enterprise_id = :di AND status != :s ", "di={$enterpriseId}&s=4");
        $head = $this->seo->render(
            CONF_SITE_NAME . " Meus pedidos ",
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg")
        );

        echo $this->view->render("enterprise", [
            "head" => $head,
            "request" => $request->order("status ASC, created DESC")->fetch(true)
        ]);

    }

    //VERIFICA SE EST?? DISPO??VEL A QUANTIDADE
    public function updateCoupmAmount($couponId): bool
    {

        $checkQuantity = (new Coupons())->find("id = :di", "di={$couponId}")->fetch();
        if ($checkQuantity->amount == 0) {
            return false;
        } else {
            $checkQuantity->amount -= 1;
            $checkQuantity->save();
            return true;
        }
    }


    /*
 * ALTERA O STATUS DO PEDIDO
 */
    public function changeStatusMobile(?array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        if (!empty($data)) {
            $orderUpdate = (new Orders())->findById($data["order"]);
            $enterprise = (new Enterprises)->find("id = :di", "di={$orderUpdate ->enterprise_id}", "enterprise")->fetch();

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
            $json["clientPhone"] = $orderUpdate->whatsapp;
            $json["message"] = messageStatusNotification($data["status"]);
            $json["enterprise"] = $enterprise->enterprise;
            echo json_encode($json);
            return;
        }
    }


    //LISTA PARA O USU??RIO OS PEDIDOS
    public function allRequestClient(?array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $client = base64_decode($data['client_id']);
        $client = filter_var($client, FILTER_VALIDATE_INT);
        $orders = (new Orders())->findCustom("SELECT
	orders.id, 
	orders.client, 
	orders.client_id, 
	orders.created, 
	orders.total_orders, 
	orders.transaction_key, 
	enterprises.enterprise,
	enterprises.phone
FROM
	orders
	INNER JOIN
	enterprises
	ON 
		orders.enterprise_id = enterprises.id
WHERE
	orders.client_id = {$client}
	");
        $pager = new Pager(url("/meus-pedidos/" . base64_encode($client)) . "/");
        $pager->pager($orders->count(), 10, (!empty($data["p"]) ? $data["p"] : 1));


        $head = $this->seo->render(
            CONF_SITE_NAME . " Meus pedidos ",
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg")
        );

        echo $this->view->render("all-request", [
            "head" => $head,
            "orders" => $orders->order("id DESC")->limit($pager->limit())->offset($pager->offset())->fetch(true),
            "paginator" => $pager->render(),
            "clientId" => $client,
        ]);

    }

    //CRIA A AVALIA????O

    public function evaluation(?array $data): void
    {

        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        if (!$data["csrf"]) {
            die();
        }

        if (empty($data["evaluation"])) {
            $json["message"] = "Opss. Voc?? deve ter esquecido de avaliar o pedido";
            echo json_encode($json);
            return;
        }
        $create = new Evaluation();
        $create->evaluation = $data["evaluation"];
        $create->client_id = $data["client_id"];
        $create->order_id = $data["order_id"];
        $create->created = date("Y-m-d H:i:s");

        if (!$create->save()) {
            $json["message"] = "Erro ao salvar pedido";
            echo json_encode($json);
            return;
        }
        $client = (new Clients())->findById($create->client_id, "client");
        $json["success"] = "Sua avalia????o foi salva com sucesso e enviada a loja {$data["enterprise"]}.";
        $json["phone"] = $data["enterprise_phone"];
        $json["slug"] = $data["enterprise"];
        $json["answer"] = $create->evaluation;
        $json["numberOrder"] = $create->order_id;
        $json["client"] = $client->client;
        echo json_encode($json);
    }

    public function checkEvaluation(?array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $evaluation = (new Evaluation())->find("order_id = :d", "d={$data["orderId"]}")->fetch();

        echo $this->view->render("modal-evaluation", [
            "head" => "",
            "evaluation" => $evaluation ?? null
        ]);

    }

    public function feed(?array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $feed = (new Feed())->feed($data['slug_city'], 30);


        $head = $this->seo->render(
            CONF_SITE_NAME . " Feed ",
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg")
        );

        echo $this->view->render("feed", [
            "head" => $head,
            "city" => $data["slug_city"],
            "feed" => $feed
        ]);
    }

    public function like(?array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $enterprise = (new Enterprises())->find("slug = :s", "s={$data['enterpriseSlug']}", "enterprise, phone")->fetch();
        $clientId = base64_decode($data["client"]);
        $client = (new Clients())->findById($clientId, "client");

        $json["client"] = $client->client;
        $json["enterprise"] = $enterprise->enterprise;
        $json["phone"] = $enterprise->phone;
        echo json_encode($json);

    }


    public function register(?array $data): void
    {

        $head = $this->seo->render(
            CONF_SITE_NAME . " Realizar cadastro no conv??nio",
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg")
        );
        echo $this->view->render("register", [
            "head" => $head,
        ]);
    }



    public function createFriend(?array $data): void
    {
        //create
        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $data["document"] = preg_replace('/[^0-9]/', '', $data["document"]);
            $data["whatsapp"] = preg_replace('/[^0-9]/', '', $data["whatsapp"]);

            if (!$data["csrf"]) {
                die();
            }
            if (!validadeDocumentClient($data["document"])) {
                $json["error"] = true;
                echo json_encode($json);
                return;
            }

            $client = (new Clients())->findByDocument($data["document"]);

            if ($client) {
                $client->friend = "friend";
                $client->save();
                $json["friend"] = true;
            } else {
                $client = new Clients();
                $client->client = $data["client"];
                $client->document = $data["document"];
                $client->whatsapp = $data["whatsapp"];
                $client->friend = $data["friend"];
                $client->friend = $data["friend"];
                $client->save();
                $json["friend"] = true;
            }
            echo json_encode($json);
        }

    }
}


