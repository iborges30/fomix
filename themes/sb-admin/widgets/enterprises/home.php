<?php $v->layout("_admin"); ?>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-fw fa-building"></i>
            Minhas empresas
        </h1>

        <div class="form-group text-right">
            <a href="<?= url("/admin/enterprise/enterprises"); ?>" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-building"></i>
                </span>
                <span class="text">Nova empresa</span>
            </a>
        </div>
    </div>
    <?php if ($enterprise): ?>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Minhas empresas</h6>
            </div>
            <div class="card-body">
                <div class="row mt-3">
                    <?php
                    foreach ($enterprise as $p) :
                        ?>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="folder-item">
                                <img class="csw" src="<?= theme("/assets/images/icon-folder.png", CONF_VIEW_ADMIN); ?>"
                                     alt="csw">
                                <div class="folder-title"><?= $p->enterprise; ?></div>
                                <div class="folder-menu">
                                    <ul>
                                        <li>
                                            <a href="<?= url("/admin/enterprise/users/{$p->id}"); ?>">
                                                <i class="fas fa-user"></i> Usuários</a>
                                        </li>

                                        <li>
                                            <a href="<?= url("/admin/user/invoices/{$p->id}"); ?>">
                                                <i class="fas fa-credit-card"></i> Minha conta</a>
                                        </li>

                                        <li>
                                            <a href="<?= url("/admin/enterprise/enterprises/{$p->id}"); ?>">
                                                <i class="fas fa-edit"></i> Editar empresa</a>
                                        </li>

                                        <li>
                                            <a href="#"
                                               data-post="<?= url("/admin/entreprise/delete/{$p->id}"); ?>"
                                               data-action="delete"
                                               data-confirm="ATENÇÃO: Tem certeza que deseja excluir esta empresa e todos os dados relacionados a ela? Essa ação não pode ser feita!">
                                                <i class="fas fa-trash-restore"></i> Deletar empresa</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php
                    endforeach;
                    ?>
                </div>
                <?=  $paginator;?>
            </div>
        </div>

    <?php else: ?>
        <?= alert_info("Ainda não existem empresas cadastrados.", "w-50"); ?>
    <?php endif; ?>

</div>

