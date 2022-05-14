<?php


namespace Source\App\Admin;

use Source\Core\Session;
use Source\Models\Auth;
use Source\Models\Enterprises\Enterprises;
use Source\Models\User;
use Source\Support\Pager;
use Source\Support\Thumb;
use Source\Support\Upload;

class EnterpriseController extends Admin
{
    public function __construct()
    {
        parent::__construct();
        $this->user = Auth::user();
        if($this->user->level < 4){
            $this->message->error("Você não tem permissão para acessar essa área do sistema.")->flash();
            redirect("/admin/dash/home");
            return;
        }
    }

    /*
     * LISTA TODAS AS EMPRESAS
     */
    
    public function update(?array $data): void
    {
        //ATUALIZA FLAVOR
        if (!empty($data["action"]) && $data["action"] == "update") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $entepriseId = user()->enterprise_id;

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
            //$update->status = $data["status"];

            //upload cover
            if (!empty($_FILES["image"])) {

                if ($update->image && file_exists(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$update->image}")) {
                    unlink(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$update->image}");
                    (new Thumb())->flush($update->image);
                }

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


    public function listuser():void{

        $enterprise_id = user()->enterprise_id;
        $listUsers = (new User)->find( "enterprise_id = :di", "di={$enterprise_id}")->fetch(true);
        
        $head = $this->seo->render(
            CONF_SITE_NAME . " | Listar Usuários ",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );
        echo $this->view->render("widgets/enterprises/listusers", [
            "app" => "",
            "head" => $head,
            "listUsers" => $listUsers
           // "users"=>$users->order("first_name ASC")->limit($pager->limit())->offset($pager->offset())->fetch(true),
           // "paginator" => $pager->render()
        ]);
    }

    public function dataEditUser(? array $data):void{
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
           
        $idUser = base64_decode($data['iduser']);
        $datauser = (new User)->findById($idUser);
        $head = $this->seo->render(
            CONF_SITE_NAME . "| Editar Usuário ",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );
        echo $this->view->render("widgets/enterprises/updateuser", [
            "app" => "",
            "head" => $head,
            "user" => $datauser
           // "users"=>$users->order("first_name ASC")->limit($pager->limit())->offset($pager->offset())->fetch(true),
           // "paginator" => $pager->render()
        ]);
    }
    public function viewUser():void{
        $head = $this->seo->render(
            CONF_SITE_NAME . " | Novo Usuário ",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );
        echo $this->view->render("widgets/enterprises/createuser", [
            "app" => "",
            "head" => $head
        ]);
    }
    public function createUser(?array $data): void
    {
        //create
        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $userCreate = new User();
            $userCreate->first_name = $data["first_name"];
            $userCreate->last_name = $data["last_name"];
            $userCreate->email = $data["email"];
            $userCreate->password = $data["password"];
            $userCreate->level = $data["level"];
            $userCreate->genre = $data["genre"];
            $userCreate->datebirth = date_fmt_back($data["datebirth"]);
            $userCreate->document = preg_replace("/[^0-9]/", "", $data["document"]);
            $userCreate->status = $data["status"];
            $userCreate->enterprise_id = user()->enterprise_id;

            //upload photo
            if (!empty($_FILES["photo"])) {
                $files = $_FILES["photo"];
                $upload = new Upload();
                $image = $upload->image($files, $userCreate->fullName(), 600);

                if (!$image) {
                    $json["message"] = $upload->message()->render();
                    echo json_encode($json);
                    return;
                }

                $userCreate->photo = $image;
            }

            //VERIFICA DOCUMENTO USUÁRIO
            if (empty($data['document']) || !validadeDocumentClient($data['document'])) {
                $json["message"] = $this->message->error("O CPF informado não é válido")->render();
                echo json_encode($json);
                return;
            }

            if (!$userCreate->save()) {
                $json["message"] = $userCreate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Usuário cadastrado com sucesso...")->flash();
            $json["redirect"] = url("/admin/enterprise/list/users");

            echo json_encode($json);
            return;
        }
    }
    public function updateUser(?array $data): void
    {
        $enterpriseId = user()->enterprise_id;
        //ATUALIZA FLAVOR
        if (!empty($data["action"]) && $data["action"] == "update") {

            $userId = filter_var($data["user_id"], FILTER_VALIDATE_INT);
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $userUpdate = (new User())->find("id = :di AND enterprise_id = :en", "di={$userId}&en={$enterpriseId}")->fetch();

            if (!$userUpdate) {
                $this->message->error("Você tentou gerenciar um usuário que não existe")->flash();
                echo json_encode(["redirect" => url("/admin/enterprise/users/{$enterpriseId}")]);
                return;
            }

            //VERIFICA DOCUMENTO USUÁRIO
            if (empty($data['document']) || !validadeDocumentClient($data['document'])) {
                $json["message"] = $this->message->error("O CPF informado não é válido")->render();
                echo json_encode($json);
                return;
            }


            $userUpdate->first_name = $data["first_name"];
            $userUpdate->last_name = $data["last_name"];
            $userUpdate->email = $data["email"];
            $userUpdate->password = (!empty($data["password"]) ? $data["password"] : $userUpdate->password);
            $userUpdate->level = $data["level"];
            $userUpdate->genre = $data["genre"];
            $userUpdate->datebirth = date_fmt_back($data["datebirth"]);
            $userUpdate->document = preg_replace("/[^0-9]/", "", $data["document"]);
            $userUpdate->status = $data["status"];

            //upload photo
            if (!empty($_FILES["photo"])) {
                if ($userUpdate->photo && file_exists(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$userUpdate->photo}")) {
                    unlink(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$userUpdate->photo}");
                    (new Thumb())->flush($userUpdate->photo);
                }

                $files = $_FILES["photo"];
                $upload = new Upload();
                $image = $upload->image($files, $userUpdate->fullName(), 600);

                if (!$image) {
                    $json["message"] = $upload->message()->render();
                    echo json_encode($json);
                    return;
                }

                $userUpdate->photo = $image;
            }

            if (!$userUpdate->save()) {
                $json["message"] = $userUpdate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Usuário atualizado com sucesso...")->flash();
            echo json_encode(["reload" => true]);
            return;
        }
       
    }
    public function updateCover(?array $data):void{
         //upload photo
         $enterpriseId = user()->enterprise_id;
         $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
         $update = (new Enterprises())->find("id = :di", "di={$enterpriseId}")->fetch();

         if (!$update) {
             $this->message->error("Você tentou editar um item que não existe no sistema")->flash();
             echo json_encode(["redirect" => url("/admin/enterprise/home")]);
             return;
         }

            //upload cover
            if (!empty($_FILES["imagecover"])) {

                if ($update->cover && file_exists(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$update->cover}")) {
                    unlink(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$update->cover}");
                    (new Thumb())->flush($update->cover);
                }

                $files = $_FILES["imagecover"];
                $upload = new Upload();
                $image = $upload->image($files, 'cover-'.$update->enterprise);

                if (!$image) {
                    $json["message"] = $upload->message()->render();
                    echo json_encode($json);
                    return;
                }
                $update->cover = $image;
            }

            if (!$update->save()) {
                $json["message"] = $update->message()->render();
                echo json_encode($json);
                return;
            }

            $json["message"] = $this->message->success("Capa atualizada com sucesso...")->render();
            echo json_encode($json);
            return;
    }
    public function updateConfig($data):void
    {
        $enterpriseId = user()->enterprise_id;
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $update = (new Enterprises())->find("id = :di", "di={$enterpriseId}")->fetch();

        $update->delivery_fee = $data['delivery_fee'];
        $update->delivery_fee_max = $data['delivery_fee_max'];
        $update->time_delivery = $data['time_delivery'];
        $update->bit_rate = saveMoney($data['bit_rate']);
        $update->about_enterprises = $data['about_enterprises'];
        $update->save();

        if (!$update->save()) {
            $json["message"] = $update->message()->render();
            echo json_encode($json);
            return;
        }

        $json["message"] = $this->message->success("Dados atualizada com sucesso...")->render();
        echo json_encode($json);
        return;
    }


    public function freeDelivery(?array $data):void{
        $enterpriseId = user()->enterprise_id;
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $update = (new Enterprises())->find("id = :di", "di={$enterpriseId}")->fetch();

        $update->free_delivery = $data['free_delivery'];
        $update->minimum_amount_free_delivery = saveMoney($data['minimum_amount_free_delivery']);

        if (!$update->save()) {
            $json["message"] = $update->message()->render();
            echo json_encode($json);
            return;
        }

        $json["message"] = $this->message->success("Dados atualizada com sucesso...")->render();
        echo json_encode($json);
    }
    /*
     * DELETA EMPRESA E SEUS USUÁRIOS
     */
    public function delete(?array $data): void
    {
        if (!empty($data["action"]) && $data["action"] == "delete") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $entenprise = ((new User()))->findById($data["id"]);
            $enterpriseId = user()->enterprise_id;

            $count = (new User())->find("enterprise_id = :i AND level = :l", "i={$enterpriseId}&l=4", "*")->count();
            
            
            if ($count == 1 && $entenprise->level == 4) {
                $json["message"] = $this->message->warning("Você precisa de pelo menos um ADMINSTRADOR cadastrado.")->render();
                echo json_encode($json);
                return;
            }
            if (!$entenprise) {
                $json["message"] = $this->message->error("Você tentou remover uma empresa que não existe ou já foi removida do sistema.")->render();
                echo json_encode($json);
                echo json_encode(["redirect" => url("/admin/enterprise/list/users")]);
                return;
            }

            //DELETA A IMAGEM DA EMPRESA
            if ($entenprise->photo && file_exists(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$entenprise->photo}")) {
                unlink(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$entenprise->photo}");
                (new Thumb())->flush($entenprise->photo);
            }

            

            $entenprise->destroy();
            $this->message->success("Usuário excluído com sucesso...")->flash();
            //$json["message"] = $this->message->success("Empresa excluída com sucesso...")->render();
            //echo json_encode($json);
            echo json_encode(["redirect" => url("/admin/enterprise/list/users")]);
            return;
        }
    }



    //RETORNA A EMPRESA PELO ID DO USUÁRIO
    public function myenterprise():void{
        $enterpriseId = user()->enterprise_id;

        //UPDATE
        $update = null;
        $update = (new Enterprises())->find("id = :di", "di={$enterpriseId}")->fetch();
        $head = $this->seo->render(
            CONF_SITE_NAME . " | Minha Empresa ",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/enterprises/myenterprise", [
            "app" => "",
            "head" => $head,
            "enterprise" => $update
        ]);
    }



    /*
     * HABILITA A PARAMETRIZAÇÃO DE PRODUTOS
     */
    public function parameterizeProducts(?array $data):void{
        $enterpriseId = user()->enterprise_id;
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $update = (new Enterprises())->find("id = :di", "di={$enterpriseId}")->fetch();

        $update->parameterize_products = $data['parameterize_products'];
        $update->save();

        if (!$update->save()) {
            $json["message"] = $update->message()->render();
            echo json_encode($json);
            return;
        }
        $json["message"] = $this->message->success("Dados atualizada com sucesso...")->render();
        echo json_encode($json);
    }

}