<?php $v->layout("_admin"); ?>

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-fw fa-user"></i>
            Meus Usuários
        </h1>
        <div class="form-group text-right">
            <a href="<?= url("/admin/enterprise/user/newuser");?>" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Novo usuário</span>
            </a>
        </div>
    </div>
    <?php
    if ($listUsers):
        ?>
        <div class="row">
            <?php foreach ($listUsers as $user): ?>
                <div class="col-md-6 col-lg-4 col-xl-3 d-flex">
                    <article class="card text-center mb-4 w-100">
                        <div class="card-body">
                            <figure>
                                <?= photo_img($user->photo(), $user->fullName(), 128, 128, CONF_IMAGE_DEFAULT_AVATAR, "rounded-circle mx-auto", "width: 128px"); ?>
                            </figure>
                            <h6 class="card-subtitle mb-2 text-muted">
                                <?php if ($user->level >= 4): ?>
                                    <i class="fas fa-user-plus"></i>
                                    Admin
                                <?php else: ?>
                                    <i class="fas fa-user"></i>
                                    Usuário
                                <?php endif; ?>
                            </h6>
                            <h3 class="card-title h5"><?= $user->fullName(); ?></h3>
                            <span class="card-text small text-muted">
                                <i class="fas fa-fw fa-envelope"></i>
                                <?= $user->email; ?>
                            </span>
                            <br>
                            <span class="card-text small text-muted">
                                <i class="fas fa-id-card-alt"></i>
                                <?= formatDocument($user->document); ?>
                            </span>
                            <br>
                            <a href="<?= url("/admin/enterprise/user/update/".base64_encode($user->id)); ?>"
                               class="btn btn-sm btn-info btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fas fa-cog"></i>
                            </span>
                                <span class="text">Editar</span>
                            </a>
                            <?php if ($user->level >= 5): ?>
                            <a href="#"
                               data-post="<?= url("/admin/entreprise/user/delete/{$user->id}"); ?>"
                               data-action="delete"
                               data-confirm="ATENÇÃO: Tem certeza que deseja excluir o usuário e todos os dados relacionados a ele? Essa ação não pode ser feita!"
                               data-user_id="<?= $user->id; ?>"
                               class="btn btn-sm btn-warning btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fas fa-trash"></i>
                            </span>
                                <span class="text">Deletar</span>
                            </a>
                            <?php endif; ?>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">
                                Desde <?= date_fmt($user->created_at, "d.m.y \à\s H\hi"); ?>
                            </small>
                        </div>
                    </article>
                </div>
            <?php endforeach; ?>
        </div>

        <?//= $paginator; ?>
    <?php else : ?>
        <?= alert_info("Ainda não temos Usuários cadastrados no sistema cadastrados.", "w-50"); ?>
    <?php endif; ?>

</div>