<!DOCTYPE html>
<html lang="pt-Br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0,user-scalable=0">
    <meta name="theme-color" content="#111">
    <meta name="facebook-domain-verification" content="jvj2d88jny7v45m67cwo6i37qh6jux" />
    <?= $head; ?>
    <link rel="base" href="<?= url(); ?>"/>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;400;600;900&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;400;600&family=Roboto:wght@100;400;700&display=swap"
          rel="stylesheet">

    <link rel="stylesheet" href="<?= theme("/assets/style.css"); ?>" ?id="<?= time(); ?>"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link rel="icon" type="image/png" href="<?= theme("/assets/images/favicon.png"); ?>"/>



    <?php
    $pixFacebook = $_SESSION["slug_enterprise"];
    if ($pixFacebook == 'mult-festa'):?>
        <!-- Facebook Pixel Code -->
        <script>
            !function (f, b, e, v, n, t, s) {
                if (f.fbq) return;
                n = f.fbq = function () {
                    n.callMethod ?
                        n.callMethod.apply(n, arguments) : n.queue.push(arguments)
                };
                if (!f._fbq) f._fbq = n;
                n.push = n;
                n.loaded = !0;
                n.version = '2.0';
                n.queue = [];
                t = b.createElement(e);
                t.async = !0;
                t.src = v;
                s = b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t, s)
            }(window, document, 'script',
                'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '601464731278377');
            fbq('track', 'PageView');
        </script>
        <noscript>
            <img height="1" width="1"
                 src="https://www.facebook.com/tr?id=601464731278377&ev=PageView
&noscript=1"/>
        </noscript>
        <!-- End Facebook Pixel Code -->
    <?php
    else:
        ?>

        <!-- Facebook Pixel Code NÃO É MULT-->
        <script>
            !function (f, b, e, v, n, t, s) {
                if (f.fbq) return;
                n = f.fbq = function () {
                    n.callMethod ?
                        n.callMethod.apply(n, arguments) : n.queue.push(arguments)
                };
                if (!f._fbq) f._fbq = n;
                n.push = n;
                n.loaded = !0;
                n.version = '2.0';
                n.queue = [];
                t = b.createElement(e);
                t.async = !0;
                t.src = v;
                s = b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t, s)
            }(window, document, 'script',
                'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '517986635974325');
            fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none"
                       src="https://www.facebook.com/tr?id=517986635974325&ev=PageView&noscript=1"/></noscript>
        <!-- End Facebook Pixel Code -->
    <?php
    endif;
    ?>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-204864779-1">
    </script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', 'UA-204864779-1');
    </script>


</head>

<body>
<?= $v->section("content"); ?>
<div class="go-back-footer">
    <div class="row print-remove">
        <div class="col-5">
            <a href="<?= url(); ?>">
                <img src="<?= theme("/assets/images/shops.png"); ?>" alt="todas as lojas">
                <span class="rounded text-center">Lojas</span>
            </a>
        </div>

        <div class="col-5">
            <a href="#" class="jsc-update-window">
                <img src="<?= theme("/assets/images/atualiza.png"); ?>" alt="Atualiza Página">
                <span class="rounded text-center">Atualizar</span>
            </a>
        </div>

        <div class="col-5">
            <a href="#" class="jsc-set-cities">
                <img src="<?= theme("/assets/images/cities.png"); ?>" alt="Cidades">
                <span class="rounded text-center">Cidades</span>
            </a>
        </div>


        <div class="col-5 ds-none set-request">
            <a href="#" class="jsc-request">
                <img src="<?= theme("/assets/images/request.png"); ?>" alt="Acompanhar pedido">
                <span class="rounded text-center">Meus Pedidos</span>
            </a>
        </div>


        <div class="col-5">
            <a href="#" class=" jsc-go-back">
                <img src="<?= theme("/assets/images/voltar.png"); ?>" alt="Voltar página">
                <span class="rounded text-center">Voltar</span>
            </a>
        </div>


    </div>

</div>


<!-- LISTA RESTAURANTES -->

<script src="https://cdn.socket.io/4.1.2/socket.io.min.js"
        integrity="sha384-toS6mmwu70G0fw54EGlWWeA4z3dyJ+dlXBtSURSKN4vyRFOcxd3Bzjj/AoOwY+Rg"
        crossorigin="anonymous">
</script>
<script src="<?= theme("/assets/scripts.js"); ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script>
    BASE = $("link[rel='base']").attr("href");
   const socket = io("wss://deliverybot.ml", {
        secure: true
    });

    socket.on('changeStatus_fomix', function (data) {
        console.log(data);
        $.ajax({
            url: 'https://fomix.net.br/plus/burguer-delivery/my-request-ajax/' + $('#my-request-ajax').attr('data-token'),
            method: 'GET',
            dataType: 'html',
            success: function (response) {
                console.log(response);
                $('#my-request-ajax').html(response);
            },
            error: function (err) {
                console.log(err);
            }

        });
    });


    //INSERE O LINK NO ICONE PARA ACOMPANHAR O PEDIDO
    var uri = localStorage.getItem('uri');
    var clientLike = uri;


    if(clientLike){
        clientLike = clientLike.replace(BASE+"/meus-pedidos/", "");
        $(".like").removeClass("ds-none");
    }else{
        $(".like").css("display", "none");
    }



    if (uri) {
        $(".set-request").css("display", "block");
        $(".jsc-request").attr("href", uri)
    }


    function getMobileOperatingSystem() {
        var userAgent = navigator.userAgent || navigator.vendor || window.opera;
        if (userAgent.match(/iPad/i) || userAgent.match(/iPhone/i) || userAgent.match(/iPod/i)) {
            return 'iOS';
        } else if (userAgent.match(/Android/i)) {
            return 'Android';
        } else {
            return 'unknown';
        }
    }

    var tipo = getMobileOperatingSystem();

    if (tipo == "Android") {
        console.log("Android");
    } else if (tipo == "iOS") {
        console.log("IOS");
    } else {
        console.log("Não sei ");
    }

</script>
<?= $v->section("scripts"); ?>
</body>

</html>