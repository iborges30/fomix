<?php $v->layout("_theme"); ?>
    <style>

        .text-warning {
            background: #F5B946;
        }

        .text-info {
            background: #36b9cc;
        }

        .text-primary {
            background: #4e73df !important;
        }

        .text-success {
            background: #1cc88a !important;
        }

        .text-danger {
            background: #D94352;
        }


        .my-list-request {
            margin-top: 35px;
        }

        .my-list-request h2 {
            font-weight: normal;
            font-size: 20px;
            color: #111111;
        }

        .bg-my-list-request {
            background: #FCFCFC;
        }

        .my-list-request ul {
            margin-top: 30px;
            margin-bottom: 100px;
        }

        .my-list-request li {
            border: 1px solid #ECECEC;
            border-radius: 10px;
            margin-bottom: 15px;
            padding: 15px 8px;
            background: #fff;

        }

        .my-list-request a {
            text-decoration: none;
        }

        .my-list-request .ds-flex {
            justify-content: space-between;
            align-items: center;
        }

        .client-request p {
            margin: 2px 0;
            color: #373737;
            font-size: .875em;

        }

        .client-request .time-request {
            font-size: 12px;
            color: #7F7F7F;
        }

        .client-request span {
            color: #01C587;
            font-size: .75em;
        }

        .new-request {
            padding: 10px;
            border-radius: 8px;
            color: #fff;
        }

        .div select {
            padding: 10px 5px;
            margin-top: 11px;
            border-radius: 4px;
            display: none;
        }
    </style>


    <div class="all bg-my-list-request">
        <div class="container my-list-request">
            <div class="row">
                <div class="col-1">
                    <h2 class="poppins text-center">MEUS PEDIDOS</h2>
                    <p class="poppins text-center"> Clique no nome do cliente para visualizar o pedido </p>
                </div>
            </div>
            <div class="row">
                <div class="col-1">
                    <ul>
                        <?php
                        if ($request):
                            foreach ($request as $p):
                                if ($p->status != 5):
                                    ?>

                                    <li>

                                        <div class="ds-flex">
                                            <a href="<?= url("/my-request/{$p->transaction_key}"); ?>">
                                                <div class="client-request">
                                                    <p>Pedido: #<?= $p->id; ?></p>
                                                    <p><?= $p->client; ?></p>
                                                    <p class="time-request"><?=date("d/m/Y H:i:s", strtotime($p->created));?></p>
                                                    <span>R$: <b><?= str_price(($p->delivery_rate +  $p->total_orders) - $p->discount); ?></b></span>
                                                </div>
                                            </a>


                                            <div class="div">
                                                <a href="#"
                                                   class="jsc-status-enterprise-request"
                                                   id="<?= $p->id; ?>">
                                                    <div class="actions poppins">
                                            <span class="new-request <?= classStatusPayment($p->status); ?>">
                                                <?= setStatusOrders($p->status); ?>
                                            </span>
                                                    </div>
                                                </a>
                                                <form action="" method="post" name="formStatusUpdate">
                                                    <select name="status"
                                                            id="<?= $p->id; ?>"
                                                            class="form-control <?= $p->id; ?>"
                                                            required="">
                                                        <?php
                                                        foreach (setStatusOrders() as $key => $value) :
                                                            if ($key != 5):
                                                                ?>
                                                                <option value="<?= $key ?>" <?= ($key == 5) ? 'disabled' : ''; ?> <?= $p->status == $key ? 'selected' : ''; ?>>
                                                                    <?= $value; ?>
                                                                </option>
                                                            <?php
                                                            endif;
                                                        endforeach;
                                                        ?>
                                                    </select>
                                                </form>
                                            </div>
                                        </div>
                                    </li>
                                <?php endif;
                            endforeach;
                        endif;
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<?php $v->start("scripts"); ?>
    <script>
        $(function () {
            $(".jsc-status-enterprise-request").click(function () {
                var orderId = $(this).attr("id");
                $("." + orderId).fadeIn("fast");

                $("." + orderId).on('change', function (e) {
                    var changeStatus = ($(this).val());

                    $.ajax({
                        url: '<?= url("/enterprise/status"); ?>',
                        data: {
                            status: changeStatus,
                            order: orderId
                        },
                        type: "POST",
                        dataType: "json",
                        success: function (response) {
                            console.log(response);
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
                        },error:function (response, xhr){
                            alert(response, xhr);
                        }
                    });
                });

                return false;
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
        });
    </script>
<?php $v->end("scripts"); ?>