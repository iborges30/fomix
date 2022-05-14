<?php $v->layout("_admin"); ?>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">

        <form action="<?= url('/admin/reports/home') ?>"
              class="d-none d-sm-inline-block ml-auto ml-md-3 my-2 my-md-0 mw-100">
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="first_name">Data Inicial</label>
                    <input type="date" name="start_date" id="start_date" placeholder="Data Inicial"
                           class="form-control ">
                </div>
                <div class="form-group col-md-3">
                    <label for="first_name">Data final</label>
                    <input type="date" name="end_date" id="end_date" placeholder="Data Final"
                           class="form-control ">
                </div>

                <div class="form-group col-md-3">
                    <label for="first_name">Status</label>
                    <select class="form-control" name="status" id="status">
                        <option value="">Selecione</option>
                        <?php
                        foreach (setStatusOrders() as $key => $item):
                            ?>
                            <option value="<?= $key; ?>"><?= $item; ?></option>
                        <?php
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-3">

                    <button class="btn btn-info btn-icon-split" style="margin-top:30px;">
                        <span class="icon text-white-50">
                            <i class="fas fa-check"></i>
                        </span>
                        <span class="text">Pesquisar</span>
                    </button>

                </div>
            </div>
        </form>


    </div>

    <?php

    if (!$orders) : ?>
        <?= alert_info("Ainda não temos pedidos cadastrados no sistema.", "w-50"); ?>
    <?php else : ?>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Pedidos</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Cliente</th>
                            <th>Data</th>
                            <th>Valor</th>
                            <th>F. Pagamento</th>
                            <th>Status</th>
                            <th>Gerenciar</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Cliente</th>
                            <th>Data</th>
                            <th>Valor</th>
                            <th>F. Pagamento</th>
                            <th>Status</th>
                            <th>Gerenciar</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        <?php foreach ($orders as $p) : ?>
                            <tr>
                                <td><?= $p->id; ?></td>
                                <td><?= $p->clients->client; ?></td>
                                <td><?= date("d/m/Y H:i", strtotime($p->created)); ?> h</td>
                                <td>R$ <?= str_price(($p->delivery_rate + $p->total_orders) - $p->discount); ?></td>
                                <td> <?= paymentFormat($p->payment_method); ?></td>
                                <td>
                                    <span class="<?= setStatusOrders($p->status); ?>"><?= setStatusOrders($p->status); ?></span>
                                </td>
                                <td>


                                    <a href="<?= url("/admin/dash/orders-print/{$p->id}"); ?>"
                                       class=" btn btn-outline-info btn-circle btn-sm" title="Ver detalhes do pedido"
                                       target="_blank">
                                        <i class="fas fa-eye text-center"></i>
                                    </a>

                                </td>

                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>

                </div>
                <div class="row">
                    <?php
                    $totalPrice = 0;
                    foreach ($orders as $order) {
                        if ($order->status == 4) {
                            $totalPrice += $order->total_orders;
                        }
                    }
                    ?>
                    <div class="col-md-6">
                        <h2>Total de Pedidos: <?= count($orders) ?></h2>
                    </div>
                    <div class="col-md-6 text-right">
                        <h2>Valor Total: <?= number_format($totalPrice, 2, ',', '.'); ?></h2>
                    </div>
                </div>
            </div>
        </div>

        <!--paginator-->
        <?= $paginator; ?>

    <?php endif; ?>

</div>