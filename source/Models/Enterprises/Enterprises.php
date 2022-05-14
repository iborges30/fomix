<?php

namespace Source\Models\Enterprises;

use Source\Core\Model;
use Source\Models\ProductCategories\ProductCategories;

/**
 * Class Channel
 * @package Source\Models\Enterprises
 */
class Enterprises extends Model
{
    /**
     * Channel constructor.
     */
    public function __construct()
    {
        parent::__construct("enterprises", ["id"], ["enterprise", "document_enterprise"]);
    }


    /*
    *POLIMORFISMO DO METODO SAVE
    */
    public function save(): bool
    {
        if (
            !$this->checkDuplicateDocumentEnterprise() or
            !parent::save()
        ) {
            return false;
        }
        $this->checkUri();
        return true;
    }


    //EVITA A DUPLICIDADE
    protected function checkDuplicateDocumentEnterprise(): bool
    {
        $check = null;

        if (!$this->id) {
            $check = $this->find("document_enterprise = :c", "c={$this->document_enterprise}")->count();
        } else {
            $check = $this->find("document_enterprise = :c AND id != :di ", "c={$this->document_enterprise}&di={$this->id}")->count();
        }

        if ($check) {
            $this->message->warning("Ooops! esta Empresa já foi cadastrado anteriormente")->render();
            return false;
        }

        return true;
    }

    /*
    * EVITA QUE A slug seja duplicada
    */

    public function checkUri(): bool
    {
        $checkUri = (new Enterprises())->find("slug = :uri AND id != :id", "uri={$this->slug}&id={$this->id}");

        if ($checkUri->count()) {
            $this->slug = "{$this->slug}-{$this->lastId()}";
        }

        return parent::save();
    }



    public function enterpriseAll(string $slugCity){
        $enterprises = (new Enterprises())->findCustom("SELECT
	enterprises.enterprise, 
	enterprises.views, 
	enterprises.slug, 
	enterprises.image, 
	enterprises.delivery_fee, 
	enterprises.time_delivery, 
	enterprises.city, 
	shop_opens.status 
FROM
	enterprises
	INNER JOIN
	shop_opens
	ON 
		enterprises.id = shop_opens.enterprise_id
WHERE
	enterprises.slug_city = :p AND
	enterprises.status = :s", "s=active&p={$slugCity}");

        return $enterprises;
    }
}
