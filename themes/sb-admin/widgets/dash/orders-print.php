<?php $v->layout("_admin"); ?>


    <style>
        .csw-center {
            text-align: center !important;
            display: block;

        }

        .csw-go-back {
            padding: 10px 20px;
            position: absolute;
            right: -5px;
            top: 50%;
            background: #4e73df;
            border-radius: 4px;
            box-shadow: inset 0 0 11px 3px #00000036;
            display: none;
            cursor: pointer;
        }

        @media print {

            .csw-go-back {
                display: none !important;
                visibility: hidden;
            }

            .csw-print {
                font-weight: bold;
                text-transform: uppercase;
            }

            body {
                font-size: 8pt !important;
                max-width: 80mm !important;
                font-weight: normal;
                font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
                height: auto;
                word-wrap: break-word;
            }

            p {
                font-size: 8pt !important;
                font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
                word-wrap: break-word;
            }

            h1 {
                font-size: 10pt !important;
                font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            }
        }
    </style>

    <div class="container-fluid remove">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fa fa-pizza-slice"></i>
                Pedido <?= $orders->id; ?> - <?= $client->client; ?>
            </h1>
        </div>

        <?php
      
        if (!$orders) : ?>
            <?= alert_info("Ainda não temos pedidos cadastrados no sistema.", "w-50"); ?>
        <?php else : ?>
            <!-- DataTales Example -->
            <div class="card  mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Pedido <?= $orders->id; ?>
                        - <?= $enterprise->enterprise; ?></h6>
                    <div class="row">
                        <div class="col-4"><b>Cliente</b>: <?= $client->client; ?></div>
                        <div class="col-4"><b>Fone</b>: <?= $client->whatsapp; ?></div>
                        <div class="col-4"><b>Endereço</b>: <?= $client->address; ?></div>
                        <div class="col-4"><b>Número</b>: <?= $client->number; ?></div>
                        <div class="col-4"><b>Complemento</b>: <?= $client->complement; ?></div>
                        <div class="col-4"><b>Bairro</b>: <?= $client->square; ?></div>
                        <div class="col-4"><b>Cidade</b>: <?= $client->city; ?></div>
                        <div class="col-4"><b>Estado</b>: <?= $client->state; ?></div>
                        <div class="col-4"><b>Data do pedido</b>: <?= date("d/m/Y H:i", strtotime($orders->created)); ?>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                            <tr>

                                <th>Produto</th>
                                <th>Descrição</th>
                                <th>Valor</th>
                                <th>Qtd</th>
                                <th>Total</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>

                                <th>Produto</th>
                                <th>Descrição</th>
                                <th>Valor</th>
                                <th>Qtd</th>
                                <th>Total</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            <?php
                            foreach ($items as $p) :
                                $price_product = '';
                                $price_additional = 0;
                                $listflavors = '';

                                ?>
                                <tr>
                                    <td><?= $p->products->name; ?>
                                    </td>
                                    <td>
                                        <?php
                                        if (isset($flavors)) :
                                            $flavorsCount = 0;
                                            $listflavors = '';
                                            foreach ($flavors as $value) {
                                                if ($value->id_orders_items == $p->id) :
                                                    $listflavors = $listflavors . ' ' . $value->flavors->flavor . ', ';
                                                    $flavorsCount = 1;
                                                endif;
                                            }
                                            if ($flavorsCount == 1) :
                                                echo '<b>Sabor: </b>' . substr($listflavors, 0, -2) . '<br>';
                                            endif;
                                        endif;

                                        if (isset($optional)) :

                                            $listoptional = '';
                                            $listoptionalCount = 0;
                                            foreach ($optional as $value) {
                                                if ($value->id_orders_items == $p->id) :
                                                    $listoptional = $listoptional . ' ' . $value->options->item . ', ';
                                                    $listoptionalCount = 1;
                                                endif;
                                            }
                                            if ($listoptionalCount == 1) :
                                                echo '<b>Opcional: </b>' . substr($listoptional, 0, -2) . '<br>';
                                            endif;
                                        endif;

                                        if (isset($additionals)) :

                                            $listadditionals = '';
                                            $additionalsCount = 0;
                                            foreach ($additionals as $value) {
                                                //  var_dump($value->additional);
                                                if ($value->id_orders_items == $p->id) :
                                                    $listadditionals = $listadditionals . ' ' . $value->additional->amount . ' X ' . $value->additional->additional . ', ';
                                                    $price_additional += $value->additional->amount * $value->additional->price;
                                                    $additionalsCount = 1;
                                                endif;
                                            }
                                            if ($additionalsCount == 1) :
                                                echo '<b>Adicional: </b> <b>R$: ' . str_price($price_additional) . '</b>' . substr($listadditionals, 0, -2) . '<br>';
                                            endif;

                                        endif;
                                        $listadditionals = '';

                                        if ($p->request_observation != ""):
                                            echo '<b>Observação: ' . $p->request_observation . '</b>';
                                        endif;
                                        ?>

                                    </td>
                                    <td>R$ <?= str_price($p->products->price); ?></td>
                                    <td><?= $p->product_amount; ?></td>
                                    <td>
                                        R$ <?= str_price($p->product_amount * ($p->products->price + $price_additional)); ?></td>
                                </tr>
                                <?php
                                $price_additional = 0;
                            endforeach;
                            ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <p><b>Taxa de Entrega</b>: R$ <?= str_price($orders->delivery_rate); ?></p>
                        </div>

                        <div class="col-md-3">
                            <p><b>Desconto</b>: R$ <?= str_price($orders->discount); ?></p>
                        </div>

                        <div class="col-md-3">
                            <p><b>Cupom</b>: <?= ($orders->coupon); ?></p>
                        </div>

                        <div class="col-md-3">
                            <p><b>Forma de pagamento</b>: <?= paymentFormat($orders->payment_method); ?></p>
                        </div>
                        <?php
                        if ($orders->thing >1):
                            ?>
                            <div class="col-md-3">
                                <p><b>Troco para</b>: <?= ($orders->thing); ?></p>
                            </div>
                        <?php endif; ?>

                        <div class="col-md-3">
                            <p><b>Total Produtos</b>: R$ <?= str_price($orders->total_orders); ?></p>
                        </div>

                        <div class="col-md-3">
                            <p><b>Situação</b>: <?= setStatusOrders($orders->status); ?></p>
                        </div>

                        <div class="col-md-6">
                            <p><b>Observação</b>: <?= $orders->request_observation; ?></p>
                        </div>
                        <div class="col-md-3">
                            <p><b>Total Pedido + Taxa</b>:
                                R$ <?= str_price(($orders->total_orders + $orders->delivery_rate - $orders->discount)); ?></p>
                        </div>
                        <div class="col-md-12">
                            <a href="<?= url("{$enterprise->slug}/my-request/{$orders->transaction_key}#print");?>" target="_blank" class="btn btn-primary print">Imprimir</a>
                            <a href="<?= url('/admin/dash/home') ?>" class=" btn btn-warning print">Voltar</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

    </div>

    <div class="container-fluid  csw-print" style="display: none; ">
        <div class="row">
            <div class="col-md-12">
                <h3><?= $enterprise->enterprise; ?></h3>
                <div><b>Pedido</b>: <?= $orders->id; ?></div>
                <div><b>Data do pedido</b>: <?= date("d/m/Y H:i", strtotime($orders->created)); ?></div>
                <div><b>Cliente</b>: <?= $client->client; ?></div>
                <div><b>Endereço</b>: <?= $client->address; ?> - <?= $client->number; ?>
                    , <?= $client->complement; ?> - <?= $client->neighborhood; ?>
                </div>
                <div><b>Telefone</b>: <?= $client->whatsapp; ?></div>
                <div style="margin-bottom: 7px;"><b>Pontos</b>:<?= $client->points; ?></div>

                <div class="delivery">
                    <div class="row">
                        <div class="col-md-2"><b>Produto</b></div>
                        <div class="col-md-5"><b>Descrição</b></div>
                        <!--  <div class="col-md-4"><b>Descrição</b></div>-->
                        <div class="col-md-2"><b>Unitário</b></div>
                        <div class="col-md-1 text-center"><b>Quant.</b></div>
                        <div class="col-md-2"><b>Total</b></div>
                    </div>
                    <!--
                        <div class="row">
                            <?php
                    foreach ($items as $p) :
                        ?>
                                <div class="col-md-8" style="border-bottom: 1px solid #e4e1e1;">
                                    <?= $p->amount; ?> - <?= $p->products->products; ?><br>
                                     <?= $p->flavor; ?>
                                </div>

                                <div class="col-md-3" style="border-bottom: 1px solid #e4e1e1;">R$ <?= str_price($p->price_item); ?></div>
                            <?php
                    endforeach;
                    ?>
                        </div>
                        -->
                    <div class="row">
                        <?php
                        foreach ($items as $p) :
                            $price_product = '';
                            $price_additional = 0;
                            $listflavors = '';

                            ?>
                            <div class="col-md-2" style="border-bottom: 1px solid #e4e1e1;">
                                <?= $p->product_amount; ?> X <?= $p->products->name; ?>
                            </div>
                            <div class="col-md-5" style="border-bottom: 1px solid #e4e1e1;">
                                <?php

                                if (isset($flavors)) :
                                    $flavorsCount = 0;
                                    $listflavors = '';
                                    foreach ($flavors as $value) {
                                        if ($value->id_orders_items == $p->id) :
                                            $listflavors = $listflavors . ' ' . $value->flavors->flavor . ', ';
                                            $flavorsCount = 1;
                                        endif;
                                    }
                                    if ($flavorsCount == 1) :
                                        echo '<b>Sabor: </b>' . substr($listflavors, 0, -2);
                                    endif;
                                endif;

                                if (isset($optional)) :
                                    echo '<br>';
                                    $listoptional = '';
                                    $listoptionalCount = 0;
                                    foreach ($optional as $value) {
                                        if ($value->id_orders_items == $p->id) :
                                            $listoptional = $listoptional . ' ' . $value->options->item . ', ';
                                            $listoptionalCount = 1;
                                        endif;
                                    }
                                    if ($listoptionalCount == 1) :
                                        echo '<b>Opcional: </b>' . substr($listoptional, 0, -2);
                                    endif;
                                endif;

                                if (isset($additionals)) :
                                    echo '<br>';
                                    $listadditionals = '';
                                    $additionalsCount = 0;
                                    foreach ($additionals as $value) {
                                        //  var_dump($value->additional);
                                        if ($value->id_orders_items == $p->id) :
                                            $listadditionals = $listadditionals . ' ' . $value->additional->amount . ' X ' . $value->additional->additional . ', ';
                                            $price_additional += $value->additional->amount * $value->additional->price;
                                            $additionalsCount = 1;
                                        endif;
                                    }
                                    if ($additionalsCount == 1) :
                                        echo '<b>Adicional: </b> <b>R$: ' . str_price($price_additional) . '</b>' . substr($listadditionals, 0, -2);
                                    endif;

                                endif;
                                $listadditionals = '';
                                if ($p->request_observation != ""):
                                    echo '<br><b>Observação: ' . $p->request_observation . '</b>';
                                endif;
                                ?>
                            </div>
                            <div class="col-md-2" style="border-bottom: 1px solid #e4e1e1;">
                                R$ <?= str_price($p->products->price); ?>
                            </div>
                            <div class="col-md-1 text-center" style="border-bottom: 1px solid #e4e1e1;">
                                <?= $p->product_amount; ?>
                            </div>
                            <div class="col-md-2" style="border-bottom: 1px solid #e4e1e1;">
                                R$ <?= str_price($p->product_amount * ($p->products->price + $price_additional)); ?>
                            </div>
                            <?php

                            $price_additional = 0;
                        endforeach;
                        ?>
                    </div>

                    <div class="row" style="margin-top:10px;">

                        <div class="col-md-12"><b>Taxa de Entrega</b>: R$ <?= str_price($orders->delivery_rate); ?>
                        </div>
                        <div class="col-md-12"><b>Desconto</b>: R$ <?= str_price($orders->discount); ?></div>
                        <div class="col-md-12"><b>Total pago</b>: R$ <?= str_price($orders->total_orders); ?></div>
                        <div class="col-md-12"><b>F. de Pagamento</b>: <?= paymentFormat($orders->payment_method); ?>
                        </div>
                        <div class="col-md-12"><b>Troco para</b>: R$ <?= str_price($orders->thing); ?></div>
                        <div class="col-md-12"><b>Total Pedido + Taxa</b>:
                            R$ <?= str_price(($orders->total_orders + $orders->delivery_rate)); ?></div>

                        <div class="col-md-12 "><span class="csw-center" "><b>Observação</b></span>
                            <p><?= $orders->observation; ?></p>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <div class="container-fluid  csw-print" style="display: none; ">
        <div class="row">
            <div class="col-md-12">
                <h3><?= $enterprise->enterprise; ?></h3>
                <div><b>Pedido</b>: <?= $orders->id; ?></div>
                <div><b>Data do pedido</b>: <?= date("d/m/Y H:i", strtotime($orders->created)); ?></div>
                <div><b>Cliente</b>: <?= $client->client; ?></div>
                <div><b>Endereço</b>: <?= $client->address; ?> - <?= $client->number; ?>
                    , <?= $client->complement; ?> - <?= $client->neighborhood; ?>
                </div>
                <div><b>Telefone</b>: <?= $client->whatsapp; ?></div>
                <div style="margin-bottom: 7px;"><b>Pontos</b>:<?= $client->points; ?></div>

                <div class="delivery">
                    <div class="row">
                        <div class="col-md-2"><b>Produto</b></div>
                        <div class="col-md-5"><b>Descrição</b></div>
                        <!--  <div class="col-md-4"><b>Descrição</b></div>-->
                        <div class="col-md-2"><b>Unitário</b></div>
                        <div class="col-md-1 text-center"><b>Quant.</b></div>
                        <div class="col-md-2"><b>Total</b></div>
                    </div>
                    <!--
                        <div class="row">
                            <?php
                    foreach ($items as $p) :
                        ?>
                                <div class="col-md-8" style="border-bottom: 1px solid #e4e1e1;">
                                    <?= $p->amount; ?> - <?= $p->products->products; ?><br>
                                     <?= $p->flavor; ?>
                                </div>

                                <div class="col-md-3" style="border-bottom: 1px solid #e4e1e1;">R$ <?= str_price($p->price_item); ?></div>
                            <?php
                    endforeach;
                    ?>
                        </div>
                        -->
                    <div class="row">
                        <?php
                        foreach ($items as $p) :
                            $price_product = '';
                            $price_additional = 0;
                            $listflavors = '';

                            ?>
                            <div class="col-md-2" style="border-bottom: 1px solid #e4e1e1;">
                                <?= $p->product_amount; ?> X <?= $p->products->name; ?>
                            </div>
                            <div class="col-md-5" style="border-bottom: 1px solid #e4e1e1;">
                                <?php

                                if (isset($flavors)) :
                                    $flavorsCount = 0;
                                    $listflavors = '';
                                    foreach ($flavors as $value) {
                                        if ($value->id_orders_items == $p->id) :
                                            $listflavors = $listflavors . ' ' . $value->flavors->flavor . ', ';
                                            $flavorsCount = 1;
                                        endif;
                                    }
                                    if ($flavorsCount == 1) :
                                        echo '<b>Sabor: </b>' . substr($listflavors, 0, -2);
                                    endif;
                                endif;

                                if (isset($optional)) :
                                    echo '<br>';
                                    $listoptional = '';
                                    $listoptionalCount = 0;
                                    foreach ($optional as $value) {
                                        if ($value->id_orders_items == $p->id) :
                                            $listoptional = $listoptional . ' ' . $value->options->item . ', ';
                                            $listoptionalCount = 1;
                                        endif;
                                    }
                                    if ($listoptionalCount == 1) :
                                        echo '<b>Opcional: </b>' . substr($listoptional, 0, -2);
                                    endif;
                                endif;

                                if (isset($additionals)) :
                                    echo '<br>';
                                    $listadditionals = '';
                                    $additionalsCount = 0;
                                    foreach ($additionals as $value) {
                                        //  var_dump($value->additional);
                                        if ($value->id_orders_items == $p->id) :
                                            $listadditionals = $listadditionals . ' ' . $value->additional->amount . ' X ' . $value->additional->additional . ', ';
                                            $price_additional += $value->additional->amount * $value->additional->price;
                                            $additionalsCount = 1;
                                        endif;
                                    }
                                    if ($additionalsCount == 1) :
                                        echo '<b>Adicional: </b> <b>R$: ' . str_price($price_additional) . '</b>' . substr($listadditionals, 0, -2);
                                    endif;

                                endif;
                                $listadditionals = '';
                                if ($p->request_observation != ""):
                                    echo '<br><b>Observação: ' . $p->request_observation . '</b>';
                                endif;
                                ?>
                            </div>
                            <div class="col-md-2" style="border-bottom: 1px solid #e4e1e1;">
                                R$ <?= str_price($p->products->price); ?>
                            </div>
                            <div class="col-md-1 text-center" style="border-bottom: 1px solid #e4e1e1;">
                                <?= $p->product_amount; ?>
                            </div>
                            <div class="col-md-2" style="border-bottom: 1px solid #e4e1e1;">
                                R$ <?= str_price($p->product_amount * ($p->products->price + $price_additional)); ?>
                            </div>
                            <?php

                            $price_additional = 0;
                        endforeach;
                        ?>
                    </div>

                    <div class="row" style="margin-top:10px;">

                        <div class="col-md-12"><b>Taxa de Entrega</b>: R$ <?= str_price($orders->delivery_rate); ?>
                        </div>
                        <div class="col-md-12"><b>Desconto</b>: R$ <?= str_price($orders->discount); ?></div>
                        <div class="col-md-12"><b>Total pago</b>: R$ <?= str_price($orders->total_orders); ?></div>
                        <div class="col-md-12"><b>F. de Pagamento</b>: <?= paymentFormat($orders->payment_method); ?>
                        </div>
                        <div class="col-md-12"><b>Troco para</b>: R$ <?= str_price($orders->thing); ?></div>
                        <div class="col-md-12"><b>Total Pedido + Taxa</b>:
                            R$ <?= str_price(($orders->total_orders + $orders->delivery_rate)); ?></div>

                        <div class="col-md-12 "><span class="csw-center"><b>Observação</b></span>
                            <p><?= $orders->observation; ?></p>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <div class=" csw-go-back">
        <a href="" class="btn btn-primary">Voltar</a>
    </div>
<?php $v->start("scripts"); ?>
 
    <script>
        $(function () {

          
            //IMPRIMI AO ABRIR O NAVEGADOR
            var print = localStorage.getItem('print');
            if (print) {
                $(".csw-print, .csw-go-back").css("display", "block");
                $('.remove, .sticky-footer').css("display", "none");
                $('ul').remove();
                window.print();
                localStorage.clear();
            }
            //IMPRIMI AO SOLICITAR IMPRESSÃO
            $(".jsc-print").click(function () {
                $(".csw-print, .csw-go-back").css("display", "block");
                $('.remove, .sticky-footer').css("display", "none");
                $('ul').remove();
                window.print();
                return false;
            });

            $(".csw-go-back").click(function () {
                window.history.back();

            });
        });



    </script>
<?php $v->end(); ?>