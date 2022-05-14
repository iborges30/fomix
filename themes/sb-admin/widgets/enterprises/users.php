<?php $v->layout("_admin"); ?>

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-fw fa-user"></i>
            Meus usuários
        </h1>
    </div>

<?php  if($users):?>
    <div class="row">
        <?php foreach ($users as $user): ?>
            <div class="col-md-6 col-lg-4 col-xl-3 d-flex">
                <article class="card text-center mb-4 w-100">
                    <div class="card-body">
                        <figure>
                            <?= photo_img($user->photo(), $user->fullName(), 128, 128, CONF_IMAGE_DEFAULT_AVATAR, "rounded-circle mx-auto", "width: 128px"); ?>
                        </figure>
                        <h6 class="card-subtitle mb-2 text-muted">
                            <?php if ($user->level >= 5): ?>
                                <i class="fas fa-user-plus"></i>
                                Admin
                            <?php else: ?>
                                <i class="fas fa-user"></i>
                                Usuário
                            <?php endif; ?>
                        </h6>
                        <h3 class="card-title h5"><?= $user->fullName(); ?></h3>
                        <p class="card-text small text-muted">
                            <i class="fas fa-fw fa-envelope"></i>
                            <?= $user->email; ?>
                        </p>

                        <a href="<?= url("/admin/users/user/{$user->id}"); ?>" class="btn btn-sm btn-info btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fas fa-cog"></i>
                            </span>
                            <span class="text">Gerenciar</span>
                        </a>
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

    <?= $paginator; ?>

    <?php else: ?>
                <?= alert_info("Ainda não temos usuários cadastrados no sistema cadastrados.", "w-50"); ?>
            <?php endif; ?>
</div>