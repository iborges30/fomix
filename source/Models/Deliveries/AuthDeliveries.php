<?php


namespace Source\Models\Deliveries;


use Source\Core\Model;
use Source\Core\Session;

class AuthDeliveries extends Model
{

    public function __construct()
    {
        parent::__construct("deliveries", ["id"], ["document", "password"]);
    }

    public static function Delivery(): ?Deliveries
    {
        $session = new Session();
        if (!$session->has("authDelivery")) {
            return null;
        }

        return (new Deliveries())->findById($session->authDelivery);
    }


    /**
     * log-out
     */
    public static function logout(): void
    {
        $session = new Session();
        $session->unset("authDelivery");
    }


    public function attempt(string $document, string $password, string $status = 'active'): ?Deliveries
    {

        if (!is_passwd($password)) {
            $this->message->warning("A senha informada não é válida");
            return null;
        }

        $user = (new Deliveries())->findByDocument($document);

        if (!$user) {
            $this->message->error("O CPF informado não está cadastrado");
            return null;
        }

        if (!passwd_verify($password, $user->password)) {
            $this->message->error("A senha informada não confere");
            return null;
        }

        if ($user->staus != 'active') {
            $this->message->error("Desculpe, mas você não tem permissão para logar-se aqui");
            return null;
        }

        if (passwd_rehash($user->password)) {
            $user->password = $password;
            $user->save();
        }

        return $user;
    }

    public function login(string $document, string $password, bool $save = false, string $status = 'active'): bool
    {
        $user = $this->attempt($document, $password, $status);
        if (!$user) {
            return false;
        }

        if ($save) {
            setcookie("authEmailDelivery", $document, time() + 604800, "/");
        } else {
            setcookie("authEmailDelivery", null, time() - 3600, "/");
        }

        //LOGIN
        (new Session())->set("authDelivery", $user->id);
        return true;
    }
}