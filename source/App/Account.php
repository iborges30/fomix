<?php

namespace Source\App;


use Source\Core\Controller;
use Source\Models\Enterprises\Enterprises;
use Source\Models\User;

class Account extends Controller
{
    /**
     * Web constructor.
     */
    public function __construct()
    {
        parent::__construct(__DIR__ . "/../../themes/" . CONF_VIEW_THEME . "/");
    }

    /**
     * CONTA DE USUÁRIO
     */
    public  function account(?array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $data["document"] = preg_replace('/[^0-9]/', '', $data["document"]);
        $data["document_enterprise"] = preg_replace('/[^0-9]/', '', $data["document_enterprise"]);



        if (empty($data['csrf'])) {
            echo "Requisição inválida";
            die();
        }

        //VALIDA CAMPOS EM BRANCO
        if (in_array('', $data)) {
            $json['message'] = "Oppss. Você deve ter deixado algum campo em branco.";
            echo  json_encode($json);
            return;
        }

        //VERIFICA DOCUMENTO
        if (empty($data['document']) || !validadeDocumentClient($data['document'])) {
            $json['message'] = "Atenção. O CPF informado não é válido.";
            echo  json_encode($json);
            return;
        }


        //VERIFICA DOCUMENTO
        if (empty($data['document_enterprise']) || !validateCnpj($data['document_enterprise'])) {
            $json['message'] = "Atenção. O CNPJ informado não é válido.";
            echo  json_encode($json);
            return;
        }


        //PRECISA FAZER UMA VALIDAÇÃO EM RELAÇÃO AO CNPJ E A SLUG


        //CADASTRA A EMPRESA
        $createEnterprise = new Enterprises();
        $createEnterprise->enterprise = $data["enterprise"];
        $createEnterprise->slug = str_slug($data["enterprise"]);
        $createEnterprise->document_enterprise = $data["document_enterprise"];
        $createEnterprise->zip_code = $data["zip_code"];
        $createEnterprise->city = $data["city"];
        $createEnterprise->state = $data["state"];

        if (!$createEnterprise->save()) {
            $json["message"] = $createEnterprise->message()->render();
            echo json_encode($json);
            return;
        } else {

            //CADASTRA O USUÁRIO
            $create =  new User();
            $create->first_name = $data["first_name"];
            $create->last_name = $data["last_name"];
            $create->document = $data["document"];
            $create->email = $data["email"];
            $create->password = $data["password"];
            $create->status = 'confirmed';
            $create->level = 4;
            $create->enterprise_id = $createEnterprise->id;
            $create->created_at = date("Y-m-d H:i:s");

            if (!$create->save()) {
                $json["message"] = $create->message()->render();
                echo json_encode($json);
                return;
            }
            $json["success"] = true;
            echo json_encode($json);
        }
    }
}
