<?php $v->layout("_admin"); ?>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-puzzle-piece"></i>
            Itens adicionais
        </h1>
        <div class="form-group text-right">
            <a href="<?= url("/admin/additional/manager"); ?>" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Novo item Adicional</span>
            </a>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Meus itens adicionais</h6>
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
                                        <th>Valor</th>
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
                                            <td><?= $p->additional; ?></td>
                                            <td>R$ <?= str_price($p->price); ?></td>
                                            <td><?= $p->product_categories->category; ?></td>
                                            <td><span class="badge <?= bgStatusOptionsItems($p->status); ?> "><?= statusOptionsItems($p->status); ?></span></td>
                                            <td>
                                                <a href="<?= url("/admin/additional/manager/{$p->id}"); ?>" class="btn btn-info btn-circle" title="Editar">
                                                    <i class="fas fa-check"></i>
                                                </a>

                                                <a href="#" class="btn btn-danger btn-circle" data-post="<?= url("/admin/additional/delete/{$p->id}"); ?>" data-action="delete" data-confirm="ATENÇÃO: Tem certeza que deseja excluir esta categoria os dados relacionados a ela? Essa ação não pode ser feita!">
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-trash"></i>
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