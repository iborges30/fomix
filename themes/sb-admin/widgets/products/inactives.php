<?php $v->layout("_admin"); ?>
<style>
    .capa {
        width: 100px;
        height: 100px;
        border-radius: 50%;
    }
</style>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-pizza-slice"></i>
            Produtos
        </h1>
        <div class="form-group text-right">
            <a href="<?= url("/admin/products/manager"); ?>" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Novo Produto</span>
            </a>
        </div>
    </div>

    <?php
    if ($products):
    ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Meus produtos</h6>
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

                                    <th>Capa</th>
                                    <th>Produto</th>
                                    <th>Valor</th>
                                    <th>Categoria</th>

                                    <th>Status</th>
                                    <th>Gerenciar</th>
                                </tr>
                                </thead>
                                <?php
                                foreach ($products as $p):
                                    ?>
                                    <tr role="row">

                                        <td><?= $p->code; ?></td>
                                        <td> <?= photo_img($p->image, $p->name, 100, 100, null, "capa"); ?>  </td>
                                        <td><?= $p->name; ?></td>
                                        <td>R$ <?= str_price($p->price); ?></td>
                                        <td><?= $p->product_categories->category; ?></td>

                                        <td>
                                            <span class="<?= bgStatusProducts($p->status); ?>"><?= statusProducts($p->status); ?></span>
                                        </td>
                                        <td>
                                            <a href="<?= url("/admin/products/manager/{$p->id}"); ?>"
                                               class="btn btn-info btn-circle" title="Editar">
                                                <i class="fas fa-check"></i>
                                            </a>

                                            <a href="<?= url("/admin/products/inactive/{$p->id}"); ?>"
                                               id="<?= $p->id; ?>"
                                               data-status="<?= $p->status; ?>"
                                               class="btn btn-warning btn-circle jsc-product-inacttive"
                                               title="Inativar produto">
                                                <i class="far fa-bell-slash"></i>
                                            </a>

                                            <a href="#" class="btn btn-danger btn-circle"
                                               data-post="<?= url("/admin/products/delete/{$p->id}"); ?>"
                                               data-action="delete"
                                               data-confirm="ATENÇÃO: Tem certeza que deseja excluir esta categoria os dados relacionados a ela? Essa ação não pode ser feita!"

                                            <span class="icon text-white-50">
                                                        <i class="fas fa-trash"></i>
                                                    </span>

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
            <?php else: ?>
                <?= alert_info("Ainda não temos produtos cadastrados no sistema cadastrados.", "w-50"); ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $v->start("scripts"); ?>

<script>
    $(function () {
        $(".jsc-product-inacttive").click(function () {
            var productId = $(this).attr("id");
            var uri = $(this).attr("href");
            var status = $(this).data("status");

            $.ajax({
                url: uri,
                dataType: "json",
                data: {productId: productId, status: status},
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
