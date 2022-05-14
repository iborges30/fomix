<?php $v->layout("_admin"); ?>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-keyboard"></i>
            Itens opcionais
        </h1>
        <div class="form-group text-right">
            <a href="<?= url("/admin/options/option"); ?>" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Novo item opcional</span>
            </a>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Meus itens opcionais</h6>
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
                                    <th>Item</th>
                                    <th>Categoria</th>
                                    <th>status</th>
                                    <th>Gerenciar</th>
                                </tr>
                                </thead>
                                <?php
                                if ($items) :
                                    foreach ($items as $p) :
                                        ?>
                                        <tr role="row">
                                            <td><?= $p->id; ?></td>
                                            <td><?= $p->item; ?></td>
                                            <td><?= $p->product_categories->category; ?></td>
                                            <td>
                                                <span class="badge <?= bgStatusOptionsItems($p->status); ?> "><?= statusOptionsItems($p->status); ?></span>
                                            </td>
                                            <td>
                                                <a href="<?= url("/admin/options/option/{$p->id}"); ?>"
                                                   class="btn btn-info btn-circle" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                <a href="#" class="btn btn-danger btn-circle"
                                                   data-post="<?= url("/admin/options/option/{$p->id}"); ?>"
                                                   data-action="delete"
                                                   data-confirm="ATENÇÃO: Tem certeza que deseja excluir esta categoria os dados relacionados a ela? Essa ação não pode ser feita!">
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-trash"></i>
                                                    </span>
                                                </a>


                                                <a href="<?= url("/admin/options/inactive/{$p->id}"); ?>"
                                                   class="btn btn-warning btn-circle jsc-manager-options-status"
                                                   data-status="<?= $p->status; ?>"
                                                   id="<?= $p->id; ?>"
                                                   title="Inativar produto"
                                                   data-action="Desativar">
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-check"></i>
                                                    </span>
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

<?= $v->start("scripts"); ?>

    <script>
        $(function () {
            $(".jsc-manager-options-status").click(function () {
                var optionId = $(this).attr("id");
                var uri = $(this).attr("href");
                var status = $(this).data("status");

                $.ajax({
                    url: uri,
                    dataType: "json",
                    data: {optionId: optionId, status: status},
                    method: 'post',
                    success: function (response) {
                        if (response) {
                            window.location.reload();
                        }
                    }
                });
                return false;
            });
        });
    </script>
<?= $v->end("scripts"); ?>