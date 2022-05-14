<?php $v->layout("_admin"); ?>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-pizza-slice"></i>
          Minhas entregas
        </h1>

    </div>

    <?php
    if ($deliveries) :
    ?>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Meus sabores</h6>
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
                                            <th>Data</th>
                                            <th>Destino</th>
                                            <th>Valor</th>
                                            <th>Status</th>
                                            <th>Gerenciar</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    foreach ($deliveries as $p) :
                                    ?>
                                        <tr role="row">
                                            <td><?= $p->id; ?></td>
                                            <td><?= date_fmt_br($p->created); ?></td>
                                            <td><?= $p->arrival ?></td>
                                            <td>R$ <?= str_price($p->race_price + $p->commission); ?></td>
                                            <td><?= statusRace($p->status); ?></td>
                                            <td>
                                                <a href="<?= url("/admin/riders/rider/{$p->id}/".base64_encode($p->status));?>"
                                                   class="btn btn-info btn-circle" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php
                                    endforeach;
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--paginação -->
                    <?= $paginator; ?>
                </div>
            <?php else : ?>
                <?= alert_info("Ainda não entregas criadas", "w-50"); ?>
            <?php endif; ?>
            </div>
        </div>
</div>