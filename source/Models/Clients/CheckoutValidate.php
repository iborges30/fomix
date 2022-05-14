<?php
namespace Source\Models\Clients;

class CheckoutValidate
{
    protected $data = [];
    protected $message;

    public function __construct($data, $message)
    {
        $this->data = $data;
        $this->message = $message;
    }

    public function getErrorMessages()
    {
        $data = $this->data;
        $json = [];
        if (!csrf_verify($data)) {
            $json['message'] = $this->message->error("Erro ao enviar, favor use o formulário")->render();
            return json_encode($json);
        }

        //VERIFICA DOCUMENTO
        if (empty($data['document']) || !validadeDocumentClient($data['document'])) {
            $json['message'] = $this->message->warning("O CPF informado não é válido.")->render();
            return json_encode($json);
        }

        if (empty($data['client'])) {
            $json['message'] = $this->message->warning("Você não informou seu nome.")->render();
            return json_encode($json);
        }

        //WHATSAPP
        if (empty($data['whatsapp'])) {
            $json['message'] = $this->message->warning("Você precisa informar um número de WhatsApp.")->render();
            return json_encode($json);
        }

        //FORMA DE ENTREGA
        if (empty($data['sendOrders'])) {
            $json['message'] = $this->message->error("Você precisa informar uma forma de entrega.")->render();
            return json_encode($json);
        }


        if ($data['sendOrders'] == 'home') {
            if (empty($data["address"]) or empty($data["number"]) or empty($data["square"])) {
                $json['message'] = $this->message->error("Você deve ter esquecido de informar alguma informação referente ao seu endereço.")->render();
                return json_encode($json);
            }
        }

        if (empty($data['payment_method'])) {
            $json['message'] = $this->message->warning("Você não informou um método de pagamento.")->render();
            return json_encode($json);
        }
    }
}
