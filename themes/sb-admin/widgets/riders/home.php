<?php $v->layout("_admin"); ?>
    <style>
        .details {
            padding: 5px;
            background: #f8f9fc;
            align-items: center;
        }

        .avatar {
            width: 50px;
            margin-right: 10px;


        }

        .avatar img {
            padding: 2px;
            border-radius: 40px;
            border: 2px solid #ffffff;
        }
    </style>
    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fa fa-bicycle"></i>
                Entregas
            </h1>

            <div class="d-none d-sm-inline-block form-inline ml-auto ml-md-3 my-2 my-md-0 mw-100  navbar-search">
                <div class="input-group">
                    <a href="<?= url("/admin/riders/rider"); ?>"
                       class="btn  btn-success">
                        <i class="fas fa-motorcycle"></i>
                        Nova Entrega
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success  shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Entregadores online
                                </div>

                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= ($count);?></div>
                                    </div>


                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-motorcycle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning  shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Seu saldo atual
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                            R$ <?= $credit; ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-money-check fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- AQUI -->
        <div class="ajax-races"></div>
    </div>
    <script src="https://cdn.socket.io/4.1.2/socket.io.min.js"
            integrity="sha384-toS6mmwu70G0fw54EGlWWeA4z3dyJ+dlXBtSURSKN4vyRFOcxd3Bzjj/AoOwY+Rg"
            crossorigin="anonymous"></script>
<?php $v->start("scripts"); ?>
    <script>
        const socket = io("wss://deliverybot.ml", {
            secure: true
        });


        function sendMessage(number, message) {
            socket.emit(
                "users",
                "sendMessage",
                {number: number, message: message},
                "fomix"
            );
        }

        //VERIFICA SE ALGUÉM ACEITOU A CORRIDA
        delivery();
        setInterval(function () {
            delivery();
        }, 30000);

        function delivery() {
            $.ajax({
                url: '<?= url("/admin/race/enterprise/acceppt");?>',
                dataType: 'html',
                method: 'post',
                success: function (response) {
                    $(".ajax-races").html(response);
                }
            });
        }


        $("body").on("click", ".jsc-finish-race", function () {
            var raceId = $(this).data("race-id");
            var phone = $(this).data("phone-delivery");
            $.ajax({
                url: '<?= url("/admin/race/enterprise/finish");?>',
                dataType: 'json',
                data: {raceId: raceId},
                method: 'post',
                success: function (response) {
                    if (response.success) {
                        sendMessage(phone, 'Fomix informa: A Entrega #' + raceId + '  foi finalizada pela empresa. Clique em atualizar no App para aceitar novas corridas. ');
                        location.reload();
                    }
                }
            });
            return false;
        });
    </script>
<?php $v->end("scripts"); ?>