<?php $v->layout("_admin"); ?>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-keyboard"></i>
           Fechar lojas
        </h1>

    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Fechar lojas</h6>
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
                                    <th>Loja</th>
                                    <th>Status</th>
                                    <th>Gerenciar</th>
                                </tr>
                                </thead>
                                <?php
                                if ($enterprises) :
                                    foreach ($enterprises as $p) :
                                        ?>
                                        <tr role="row">
                                            <td><?= $p->id; ?></td>
                                            <td><?= $p->enterprise; ?></td>
                                            <td>
                                                <span class="badge  <?= $p->status == 'open' ? 'badge-success' : 'badge-warning'; ?>"><?= $p->status == 'open' ? 'Aberta' : 'Fechada'; ?></span>
                                            </td>
                                            <td>
                                                <a href="#"
                                                   data-shop-id="<?= $p->id; ?>"
                                                   data-status="<?= $p->status; ?>"
                                                   class="btn btn-info btn-circle jsc-manager" title="Editar">
                                                    <i class="fas fa-check"></i>
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
                <?= $paginator; ?>
            </div>
        </div>
    </div>
</div>
<?php $v->start("scripts"); ?>
<script>
    $(function () {
        $(".jsc-manager").click(function () {
            var shopId = $(this).data("shop-id");
            var status = $(this).data("status");

            $.ajax({
                url: '<?= url("/admin/times/close");?>',
                method: 'post',
                data: {shopId: shopId, status:status},
                dataType: 'json',
                success: function (response) {
                    if (response.redirect) {
                        location.reload();
                    }
                }
            });
        });
    });
</script>
<?php $v->end("scripts"); ?>
