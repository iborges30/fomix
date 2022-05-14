<?php
namespace Source\App\Admin;

use Source\Core\Session;
use Source\Models\Auth;
use Source\Models\Enterprises\Enterprises;
use Source\Models\User;
use Source\Support\Pager;
use Source\Support\Thumb;
use Source\Support\Upload;

class AdminMaster extends Admin{
    public function __construct()
    {
        parent::__construct();
        $this->user = Auth::user();
        if($this->user->level < 5){
            $this->message->error("Você não tem permissão para acessar essa área do sistema.")->flash();
            redirect("/admin/dash/home");
            return;
        }
    }
    public function home(?array $data): void
    {
        $enterprises = (new Enterprises())->find();
        $pager = new Pager(url("/admin/enterprise/home/"));
        $pager->pager($enterprises->count(), 20, (!empty($data["page"]) ? $data["page"] : 1));

        $head = $this->seo->render(
            CONF_SITE_NAME . " Minhas empresas ",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/enterprises/home", [
            "app" => "enterprises/home",
            "head" => $head,
            "enterprise" => $enterprises->order("slug DESC")->limit($pager->limit())->offset($pager->offset())->fetch(true),
            "paginator" => $pager->render()
        ]);
    }
    

    public function enterprises(?array $data): void
    {

        //CREATE
        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $data["document"] = preg_replace('/[^0-9]/', '', $data["document"]);
            $data["document_enterprise"] = preg_replace('/[^0-9]/', '', $data["document_enterprise"]);
            $data["phone"] = preg_replace('/[^0-9]/', '', $data["phone"]);

            //VERIFICA DOCUMENTO USUÁRIO
            if (empty($data['document']) || !validadeDocumentClient($data['document'])) {
                $json["message"] = $this->message->error("O CPF informado não é válido")->render();
                echo json_encode($json);
                return;
            }

            //VERIFICA DOCUMENTO EMPRESA
            if (empty($data['document_enterprise']) || !validateCnpj($data['document_enterprise'])) {
                $json["message"] = $this->message->warning("O CNPJ informado não é válido")->render();
                echo json_encode($json);
                return;
            }

            //VERIFICA E-MAIL

            $userEmail = (new User())->find("email  = :m", "m={$data['email']}")->fetch();
            if ($userEmail) {
                $json["message"] = $this->message->warning("O E-mail informado já foi cadastrado em nosso sistema. Informe outro.")->render();
                echo json_encode($json);
                return;
            }

            //CADASTRA A EMPRESA
            $createEnterprise = new Enterprises();
            $createEnterprise->enterprise = $data["enterprise"];
            $createEnterprise->slug = str_slug($data["enterprise"]);
            $createEnterprise->document_enterprise = $data["document_enterprise"];
            $createEnterprise->zip_code = $data["zip_code"];
            $createEnterprise->city = $data["city"];
            $createEnterprise->slug_city = str_slug($data["city"]);
            $createEnterprise->state = $data["state"];
            $createEnterprise->phone = $data["phone"];
            $createEnterprise->address = $data["address"];
            $createEnterprise->district = $data["district"];
            $createEnterprise->number = $data["number"];
            $createEnterprise->complement = $data["complement"];
            $createEnterprise->status = 'active';

            if (!$createEnterprise->save()) {
                $json["message"] = $createEnterprise->message()->render();
                echo json_encode($json);
                return;
            } else {
                
                //CADASTRA O USUÁRIO
                $create = new User();
                $create->first_name = $data["first_name"];
                $create->last_name = $data["last_name"];
                $create->document = $data["document"];
                $create->email = $data["email"];
                $create->password = $data["password"];
                $create->status = 'confirmed';
                $create->level = 4;
                $create->enterprise_id = $createEnterprise->id;
                $create->created_at = date("Y-m-d H:i:s");

                if (!empty($_FILES["image"])) {
                    $files = $_FILES["image"];
                    $upload = new Upload();
                    $image = $upload->image($files, $createEnterprise->enterprise);

                    if (!$image) {
                        $json["message"] = $upload->message()->render();
                        echo json_encode($json);
                        return;
                    }

                    $createEnterprise->image = $image;
                }

                if (!$create->save()) {
                    $json["message"] = $create->message()->render();
                    echo json_encode($json);
                    return;
                }
                $this->message->success("Empresa cadastrada com sucesso.")->flash();
                echo json_encode(["redirect" => url("/admin/enterprise/home")]);
            }

            return;
        }

        //UPDATE
        $update = null;
        if (!empty($data["id"])) {
            $entepriseId = filter_var($data["id"], FILTER_VALIDATE_INT);
            $update = (new Enterprises())->find("id = :di", "di={$entepriseId}")->fetch();
        }

        $head = $this->seo->render(
            CONF_SITE_NAME . " Nova empresa ",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/enterprises/enterprises", [
            "app" => "enterprises/home",
            "head" => $head,
            "enterprise" => $update
        ]);
    }
    


    public function update(?array $data): void
    {
        //ATUALIZA FLAVOR
        if (!empty($data["action"]) && $data["action"] == "update") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $entepriseId = filter_var($data["id"], FILTER_VALIDATE_INT);

            $data["document_enterprise"] = preg_replace('/[^0-9]/', '', $data["document_enterprise"]);
            $data["phone"] = preg_replace('/[^0-9]/', '', $data["phone"]);

            $update = (new Enterprises())->find("id = :di", "di={$entepriseId}")->fetch();

            if (!$update) {
                $this->message->error("Você tentou editar um item que não existe no sistema")->flash();
                echo json_encode(["redirect" => url("/admin/enterprise/home")]);
                return;
            }

            //CADASTRA A EMPRESA
            $update->enterprise = $data["enterprise"];
            $update->slug = str_slug($data["enterprise"]);
            $update->document_enterprise = $data["document_enterprise"];
            $update->zip_code = $data["zip_code"];
            $update->city = $data["city"];
            $update->slug_city = str_slug($data["city"]);
            $update->state = $data["state"];
            $update->phone = $data["phone"];
            $update->address = $data["address"];
            $update->district = $data["district"];
            $update->number = $data["number"];
            $update->complement = $data["complement"];
            $update->status = $data["status"];

            //upload cover
            if (!empty($_FILES["image"])) {
                $files = $_FILES["image"];
                $upload = new Upload();
                $image = $upload->image($files, $update->enterprise);

                if (!$image) {
                    $json["message"] = $upload->message()->render();
                    echo json_encode($json);
                    return;
                }
                $update->image = $image;
            }

            if (!$update->save()) {
                $json["message"] = $update->message()->render();
                echo json_encode($json);
                return;
            }

            $json["message"] = $this->message->success("Emrpesa atualizada com sucesso...")->render();
            echo json_encode($json);
            return;
        }
    }


    /*
     * DELETA EMPRESA E SEUS USUÁRIOS
     */
    public function delete(?array $data): void
    {
        if (!empty($data["action"]) && $data["action"] == "delete") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $entenprise = (new Enterprises())->findById($data["id"]);

            if (!$entenprise) {
                $this->message->error("Você tentou remover uma empresa que não existe ou já foi removida do sistema.")->flash();
                echo json_encode(["redirect" => url("/admin/enterprise/home")]);
                return;
            }

            //DELETA A IMAGEM DA EMPRESA
            if ($entenprise->image && file_exists(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$entenprise->image}")) {
                unlink(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$entenprise->image}");
                (new Thumb())->flush($entenprise->image);
            }

            //DELETA USUÁRIOS DA EMPRESA
            $user = (new User())->find("enterprise_id = :en", "en={$entenprise->id}")->fetch(true);
            foreach ($user as $p) {
                $p->destroy();
            }

            $entenprise->destroy();
            $this->message->success("Empresa excluída com sucesso...")->flash();
            echo json_encode(["redirect" => url("/admin/enterprise/home")]);
            return;
        }
    }
    

    /* LISTA OS USUÁRIOS DA EMPRESA */

    public function users(? array $data):void{

        $users = (new User)->find( "enterprise_id = :di", "di={$data['enterprise_id']}");
        $pager = new Pager(url("/admin/enterprise/users/{$data['enterprise_id']}/"));
        $pager->pager($users->count(), 8, (!empty($data["page"]) ? $data["page"] : 1));

        $head = $this->seo->render(
            CONF_SITE_NAME . " Meus usuários ",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/enterprises/users", [
            "app" => "enterprises/home",
            "head" => $head,
            "users"=>$users->order("first_name ASC")->limit($pager->limit())->offset($pager->offset())->fetch(true),
            "paginator" => $pager->render()
        ]);

    }
    public function restaurant():void{
        $interpriseId = user()->enterprise_id;
        $interprise = (new Enterprises)->findById($interpriseId);
        //var_dump($interprise);
        $head = $this->seo->render(
            CONF_SITE_NAME . " Meus Dados ",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/enterprises/restaurant", [
            "app" => "enterprises/home",
            "head" => $head,
            "enterprise" => $interprise
           // "users"=>$users->order("first_name ASC")->limit($pager->limit())->offset($pager->offset())->fetch(true),
           // "paginator" => $pager->render()
        ]);
    }
}