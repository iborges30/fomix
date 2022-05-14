<?php $v->layout("_admin"); ?>

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-fw fa-comment"></i>
            Cupons
        </h1>

        <div class="form-group text-right">
            <a href="<?= url("/admin/faq/channel"); ?>" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-plus-circle"></i>
                </span>
                <span class="text">Novo Cupon</span>
            </a>
        </div>
    </div>

    <?php if ($item):        ?>
        <div class="card mb-4 p-3 border-left-primary">
            <div class="row no-gutters">
                <div class="col-md-5 align-self-center text-center">
                    <div class="card-body">
                        <h3 class="card-title H5"><?= $item->name ?></h3>
                        <p class="card-text"><?= $item->name ?></p>

                        <a href="<?= url("admin/coupons/coupons/{$item->id}"); ?>" class="btn btn-info btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fas fa-pen-alt"></i>
                            </span>
                            <span class="text">Editar Cupom</span>
                        </a>
                        &nbsp;
                        <a href="<?= url("/admin/coupon/enterprise/{$item->id}"); ?>"
                           class="btn btn-primary btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fas fa-plus"></i>
                            </span>
                            <span class="text">Vincular empresa</span>
                        </a>
                    </div>
                </div>

                <div class="col-md-7">
                    <ul class="list-group list-group-flush">
                        <?php
                        if ($coupons):
                            foreach ($coupons as $p):
                                ?>
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-md-1">
                                            <a href="#"
                                               data-post="<?= url("/admin/coupon/delete/related"); ?>"
                                               data-action="delete"
                                               data-confirm="Tem certeza que deseja remover esta empresa"
                                               data-related_id="<?= $p->id;?>"
                                               class="btn btn-sm btn-danger btn-circle">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                        <div class="col-md-6">
                                            <small class="d-block mt-2 text-black-50">
                                                <?= $p->enterprise; ?>
                                            </small>
                                        </div>
                                    </div>
                                </li>
                            <?php
                            endforeach;
                        else:
                            alert_info("Ainda não existem perguntas");
                        endif;
                        ?>
                    </ul>
                </div>
            </div>
        </div>

    <?php else: ?>
        <?= alert_info("Ainda não existem canais de FAQ cadastrados.", "w-50"); ?>
    <?php endif; ?>

</div>

