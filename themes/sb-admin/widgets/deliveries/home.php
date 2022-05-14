<?php $v->layout("_admin"); ?>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-fw fa-user"></i>
            Entregadores
        </h1>
    </div>
    <?php if ($deliveries): ?>
        <div class="row">
            <?php foreach ($deliveries as $user): ?>
                <div class="col-md-6 col-lg-4 col-xl-3 d-flex">
                    <article class="card text-center mb-4 w-100">
                        <div class="card-body">
                            <figure>
                                <?= photo_img($user->image, $user->fullName(), 128, 128, CONF_IMAGE_DEFAULT_AVATAR, "rounded-circle mx-auto", "width: 128px"); ?>
                            </figure>
                            <h6 class="card-subtitle mb-2 text-muted">
                                <i class="fas fa-user"></i>
                                Entregador
                            </h6>
                            <h3 class="card-title h5"><?= $user->fullName(); ?></h3>

                            <p class="card-text small text-muted">
                                <i class="fas fa-fw fa-envelope"></i>
                                <?= $user->document; ?> -  <?= vehicleType($user->vehicle); ?>
                            </p>

                            <p class="card-text small text-muted">
                                <i class="fas fa-fw fa-envelope"></i>
                                <?= ($user->status); ?>
                            </p>

                            <div class="row justify-content-between">
                                <a href="<?= url("/admin/deliveries/update/{$user->id}"); ?>"
                                   class="btn btn-sm btn-info btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fas fa-cog"></i>
                            </span>

                                    <span class="text">Editar</span>
                                </a>

                                <a href="#"
                                   class="btn btn-sm btn-danger btn-icon-split ">
                            <span class="icon text-white-50">
                                <i class="fas fa-trash"></i>
                            </span>
                                    <span class="text">Deletar</span>
                                </a>


                                <a href="<?= url("/admin/deliveries/wallet/{$user->id}");?>"
                                   class="btn btn-sm btn-primary btn-icon-split ">
                            <span class="icon text-white-50">
                                <i class="fas fa-credit-card"></i>
                            </span>
                                    <span class="text">Carteira</span>
                                </a>
                            </div>
                        </div>

                        <div class="card-footer">
                            <small class="text-muted">
                                Desde <?= date_fmt($user->created, "d.m.y \à\s H\hi"); ?>
                            </small>
                        </div>
                    </article>
                </div>
            <?php endforeach; ?>
        </div>
    <?php
    else: echo alert_info("Você ainda não tem nenhum entregador cadastrado.");
    endif;
    ?>
    <?= $paginator; ?>

</div>