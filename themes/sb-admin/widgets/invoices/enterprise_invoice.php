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
                                    <th>F. Pagamento</th>
                                    <th>Data</th>
                                    <th>Info. Pagamento</th>
                                </tr>
                                </thead>

                                <?php
                                if (!empty($invoices)):
                                foreach ($invoices as $p):
                                    ?>
                                    <tr role="row">
                                        <td><?= $p->id;?></td>
                                        <td>R$ <?= str_price($p->invoice);?></td>
                                        <td><?= invoicesStatus($p->status);?></td>
                                        <td>CHAVE PIX: 005.712.691-76</td>
                                        <td>
                                            <?= date_fmt_br($p->created);?>
                                        </td>
                                        <td>
                                            <a href="https://api.whatsapp.com/send?phone=5565996622520&text=Ol%C3%A1%2C%20gostaria%20de%20informar%20o%20pagamento%20da%20fatura%20N%C2%B0<?=$p->id;?>"
                                               class=" btn btn-outline-info btn-circle btn-sm"
                                               title="Informar pagamento" target="_blank">
                                                <i class="fas fa-eye text-center"></i>
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