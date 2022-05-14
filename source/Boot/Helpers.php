<?php

/**
 * ####################
 * ###   VALIDATE   ###
 * ####################
 */

/**
 * @param string $email
 * @return bool
 */
function is_email(string $email): bool
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * @param string $password
 * @return bool
 */
function is_passwd(string $password): bool
{
    if (password_get_info($password)['algo'] || (mb_strlen($password) >= CONF_PASSWD_MIN_LEN && mb_strlen($password) <= CONF_PASSWD_MAX_LEN)) {
        return true;
    }

    return false;
}

/**
 * ##################
 * ###   STRING   ###
 * ##################
 */

/**
 * @param string $string
 * @return string
 */
function str_slug(string $string): string
{
    $string = filter_var(mb_strtolower($string), FILTER_SANITIZE_STRIPPED);
    $formats = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]/?;:.,\\\'<>°ºª';
    $replace = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                 ';

    $slug = str_replace(
        ["-----", "----", "---", "--"],
        "-",
        str_replace(
            " ",
            "-",
            trim(strtr(utf8_decode($string), utf8_decode($formats), $replace))
        )
    );
    return $slug;
}

/**
 * @param string $string
 * @return string
 */
function str_studly_case(string $string): string
{
    $string = str_slug($string);
    $studlyCase = str_replace(
        " ",
        "",
        mb_convert_case(str_replace("-", " ", $string), MB_CASE_TITLE)
    );

    return $studlyCase;
}

/**
 * @param string $string
 * @return string
 */
function str_camel_case(string $string): string
{
    return lcfirst(str_studly_case($string));
}

/**
 * @param string $string
 * @return string
 */
function str_title(string $string): string
{
    return mb_convert_case(filter_var($string, FILTER_SANITIZE_SPECIAL_CHARS), MB_CASE_TITLE);
}

/**
 * @param string $text
 * @return string
 */
function str_textarea(string $text): string
{
    $text = filter_var($text, FILTER_SANITIZE_STRIPPED);
    $arrayReplace = ["&#10;", "&#10;&#10;", "&#10;&#10;&#10;", "&#10;&#10;&#10;&#10;", "&#10;&#10;&#10;&#10;&#10;"];
    return "<p>" . str_replace($arrayReplace, "</p><p>", $text) . "</p>";
}

/**
 * @param string $string
 * @param int $limit
 * @param string $pointer
 * @return string
 */
function str_limit_words(string $string, int $limit, string $pointer = "..."): string
{
    $string = trim(filter_var($string, FILTER_SANITIZE_SPECIAL_CHARS));
    $arrWords = explode(" ", $string);
    $numWords = count($arrWords);

    if ($numWords < $limit) {
        return $string;
    }

    $words = implode(" ", array_slice($arrWords, 0, $limit));
    return "{$words}{$pointer}";
}

/**
 * @param string $string
 * @param int $limit
 * @param string $pointer
 * @return string
 */
function str_limit_chars(string $string, int $limit, string $pointer = "..."): string
{
    $string = trim(filter_var($string, FILTER_SANITIZE_SPECIAL_CHARS));
    if (mb_strlen($string) <= $limit) {
        return $string;
    }

    $chars = mb_substr($string, 0, mb_strrpos(mb_substr($string, 0, $limit), " "));
    return "{$chars}{$pointer}";
}

/**
 * @param string $price
 * @return string
 */
function str_price(?string $price): string
{
    return number_format((!empty($price) ? $price : 0), 2, ",", ".");
}

/**
 * @param string|null $search
 * @return string
 */
function str_search(?string $search): string
{
    if (!$search) {
        return "all";
    }

    $search = preg_replace("/[^a-z0-9A-Z\@\ ]/", "", $search);
    return (!empty($search) ? $search : "all");
}

/**
 * ###############
 * ###   URL   ###
 * ###############
 */

/**
 * @param string $path
 * @return string
 */
function url(string $path = null): string
{
    if (strpos($_SERVER['HTTP_HOST'], "localhost")) {
        if ($path) {
            return CONF_URL_TEST . "/" . ($path[0] == "/" ? mb_substr($path, 1) : $path);
        }
        return CONF_URL_TEST;
    }

    if ($path) {
        return CONF_URL_BASE . "/" . ($path[0] == "/" ? mb_substr($path, 1) : $path);
    }

    return CONF_URL_BASE;
}

/**
 * @return string
 */
function url_back(): string
{
    return ($_SERVER['HTTP_REFERER'] ?? url());
}

/**
 * @param string $url
 */
function redirect(string $url): void
{
    header("HTTP/1.1 302 Redirect");
    if (filter_var($url, FILTER_VALIDATE_URL)) {
        header("Location: {$url}");
        exit;
    }

    if (filter_input(INPUT_GET, "route", FILTER_DEFAULT) != $url) {
        $location = url($url);
        header("Location: {$location}");
        exit;
    }
}

/**
 * ##################
 * ###   ASSETS   ###
 * ##################
 */

/**
 * @return \Source\Models\User|null
 */
function user(): ?\Source\Models\User
{
    return \Source\Models\Auth::user();
}

/**
 * @return \Source\Core\Session
 */
function session(): \Source\Core\Session
{
    return new \Source\Core\Session();
}

/**
 * @param string|null $path
 * @param string $theme
 * @return string
 */
function theme(string $path = null, string $theme = CONF_VIEW_THEME): string
{
    if (strpos($_SERVER['HTTP_HOST'], "localhost")) {
        if ($path) {
            return CONF_URL_TEST . "/themes/{$theme}/" . ($path[0] == "/" ? mb_substr($path, 1) : $path);
        }

        return CONF_URL_TEST . "/themes/{$theme}";
    }

    if ($path) {
        return CONF_URL_BASE . "/themes/{$theme}/" . ($path[0] == "/" ? mb_substr($path, 1) : $path);
    }

    return CONF_URL_BASE . "/themes/{$theme}";
}

/**
 * @param string $image
 * @param int $width
 * @param int|null $height
 * @return string
 */
function image(?string $image, int $width, int $height = null): ?string
{
    if ($image) {
        return url() . "/" . (new \Source\Support\Thumb())->make($image, $width, $height);
    }

    return null;
}

/**
 * @param string|null $image
 * @param string $alt
 * @param int $width
 * @param int|null $height
 * @param string|null $defaultImage
 * @param string|null $class
 * @param string|null $style
 * @return string
 */
function photo_img(
    ?string $image,
    string $alt,
    int $width,
    int $height = null,
    string $defaultImage = null,
    string $class = null,
    string $style = null
): string
{
    $defaultImage = (!empty($defaultImage) ? $defaultImage : CONF_IMAGE_NO_AVAILABLE_16BY9);
    $class = (!empty($class) ? ' class="' . $class . '"' : null);
    $style = (!empty($style) ? ' style="' . $style . '"' : null);
    $image = (!empty($image) ? image($image, $width, $height) : theme($defaultImage));

    return '<img src="' . $image . '" alt="' . $alt . '"' . $class . $style . '>';
}

function photo_shops(?string $image): string
{
    if ($image != null):
        return url('storage/' . $image);
    else:
        return url('themes/plus/assets/images/fomix-cinza.jpg');
    endif;

}

/**
 * @param string|null $image
 * @param int $width
 * @param int|null $height
 * @param string|null $defaultImage
 * @return string
 */
function photo_scr(?string $image, int $width, int $height = null, string $defaultImage = null): string
{
    $defaultImage = (!empty($defaultImage) ? $defaultImage : CONF_IMAGE_NO_AVAILABLE_16BY9);
    $image = (!empty($image) ? image($image, $width, $height) : theme($defaultImage));
    return $image;
}

/**
 * #################
 * ###   ALERT   ###
 * #################
 */

/**
 * @param string $message
 * @param string|null $class
 * @param string|null $style
 * @param string $htmlTag
 * @return string
 */
function alert_success(string $message, string $class = null, string $style = null, string $htmlTag = "div"): string
{
    $class = CONF_ALERT_MESSAGE . " " . CONF_ALERT_SUCCESS["class"] . (!empty($class) ? " {$class}" : null);
    $icon = '<i class="' . CONF_ALERT_SUCCESS["icon"] . '"></i>';
    $style = (!empty($style) ? ' style="' . $style . '"' : null);
    return '<' . $htmlTag . ' class="' . $class . '" role="alert"' . $style . '>' . $icon . $message . '</' . $htmlTag . '>';
}

/**
 * @param string $message
 * @param string|null $class
 * @param string|null $style
 * @param string $htmlTag
 * @return string
 */
function alert_danger(string $message, string $class = null, string $style = null, string $htmlTag = "div"): string
{
    $class = CONF_ALERT_MESSAGE . " " . CONF_ALERT_DANGER["class"] . (!empty($class) ? " {$class}" : null);
    $icon = '<i class="' . CONF_ALERT_DANGER["icon"] . '"></i>';
    $style = (!empty($style) ? ' style="' . $style . '"' : null);
    return '<' . $htmlTag . ' class="' . $class . '" role="alert"' . $style . '>' . $icon . $message . '</' . $htmlTag . '>';
}

/**
 * @param string $message
 * @param string|null $class
 * @param string|null $style
 * @param string $htmlTag
 * @return string
 */
function alert_warning(string $message, string $class = null, string $style = null, string $htmlTag = "div"): string
{
    $class = CONF_ALERT_MESSAGE . " " . CONF_ALERT_WARNING["class"] . (!empty($class) ? " {$class}" : null);
    $icon = '<i class="' . CONF_ALERT_WARNING["icon"] . '"></i>';
    $style = (!empty($style) ? ' style="' . $style . '"' : null);
    return '<' . $htmlTag . ' class="' . $class . '" role="alert"' . $style . '>' . $icon . $message . '</' . $htmlTag . '>';
}

/**
 * @param string $message
 * @param string|null $class
 * @param string|null $style
 * @param string $htmlTag
 * @return string
 */
function alert_info(string $message, string $class = null, string $style = null, string $htmlTag = "div"): string
{
    $class = CONF_ALERT_MESSAGE . " " . CONF_ALERT_INFO["class"] . (!empty($class) ? " {$class}" : null);
    $icon = '<i class="' . CONF_ALERT_INFO["icon"] . '"></i>';
    $style = (!empty($style) ? ' style="' . $style . '"' : null);
    return '<' . $htmlTag . ' class="' . $class . '" role="alert"' . $style . '>' . $icon . $message . '</' . $htmlTag . '>';
}

/**
 * ################
 * ###   DATE   ###
 * ################
 */

/**
 * @param string $date
 * @param string $format
 * @return string
 * @throws Exception
 */
function date_fmt(?string $date, string $format = "d/m/Y H\hi"): string
{
    $date = (empty($date) ? "now" : $date);
    return (new DateTime($date))->format($format);
}

/**
 * @param string $date
 * @return string
 * @throws Exception
 */
function date_fmt_br(?string $date): string
{
    $date = (empty($date) ? "now" : $date);
    return (new DateTime($date))->format(CONF_DATE_BR);
}

/**
 * @param string $date
 * @return string
 * @throws Exception
 */
function date_fmt_app(?string $date): string
{
    $date = (empty($date) ? "now" : $date);
    return (new DateTime($date))->format(CONF_DATE_APP);
}

/**
 * @param string|null $date
 * @return string|null
 */
function date_fmt_back(?string $date): ?string
{
    if (!$date) {
        return null;
    }

    if (strpos($date, " ")) {
        $date = explode(" ", $date);
        return implode("-", array_reverse(explode("/", $date[0]))) . " " . $date[1];
    }

    return implode("-", array_reverse(explode("/", $date)));
}

/**
 * ####################
 * ###   PASSWORD   ###
 * ####################
 */

/**
 * @param string $password
 * @return string
 */
function passwd(string $password): string
{
    if (!empty(password_get_info($password)['algo'])) {
        return $password;
    }

    return password_hash($password, CONF_PASSWD_ALGO, CONF_PASSWD_OPTION);
}

/**
 * @param string $password
 * @param string $hash
 * @return bool
 */
function passwd_verify(string $password, string $hash): bool
{
    return password_verify($password, $hash);
}

/**
 * @param string $hash
 * @return bool
 */
function passwd_rehash(string $hash): bool
{
    return password_needs_rehash($hash, CONF_PASSWD_ALGO, CONF_PASSWD_OPTION);
}

/**
 * ###################
 * ###   REQUEST   ###
 * ###################
 */

/**
 * @return string
 */
function csrf_input(): string
{
    $session = new \Source\Core\Session();
    $session->csrf();
    return "<input type='hidden' name='csrf' value='" . ($session->csrf_token ?? "") . "'/>";
}

/**
 * @param $request
 * @return bool
 */
function csrf_verify($request): bool
{
    $session = new \Source\Core\Session();
    if (empty($session->csrf_token) || empty($request['csrf']) || $request['csrf'] != $session->csrf_token) {
        return false;
    }
    return true;
}

/**
 * @return null|string
 */
function flash(): ?string
{
    $session = new \Source\Core\Session();
    if ($flash = $session->flash()) {
        return $flash;
    }
    return null;
}

/**
 * @param string $key
 * @param int $limit
 * @param int $seconds
 * @return bool
 */
function request_limit(string $key, int $limit = 5, int $seconds = 60): bool
{
    $session = new \Source\Core\Session();
    if ($session->has($key) && $session->$key->time >= time() && $session->$key->requests < $limit) {
        $session->set($key, [
            "time" => time() + $seconds,
            "requests" => $session->$key->requests + 1
        ]);
        return false;
    }

    if ($session->has($key) && $session->$key->time >= time() && $session->$key->requests >= $limit) {
        return true;
    }

    $session->set($key, [
        "time" => time() + $seconds,
        "requests" => 1
    ]);

    return false;
}

/**
 * @param string $field
 * @param string $value
 * @return bool
 */
function request_repeat(string $field, string $value): bool
{
    $session = new \Source\Core\Session();
    if ($session->has($field) && $session->$field == $value) {
        return true;
    }

    $session->set($field, $value);
    return false;
}

/**
 * ###########################################
 * ###   RETORNA STATUS DO ITEM OPCIONAL   ###
 * ###########################################
 */
function statusAdditionalItems($data = null)
{
    $stm = [
        "active" => 'Ativo',
        "inactive" => 'Inativo'
    ];
    if (!empty($data)) :
        return $stm[$data];
    else :
        return $stm;
    endif;
}


/**
 * ###########################################
 * ###   RETORNA STATUS DO ITEM OPCIONAL   ###
 * ###########################################
 */
function statusFlavorItems($data = null)
{
    $stm = [
        "active" => 'Ativo',
        "inactive" => 'Inativo'
    ];
    if (!empty($data)) :
        return $stm[$data];
    else :
        return $stm;
    endif;
}


/**
 * ###########################################
 * ###   RETORNA STATUS DO ITEM OPCIONAL   ###
 * ###########################################
 */
function statusOptionsItems($data = null)
{
    $stm = [
        "active" => 'Ativo',
        "inactive" => 'Inativo'
    ];
    if (!empty($data)) :
        return $stm[$data];
    else :
        return $stm;
    endif;
}

/**
 * ###################################
 * ###   RETORNA CATEGORY PAYMENT  ###
 * ###################################
 */
function bgStatusOptionsItems($data = null)
{
    $status = [
        "active" => "badge-pill badge-success",
        "inactive" => "badge-pill badge-warning"
    ];
    if (!empty($data)) {
        return $status[$data];
    } else {
        return $status;
    }
}


/**
 * ###################################
 * ###   RETORNA BG DO PRODUTO PAYMENT  ###
 * ###################################
 */
function bgStatusProducts($data = null)
{
    $status = [
        "active" => "badge-pill badge-success",
        "inactive" => "badge-pill badge-warning"
    ];
    if (!empty($data)) {
        return $status[$data];
    } else {
        return $status;
    }
}

/**
 * ###################################
 * ###   RETORNA CATEGORY PAYMENT  ###
 * ###################################
 */
function statusProducts($data = null)
{
    $status = [
        "active" => "Ativo",
        "inactive" => "Inativo"
    ];
    if (!empty($data)) {
        return $status[$data];
    } else {
        return $status;
    }
}

/**
 * ##################################################
 * ###   FORMATA VALOR MOEDA PARA SER SALVO NO BD ###
 * ##################################################
 */
function saveMoney($getValor)
{
    $source = array('.', ',');
    $replace = array('', '.');
    $valor = str_replace($source, $replace, $getValor); //remove os pontos e substitui a virgula pelo ponto
    return $valor; //retorna o valor formatado para gravar no banco
}

/**
 * ##################################################
 * ###   VALIDA CPF ###
 * ##################################################
 */
function validadeDocumentClient($cpf)
{

    // Extrai somente os números
    $cpf = preg_replace('/[^0-9]/is', '', $cpf);

    // Verifica se foi informado todos os digitos corretamente
    if (strlen($cpf) != 11) {
        return false;
    }

    // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    // Faz o calculo para validar o CPF
    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }
    return true;
}


/**
 * <b>Checa CNPJ:</b> Informe um CNPJ para checar sua validade via algoritmo!
 * @param STRING $CNPJ = CNPJ com ou sem pontuação
 * @return BOLEAM = True se for um CNJP válido
 */
function validateCnpj($Cnpj)
{
    $Cnpj = (string)$Cnpj;
    $Cnpj = preg_replace('/[^0-9]/', '', $Cnpj);

    if (strlen($Cnpj) != 14) :
        return false;
    endif;

    $A = 0;
    $B = 0;

    for ($i = 0, $c = 5; $i <= 11; $i++, $c--) :
        $c = ($c == 1 ? 9 : $c);
        $A += $Cnpj[$i] * $c;
    endfor;

    for ($i = 0, $c = 6; $i <= 12; $i++, $c--) :
        if (str_repeat($i, 14) == $Cnpj) :
            return false;
        endif;
        $c = ($c == 1 ? 9 : $c);
        $B += $Cnpj[$i] * $c;
    endfor;

    $somaA = (($A % 11) < 2) ? 0 : 11 - ($A % 11);
    $somaB = (($B % 11) < 2) ? 0 : 11 - ($B % 11);

    if (strlen($Cnpj) != 14) :
        return false;
    elseif ($somaA != $Cnpj[12] || $somaB != $Cnpj[13]) :
        return false;
    else :
        return true;
    endif;
}

/**
 * ###################################
 * ###   RETORNA A FORMA DE PAGAMENTO  ###
 * ###################################
 */
function paymentFormat($data = null)
{
    $status = [
        "money" => "Dinheiro",
        "credit" => "Cartão de Crédito",
        "pix" => "Pix",
        "debit" => "Cartão de débito"
    ];
    if (!empty($data)) {
        return $status[$data];
    } else {
        return $status;
    }
}

/**
 * ###################################
 * ###   FORMATA DOCUMENTO  ###
 * ###################################
 */
function formatDocument($doc)
{

    $doc = preg_replace("/[^0-9]/", "", $doc);
    $qtd = strlen($doc);

    if ($qtd >= 11) {

        if ($qtd === 11) {

            $docFormatado = substr($doc, 0, 3) . '.' .
                substr($doc, 3, 3) . '.' .
                substr($doc, 6, 3) . '.' .
                substr($doc, 9, 2);
        } else {
            $docFormatado = substr($doc, 0, 2) . '.' .
                substr($doc, 2, 3) . '.' .
                substr($doc, 5, 3) . '/' .
                substr($doc, 8, 4) . '-' .
                substr($doc, -2);
        }

        return $docFormatado;

    } else {
        return 'Documento invalido';
    }
}

/**
 * ###################################
 * ###   FORMATA PHONE  ###
 * ###################################
 */
function formatPhone($n)
{
    $tam = strlen(preg_replace("/[^0-9]/", "", $n));

    if ($tam == 13) {
        // COM CÓDIGO DE ÁREA NACIONAL E DO PAIS e 9 dígitos
        return "+" . substr($n, 0, $tam - 11) . " (" . substr($n, $tam - 11, 2) . ") " . substr($n, $tam - 9, 5) . "-" . substr($n, -4);
    }
    if ($tam == 12) {
        // COM CÓDIGO DE ÁREA NACIONAL E DO PAIS
        return "+" . substr($n, 0, $tam - 10) . " (" . substr($n, $tam - 10, 2) . ") " . substr($n, $tam - 8, 4) . "-" . substr($n, -4);
    }
    if ($tam == 11) {
        // COM CÓDIGO DE ÁREA NACIONAL e 9 dígitos
        return " (" . substr($n, 0, 2) . ") " . substr($n, 2, 5) . "-" . substr($n, 7, 11);
    }
    if ($tam == 10) {
        // COM CÓDIGO DE ÁREA NACIONAL
        return " (" . substr($n, 0, 2) . ") " . substr($n, 2, 4) . "-" . substr($n, 6, 10);
    }
    if ($tam <= 9) {
        // SEM CÓDIGO DE ÁREA
        return substr($n, 0, $tam - 4) . "-" . substr($n, -4);
    }

}

/**
 * ###################################
 * ###   SLUG INTERPRISE          ###
 * ###################################
 */
function slug_interprise()
{
    if (isset($_SESSION['slug_enterprise'])) {
        return $_SESSION['slug_enterprise'];
    } else {
        url();
    }
}

/**
 * ###################################
 * ###   RETORNA STATUS DO PEDIDO   ###
 * ###################################
 */
function setStatusOrders($data = null)
{
    $order = [
        1 => 'Novo Pedido',
        2 => 'Em preparação',
        6 => 'Vem retirar na loja',
        3 => 'Saiu para entrega',
        4 => 'Entregue',
        5 => 'Cancelado',
    ];
    if (!empty($data)):
        return $order[$data];
    else:
        return $order;
    endif;
}


/**
 * ########################################################################
 * ###  FORMATA A MENSAGEM A SER ENVIADA AO CLIENTE COM BASE NO STATUS  ###
 * ########################################################################
 */
function messageStatusNotification($data = null)
{
    $order = [
        1 => 'Novo Pedido',
        2 => 'Seu pedido está em preparação.',
        6 => 'Você já pode vir retirar o seu pedido.',
        3 => 'Saiu para entrega',
        4 => 'Tudo certo. seu pedido foi entregue. Obrigado por usar o aplicativo Fomix.',
        5 => 'Algo deu errado. Seu pedido foi cancelado',
    ];
    if (!empty($data)):
        return $order[$data];
    else:
        return $order;
    endif;
}


/** * ###################################
 * ### RETORNA STATUS DO PEDIDO ### *
 * ###################################
 */
function classStatusPayment($data = null)
{
    $order = [
        1 => 'text-warning',
        2 => 'text-info',
        3 => 'text-primary',
        4 => 'text-success',
        5 => 'text-danger',
        6 => 'text-info'];
    if (!empty($data)):
        return $order[$data];
    else:
        return $order;
    endif;
}

/** * ###################################
 * ### RETORNA STATUS DO DE RETORNO DA CORRIDA ### *
 * ###################################
 */
function gobackRider($data = null)
{
    $rider = [
        "yes" => 'Sim',
        "no" => "Não"
    ];
    if (!empty($data)):
        return $rider[$data];
    else:
        return $rider;
    endif;
}

/** * ###################################
 * ### RETORNA O TIPO DE VEÍCULO ### *
 * ###################################
 */
function vehicleType($data = null)
{
    $type = [
        "motorcycle" => "Moto",
        "car" => 'Carro',
        "bike" => "Bicicleta",
        "onfooter" => "A pé"
    ];
    if (!empty($data)):
        return $type [$data];
    else:
        return $type;
    endif;
}


/** * ###################################
 * ### RETORNA O TIPO DE VEÍCULO ### *
 * ###################################
 */
function boxType($data = null)
{
    $type = [
        "any" => "Qualquer",
        "bag" => 'Bag',
        "Baú" => "Baú"
    ];
    if (!empty($data)):
        return $type [$data];
    else:
        return $type;
    endif;
}

/** * ###################################
 * ### RETORNA O TIPO DE VEÍCULO ### *
 * ###################################
 */
function raceOrigin($data = null)
{
    $type = [
	    "shop" => 'Minha Loja',
        "fomix" => "Fomix",
        "other" => "Outro aplicativo"
    ];
    if (!empty($data)):
        return $type [$data];
    else:
        return $type;
    endif;
}

/** * ###################################
 * ### RETORNA O TIPO DE VEÍCULO ### *
 * ###################################
 */
function licenseType($data = null)
{
    $type = [
        "a" => "A",
        "b" => "B",
        "ab" => "AB",
        "c" => "C",
        "d" => "D",
        "e" => "E"
    ];
    if (!empty($data)):
        return $type [$data];
    else:
        return $type;
    endif;
}


/** * ###################################
 * ### RETORNA O TIPO DE VEÍCULO ### *
 * ###################################
 */
function invoicesStatus($data = null)
{
    $type = [
        "credit" => "Creditada",
        "onpay" => "Aguardando pagamento",
        "pay" => "Paga",
        "debit" => "Debitado",
        "canceled" => "Cancelada"
    ];
    if (!empty($data)):
        return $type [$data];
    else:
        return $type;
    endif;
}


/** * ###################################
 * ### RETORNA O TIPO DE VEÍCULO ### *
 * ###################################
 */
function balanceStatusDelivery($data = null)
{
    $type = [
        "finish" => "A ser creditada",
        "pay" => "Paga",
        "canceled" => "Cancelada"
    ];
    if (!empty($data)):
        return $type [$data];
    else:
        return $type;
    endif;
}

/** * ###################################
 * ### RETORNA O TIPO DE VEÍCULO ### *
 * ###################################
 */
function statusRace($data = null)
{
    $type = [
        "finish" => "Finalizada",
        "in_race" => "Em andamento",
        "open" => "criada"
    ];
    if (!empty($data)):
        return $type [$data];
    else:
        return $type;
    endif;
}


/*
* ###################################
* ###   RETORNA CATEGORY PAYMENT  ###
* ###################################
*/
function setBgstatusPayment($data = null)
{
    $payment = [
        "pay" => "badge-success",
        "finish" => "badge-info"
    ];
    if (!empty($data)) {
        return $payment[$data];
    } else {
        return $payment;
    }
}


/**
 * ###################################
 * ###   GERA O UUID  ###
 * ###################################
 */

function createdUniversalIdentifier(){
    return md5(uniqid(rand(), true));
}