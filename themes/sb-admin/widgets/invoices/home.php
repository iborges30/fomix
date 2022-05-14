<?php $v->layout("_admin"); ?>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-keyboard"></i>
            Minhas faturas
        </h1>
        <div class="form-group text-right">
            <a href="<?= url("/admin/enterprise/invoice/create"); ?>" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Adicionar Saldo</span>
            </a>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"> Minhas faturas</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div class="dataTables_wrapper dt-bootstrap4">

                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Valor</th>
                                    <th>status</th>
                                    <th>Data</th>
                                    <th>Alterar</th>
                                </tr>
                                </thead>
                                <?php
                                if (!empty($invoices)):
                                    foreach ($invoices as $p):
                                        ?>
                                        <tr role="row">
                                            <td><?= $p->id; ?></td>
                                            <td>R$ <?= str_price($p->invoice); ?></td>
                                            <td><?= invoicesStatus($p->status); ?></td>
                                            <td>
                                                <?= date_fmt_br($p->created); ?>
                                            </td>
                                            <td>
                                                <a href="<?= url("/admin/user/invoices/edit/{$p->id}"); ?>"
                                                   id="<?= $p->id; ?>"
                                                   data-status="<?= $p->status; ?>"
                                                   class="btn btn-primary btn-circle"
                                                   title="Alterar">
                                                    <i class="far fa-edit"></i>
                                                </a>

                                            </td>
                                        </tr>
                                    <?php
                                    endforeach;
                                endif;
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
                <!--paginação -->

            </div>
        </div>
    </div>
</div>