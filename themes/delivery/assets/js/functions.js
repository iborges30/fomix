$(function () {

    /***********************************
     * ***** URL BASE *******************
     ***********************************/
    let BASE = $('link[rel="base"]').attr("href");
    const audio = new Audio('https://fomix.net.br/plus/themes/sb-admin/assets/sound/alert.mp3');


    /***********************************
     * ***** CRIA A CORRIDA ************
     ***********************************/
    $('.ajax-delivery').on("click", ".jsc-accept-race", function () {
        var idRace = $(".jsc-request").attr("id");
        var deliveryId = $(this).data("delivery");
        var uri = BASE + '/request/delivery/race';

        $.ajax({
            url: uri,
            dataType: 'html',
            data: {idRace: idRace, deliveryId: deliveryId},
            method: 'post',
            beforeSend: function () {
                $(".dialog").fadeIn();
            }, complete: function () {
                $(".dialog").fadeOut()
            }, success: function (response) {
                location.reload();
                $(".in_ajax").html(response);
            }
        });
        return false;
    });


    $("form[name='formLogin']").submit(function () {
        var dados = $(this).serialize();
        var uri = $(this).attr("action");

        $.ajax({
            url: uri,
            method: 'post',
            data: dados,
            dataType: 'json',
            beforeSend: function () {
            },
            success: function (response) {
                if (response.hash) {
                    let hash = localStorage.setItem('@fomixdelivery', response.hash);
                    window.location.href = BASE + "/delivery/user/" + response.hash;
                }

                if (response.message) {
                    alert(response.message);
                }
            },
            complete: function () {
            }
        });
        return false;
    });


    //SE ESTIVER LOGADO REDIRECIONA PARA A ÁREA QUE A GENTE PRECISA
    var url = window.location.href;
    var item = localStorage.getItem('@fomixdelivery');

    if (item) {
        $(".jsc-user").attr("href", BASE + '/delivery/user/' + item);
        $(".jsc-week").attr("href", BASE + '/delivery/user/report/' + item);
    }

    if (url == BASE + '/d/user/login' && item) {
        window.location.href = BASE + "/delivery/user/" + item;
    }

    if (url == BASE + "/delivery/user/" && !item) {
        window.location.href = BASE + '/d/user/login';
    }


    //FAZ O LOG OFF
    $(".jsc-turn-off").click(function () {
        localStorage.removeItem('@fomixdelivery');
        window.location.href = BASE + '/d/user/login';
        return false;
    });

    //TRAZ AS ENTREGAS VIA POST
    function checkRace() {
        var id = item;
        $.ajax({
            url: BASE + '/delivery/user/' + id,
            method: 'post',
            dataType: 'html',
            success: function (response) {
                $(".ajax-delivery").html(response);
                console.log(response);
                if (response.indexOf("jsc-request") !== -1) {
                    audio.play();
                    navigator.vibrate(1000);
                }
            }
        });
    }

    if ($('#profile').hasClass('sleep')) {
        $(".jsc-delivery-in-ride").remove();
        $(".ajax-delivery").remove();
    }

    checkRace();
    setInterval(function () {
        checkRace();
    }, 40000);


    $(".jsc-in-activity ").click(function () {
        var status = $(this).data("activity");
        var deliveryId = $(this).attr("id");
        console.log(status, deliveryId);
        $.ajax({
            url: BASE + '/delivery/user/status',
            method: 'post',
            data: {status: status, deliveryId: deliveryId},
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    location.reload();
                }

            }
        });
        return false;
    });
});