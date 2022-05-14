<?php $v->layout("_admin"); ?>

<div class="container-fluid">
    <!-- Page Heading -->

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <form action="<?= url('/admin/sell/month') ?>"
              class="d-none d-sm-inline-block ml-auto ml-md-12 my-2 my-md-0 mw-100">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="first_name">Informe o mês e ano </label>
                    <input type="text" name="s" id="start_date" placeholder="informe uma data"
                           class="form-control mask-month" required value="<?= $data;?>">
                </div>
                <div class="form-group col-md-3">
                    <button class="btn btn-info btn-icon-split" style="margin-top:30px; margin-right: 10px;">
                        <span class="icon text-white-50">
                            <i class="fas fa-search"></i>
                        </span>
                        <span class="text ">Pesquisar</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <?php

    if (!$orders) : ?>
        <?= alert_info("Sua pesquisa não retornou nenhum resultado.", "w-50"); ?>
    <?php else : ?>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Minhas vendas em: <?= $data;?></h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Mês</th>
                            <th>Vendas no mês</th>
                            <th>Itens vendidos</th>
                            <th>Total recebido</th>

                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Mês</th>
                            <th>Vendas no mês</th>
                            <th>Itens vendidos</th>
                            <th>Total recebido</th>
                        </tr>
                        </tfoot>

                        <tbody>
                        <tr>
                            <td><?= $data; ?></td>
                            <td><?= count($orders); ?></td>

                            <?php
                            $totalItems = 0;
                            foreach ($items as $item) {
                                $totalItems += $item->product_amount;
                            }
                            ?>
                            <td><?= $totalItems; ?></td>

                            <?php
                            $totalPrice = 0;
                            foreach ($orders as $order):

                                $totalPrice += $order->total_orders + $order->delivery_rate;
                            endforeach;
                            ?>
                            <td>R$ <?= number_format($totalPrice, 2, ',', '.'); ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--paginator-->
    <?php endif; ?>

</div>