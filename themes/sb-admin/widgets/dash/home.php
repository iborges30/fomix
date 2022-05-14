<?php $v->layout("_admin"); ?>
    <style>
        .jsc-response {
            position: absolute;
            top: 38px;
            width: 100%;
            z-index: 10;
        }

        .list-numbers {
            background: rgb(245, 245, 245);
            border-radius: 4px;
            padding: 5px;
        }

        .jsc-list-item {
            border-bottom: 1px solid rgba(0, 0, 0, 0.02);
        }

        .jsc-list-item p {
            margin-left: 5px;
        }

        .alert-app {
            cursor: pointer;
            position: fixed;
            right: -999px;
            border-radius: 4px;
            padding: 40px 20px;
            z-index: 10;
            bottom: 70px;
            font-size: 16px;
            display: block;
        }
    </style>
<?= $v->insert("widgets/dash/modal"); ?>
    <div class="jsc-alert-app alert-app badge badge-warning shadow jsc-alert-app-notification"
         data-finish="<?= url("/admin/dash/finish"); ?>">
        <i class="fas fa-exclamation-circle"></i>
        <span class="">
        Atenção. você tem <span class="ajax-count"></span> novos pedidos!
    </span>
    </div>

    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fa fa-pizza-slice"></i>
                Últimos pedidos
            </h1>

            <div class="d-none d-sm-inline-block form-inline ml-auto ml-md-3 my-2 my-md-0 mw-100  navbar-search">
                <div class="input-group">
                    <a href="#" class="btn mr-5  btn-primary jsc-audio-test">
                        <i class="fa fa-play"></i>
                        Som do Alerta
                    </a>

                    <a href="<?= url("/admin/dash/status-shop"); ?>"
                       data-shop-status="<?= $shop->status == 'open' ? "close" : 'open'; ?>"
                       class="btn <?= $shop->status == 'open' ? " btn-info" : 'btn-danger'; ?> jsc-status-shop">
                        <i class="fas fa-store-alt"></i>
                        <?= $shop->status == 'open' ? " aberto" : 'Fechado'; ?>
                    </a>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning  shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Novo pedido
                                </div>

                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= !empty($confirmed) >= 1 ? $confirmed : '0'; ?></div>
                                    </div>

                                    <div class="col">
                                        <div class="progress progress-sm mr-2">
                                            <div class="progress-bar bg-warning" role="progressbar"
                                                 style="width: <?= $percentConfirmed; ?>%" aria-valuenow="50"
                                                 aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info  shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Em preparação
                                </div>

                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= !empty($kitchen) >= 1 ? $kitchen : '0'; ?></div>
                                    </div>

                                    <div class="col">
                                        <div class="progress progress-sm mr-2">
                                            <div class="progress-bar bg-info" role="progressbar"
                                                 style="width: <?= $percentKitchen; ?>%" aria-valuenow="50"
                                                 aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-cookie-bite  fa-2x text-gray-300"></i>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary  shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Env. Entrega
                                </div>

                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= !empty($send) >= 1 ? $send : '0'; ?></div>
                                    </div>

                                    <div class="col">
                                        <div class="progress progress-sm mr-2">
                                            <div class="progress-bar bg-primary" role="progressbar"
                                                 style="width: <?= $percentSend; ?>%" aria-valuenow="50"
                                                 aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-paper-plane fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success  shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Vem Retirar
                                </div>

                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= !empty($inSotre) >= 1 ? $inSotre : '0'; ?></div>
                                    </div>

                                    <div class="col">
                                        <div class="progress progress-sm mr-2">
                                            <div class="progress-bar bg-primary" role="progressbar"
                                                 style="width: <?= $percentInStore; ?>%" aria-valuenow="50"
                                                 aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if (!$orders) : ?>
            <?= alert_info("Ainda não temos pedidos cadastrados no sistema.", "w-50"); ?>
        <?php else : ?>
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Cliente</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Cliente</th>
                                <th>Valor</th>
                                <th>Status</th>
                                <th>Gerenciar</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Cliente</th>
                                <th>Valor</th>
                                <th>Status</th>
                                <th>Gerenciar</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            <form action="" method="post" name="sendStatus">
                                <?php
                                foreach ($orders as $p) :
                                    ?>
                                    <tr>
                                        <td><?= $p->id; ?></td>
                                        <td>
                                            <?= $p->client; ?> - <?= $p->whatsapp; ?>
                                            <p>
                                                <b class="ajax-notes-<?= $p->id; ?>"><?= $p->note; ?></b>
                                            </p>

                                        </td>
                                        <td>
                                            R$ <?= str_price(($p->delivery_rate + $p->total_orders) - $p->discount); ?></td>
                                        <td>
                                            <span id="<?= $p->id; ?>"
                                                  class="jsc-status-orders  <?= classStatusPayment($p->status); ?>"
                                                  data-status="<?= $p->status; ?>"><b><?= setStatusOrders($p->status); ?></b></span>
                                            <div class="select-status <?= $p->id; ?>" style="display: none">

                                                <div class="form-group col-md-12">
                                                    <select name="status" class="form-control <?= $p->id; ?>"
                                                            required="">
                                                        <?php

                                                        foreach (setStatusOrders() as $key => $value) :
                                                            if ($key != 5):
                                                                ?>


                                                                <option value="<?= $key ?>" <?= ($user > 6 and $key == 5) ? 'disabled' : ''; ?> <?= $p->status == $key ? 'selected' : ''; ?>>
                                                                    <?= $value; ?>
                                                                </option>
                                                            <?php
                                                            endif;
                                                        endforeach;

                                                        ?>
                                                    </select>
                                                </div>

                                            </div>
                                        </td>
                                        <td>
                                            <a target="_blank"
                                               href="<?= url("/my-request/{$p->transaction_key}#print/"); ?>"
                                               data-toggle="tooltip"
                                               class="btn btn-primary btn-circle btn-sm jsc-localSstorange"
                                               title="Imprimir Pedido">
                                                <i class="fas fa-print"></i>
                                            </a>
                                            <a href="<?= url("/admin/dash/orders-print/{$p->id}"); ?>"
                                               data-toggle="tooltip" class="btn btn-info btn-circle btn-sm"
                                               title="Ver detalhes do pedido">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="#" data-toggle="tooltip" data-order-observation="<?= $p->id ?>"
                                               class="btn btn-warning btn-circle btn-sm jsc-open-modal-observations"
                                               title="Inserir observação ao pedido">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </form>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!--paginator-->
            <?= $paginator; ?>
        <?php endif; ?>

    </div>

<?php $v->start("scripts"); ?>
    <script src="https://cdn.socket.io/4.1.2/socket.io.min.js"
            integrity="sha384-toS6mmwu70G0fw54EGlWWeA4z3dyJ+dlXBtSURSKN4vyRFOcxd3Bzjj/AoOwY+Rg"
            crossorigin="anonymous"></script>
    <script>

        const socket = io("wss://deliverybot.ml", {
            secure: true
        });

        socket.emit('login', {
            shopId: <?= $UserEnterpriseId; ?>
        });


        function sendMessage(number, message) {
            socket.emit(
                "users",
                "sendMessage", {
                    number: number,
                    message: message
                },
                "fomix"
            );
        }


        //AUTOCOMPLETE
        $('input[name="s"]').on('keyup', function () {
            var form = $(this).val();
            $.ajax({
                url: '<?= url("/admin/dash/autocomplete"); ?>',
                data: {
                    number: form
                },
                type: "POST",
                dataType: "json",
                success: function (response) {
                    if (response.client) {
                        if (!$(".jsc-response").find('.list-numbers').length) {
                            $(".jsc-response").append("<div class='list-numbers'></div>");

                        }
                        $('.list-numbers').empty();

                        $.each(response.client, function (key, value) {
                            $('.list-numbers').append("<div class='jsc-list-item'>" +
                                "<p>" + value + "</p>" +
                                "</div>");
                        });

                    }
                    if (response.clear) {
                        if ($('.list-numbers').length) {
                            $('.jsc-list-item').remove();
                        }
                    }
                    console.log(response);
                }
            });

            $("body").on("click", ".jsc-list-item p", function () {
                var item = $(this).text();
                $('input[name="s"]').val(item);
                $('.list-numbers').remove();
            });

            $('body').on('click', function (e) {
                if (!$('.jsc-response').has(e.target).length) {
                    $('.list-numbers').remove();
                }
            });
        });

        //SALVA ITEM NO LOCALSTORANGE PARA VERIFICAR A NAVEGAÇÃO
        $(".jsc-localSstorange").click(function () {
            localStorage.setItem('print', 'on');
        });


        $(".jsc-status-orders").dblclick(function () {
            var status = $(this).attr("data-status");
            var id = $(this).attr("id");

            $(this).fadeOut("fast", function () {
                $('.' + id).show("fast");

                $("." + id).on('change', function (e) {
                    var changeStatus = ($(this).val());
                    console.log(changeStatus + '-----enviado status-----' + id);
                    $.ajax({
                        url: '<?= url("/admin/dash/status"); ?>',
                        data: {
                            status: changeStatus,
                            order: id
                        },
                        type: "POST",
                        dataType: "json",
                        success: function (response) {

                            if (response.error) {
                                alert("Erro ao atualizar status do pedido");
                            }

                            if (response.success) {
                                //ENVIA A MENSAGEM
                                sendMessage(response.clientPhone, "Olá, a Fomix informa: \r\n A empresa " + response.enterprise + " mudou o status do seu pedido para: *" + response.message + "*\r\n Essa é uma mensagem automática. \r\n *#### Favor não responde-la. ###*");

                                socket.emit(
                                    "users",
                                    "changeStatus",
                                    response,
                                    "fomix"
                                );
                                setTimeout(function () {
                                    window.location.reload();
                                }, 1000);
                            }

                        }
                    });

                    return false;
                });


            });
        });
        $('.jsc-alert-app').click(function () {
            var url = $(this).attr('data-finish');
            $.ajax({
                url: url,
                data: {},
                type: "POST",
                dataType: "json",
                success: function (response) {
                    if (response.viewed) {
                        $('.alert-app').animate({
                            right: '-999px'
                        });
                        location.reload(true)
                    }

                }
            });
        });

        const audio = new Audio('<?= theme("/assets/sound/alert.mp3", CONF_VIEW_ADMIN); ?>');

        fomix();

        setInterval(function () {
            fomix();
        }, 12000);

        //TESTA O ÁUDIO
        $(".jsc-audio-test").click(function () {
            audio.play();

        });



        //MODAL  --- FALTA FAZER O INSERT AQUI
        $(".jsc-open-modal-observations").click(function () {
            var orderId = $(this).data("order-observation");
            $("input[name='observatio_order_id']").val(orderId);

            $("#observations-orders").modal();
            return false;
        });


        //ATUALIZA O PEDIDO PARA INSERIR A OBSERVAÇÃO NELE
        $("body").on("submit", "form[name='formNote']", function () {
            var dados = $(this).serialize();
            var uri = $(this).attr("action");

            $.ajax({
                url: uri,
                data: dados,
                type: "POST",
                dataType: "json",
                beforeSend: function () {
                    $(".csw-load").fadeIn();
                },
                success: function (response) {
                    if (response.message) {
                        $(".ajax-notes-" + response.id).text(response.note);
                        $("input[name='note']").val('');
                    }
                },
                complete: function () {
                    $(".csw-load").fadeOut();
                }
            });
            return false;
        });

        //DATA TOOGLE
        $('[data-toggle="tooltip"]').tooltip();

        //ABRE E FECHA A LOJA
        $(".jsc-status-shop").click(function () {
            var uri = $(this).attr("href");
            var status = $(this).data("shop-status");
            $.ajax({
                url: uri,
                data: {
                    status: status
                },
                dataType: "json",
                type: 'post',
                success: function (response) {
                    console.log(response);
                    if (response.message) {
                        alert(response.message);
                        window.location.reload();
                    }
                }
            });

            return false;
        });


        //FUNÇÃO PARA GERAR O ALERTA DA FOMIX

        function fomix() {
            $.ajax({
                url: '<?= url("/admin/dash/alert"); ?>',
                data: {},
                type: "POST",
                dataType: "json",
                success: function (response) {
                    if (response.alert) {
                        $('.ajax-count').html(response.count);
                        $('.alert-app').animate({
                            right: '0px'
                        });
                        audio.play();
                    }

                }
            });
        }

    </script>
<?php $v->end(); ?>