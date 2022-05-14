<?php


namespace Source\App;


use Source\Core\Controller;
use Source\Models\Auth;
use Source\Models\Deliveries\AuthDeliveries;
use Source\Models\Deliveries\Deliveries;
use Source\Models\DeliveriesEnterprise\DeliveriesEnterprise;
use Source\Models\Enterprises\Enterprises;
use Source\Models\Orders\Orders;
use Source\Models\Races\Races;
use Source\Support\Pager;

class AppDelivery extends Controller
{
    /**
     * Web constructor.
     */
    public function __construct()
    {
        parent::__construct(__DIR__ . "/../../themes/" . CONF_VIEW_DELIVERY . "/");

    }


    /*
     * FORMULÁRIO DE LOGIN
     */
    public function formLogin(): void
    {
        $head = $this->seo->render(
            CONF_SITE_NAME . " - LOGIN " . CONF_SITE_TITLE,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg")
        );
        echo $this->view->render("login", [
            "head" => $head,
        ]);
    }


    /*
 * AUTENTICAÇÃO
 */
    public function auth(?array $data): void
    {
        if (!empty($data["action"]) && $data["action"] == "login") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            if (empty($data['csrf'])) {
                echo "Requisição inválida";
                die();
            }

            /* $auth = new AuthDeliveries();
             $login = $auth->login($data["document"], $data["password"], true);
     */
            $login = (new Deliveries())->find("document = :doc AND status != :st", "doc={$data["document"]}&st=inactive")->fetch();

            if ($login) {
                $json["hash"] = base64_encode($login->id);
                echo json_encode($json);
            }
            if (!$login) {
                $json["message"] = "Os dados informados não conferem.";
                echo json_encode($json);
            }
        }
    }

    public function home(?array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $document = base64_decode($data["id"]);
        $delivery = $this->profileRace($document);


        //SE EXISTIR UMA CORRIDA ELE É REDIRECIONADO PARA OUTRA PÁGINA
        $race = (new Races())->find("deliveryman_id = :di AND status = :st", "di={$delivery->id}&st=accepted")->fetch();

        if ($race) {
            $id = base64_encode($delivery->id);
            redirect(url("/delivery/user/in_race/{$id}"));
            return;
        }

        $head = $this->seo->render(
            CONF_SITE_NAME . " - " . CONF_SITE_TITLE,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg")
        );
        echo $this->view->render("home", [
            "head" => $head,
            "delivery" => $delivery,
            "race" => $race ?? null
        ]);

    }


    //JOGA AS CORRIDAS DENTRO DA HOME
    public function getDeliveries(array $data): void
    {

        $deliveryId = $data["id"];
        $delivery = (new Deliveries())->findById(base64_decode($deliveryId));
        $deliveries = (new DeliveriesEnterprise())->findCustom("
        SELECT
	enterprises.enterprise, 
	enterprises.address,
	enterprises.number,
	enterprises.district,
	deliveries_enterprise.race_price, 
	deliveries_enterprise.arrival,
	deliveries_enterprise.observations,
	deliveries_enterprise.id

FROM
	deliveries_enterprise
	INNER JOIN
	enterprises
	ON 
		deliveries_enterprise.enterprise_id = enterprises.id
WHERE
    enterprises.slug_city = :city AND
	deliveries_enterprise.`status` = 'open'", "city={$delivery->slug_city}");


        echo $this->view->render("race", [
            "head" => "",
            "deliveries" => $deliveries->fetch(true),
            "deliveryId" => base64_decode($deliveryId)
        ]);
    }


    //ACEITA A CORRIDA
    public function raceAccept(?array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $deliveryEnterprise = (new DeliveriesEnterprise())->find("id = :di AND status = :st", "di={$data["idRace"]}&st=open")->fetch();

        //ALTERA O STATUS DA ENTREGA VINDO DA EMPRESA
        $deliveryEnterprise->status = 'in_race';
        $deliveryEnterprise->deliveryman_id = $data["deliveryId"];
        $deliveryEnterprise->save();

        //CRIA A CORRIDA NA TEBALA CORRIDA
        $race = new Races();
        $race->enterprise_id = $deliveryEnterprise->enterprise_id;
        $race->delivery_id = $data["idRace"];
        $race->price = $deliveryEnterprise->race_price;
        $race->deliveryman_id = $data["deliveryId"];
        $race->created = date("Y-m-d H:i:s");
        $race->status = 'accepted';
        $race->save();
    }


    public function inRace(?array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $data["id"] = base64_decode($data["id"]);
        $startRace = (new DeliveriesEnterprise())->findCustom("SELECT
	deliveries_enterprise.deliveryman_id, 
	deliveries_enterprise.arrival, 
	deliveries_enterprise.race_price, 
	deliveries_enterprise.`status`, 
	e.enterprise,
	e.address, 
	e.district, 
	e.number, 
	e.complement
FROM
	deliveries_enterprise 
	INNER JOIN
	enterprises e
	ON 
		deliveries_enterprise.enterprise_id = e.id
WHERE
	deliveries_enterprise.deliveryman_id = {$data["id"]} AND
	deliveries_enterprise.`status` = 'in_race'")->fetch();

        if (!$startRace) {
            redirect("/delivery/user/" . base64_encode($data["id"]));
        }

        $profile = $this->profileRace($data["id"]);


        echo $this->view->render("in_race", [
            "head" => "",
            "startRace" => $startRace,
            "delivery" => $profile
        ]);
    }


    /*
     * DADOS PARA COMPLETAR O CADASTRO NAS PÁGINAS
     */
    public function profileRace($id)
    {
        $deliverman = (new Deliveries())->findById($id);
        return $deliverman;
    }

    public function report(?array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $deliveryId = base64_decode($data["id"]);
        // $balance = (new Races())->find("deliveryman_id = :man AND status = :st", "man={$deliveryId}&st=finish")->fetch(true);
        $balance = (new Races())->findCustom(
            "SELECT
	races.`status`, 
	races.price, 
	enterprises.enterprise, 
	races.delivery_id
FROM
	races
	INNER JOIN
	enterprises
	ON 
		races.enterprise_id = enterprises.id
WHERE
	races.`status` = 'finish' AND
	races.deliveryman_id = {$deliveryId} "
        )->order("races.delivery_id DESC")->fetch(true);

        $total = 0;
        if ($balance) {
            foreach ($balance as $b) {
                $total += $b->price;
            }
        }

        echo $this->view->render("week", [
            "head" => "",
            "total" => $total ?? 0,
            "balance" => $balance
        ]);
    }


    public function statusDelivery(?array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $delivery = (new Deliveries())->findById($data["deliveryId"]);
        $delivery->status = $data["status"] == 'active' ? 'sleep' : 'active';
        $delivery->save();
        $json["success"] = true;
        echo json_encode($json);
    }

    public function historic(?array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $deliveryMan = base64_decode($data["id"]);
        $historic = (new Races())->inner(Enterprises::class, "enterprise_id")->find("deliveryman_id = :d", "d={$deliveryMan}");

        $pager = new Pager(url("/delivery/user/historic/{$data["id"]}/"));
        $pager->pager($historic->count(), 20, (!empty($data["page"]) ? $data["page"] : 1));

        echo $this->view->render("historic", [
            "head" => "",
            "historic" => $historic->order("created DESC, status DESC")->limit($pager->limit())->offset($pager->offset())->fetch(true),
            "paginator" => $pager->render()
        ]);
    }
}