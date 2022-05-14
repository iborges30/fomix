<?php $v->layout("_admin"); ?>

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-fw fa-user"></i>
            Meus Posts
        </h1>
        <div class="form-group text-right">
            <a href="<?=url("/admin/feed/create");?>" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Novo post</span>
            </a>
        </div>
    </div>

    <div class="row">
        <?php
        if (!empty($feed)):
            foreach ($feed as $p):
                ?>
                <div class="col-md-6 col-lg-4 col-xl-3 d-flex">
                    <article class="card text-center mb-4 w-100">
                        <div class="card-body">
                            <figure>
                                <?= photo_img($p->image, $p->description, 128, 128, CONF_IMAGE_DEFAULT_AVATAR, "rounded-circle mx-auto", "width: 128px"); ?>
                            </figure>
                            <h6 class="card-subtitle mb-2 text-muted">
                                <i class="fas fa-user-plus"></i>
                                <?= $p->views;?>
                            </h6>
                            <h3 class="card-title h5">  <?= $p->description;?></h3>

                            <a href="<?=url("/admin/feed/create/{$p->uuid}");?>"
                               class="btn btn-sm btn-info btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fas fa-cog"></i>
                            </span>
                                <span class="text">Editar</span>
                            </a>


                            <a href="#" class="btn btn-danger btn-icon-split"
                               data-post="<?= url("/admin/feed/delete/{$p->uuid}"); ?>"
                               data-action="delete"
                               data-confirm="ATENÇÃO: Tem certeza que deseja excluir este post? Essa ação não pode ser feita!"
                               data-post_id="<?= $p->id; ?>">
                        <span class="icon text-white-50">
                            <i class="fas fa-trash"></i>
                        </span>
                                <span class="text">Excluir</span>
                            </a>

                        </div>
                        <div class="card-footer">
                            <small class="text-muted">
                                <?= date_fmt_br($p->created);?> </small>
                        </div>
                    </article>
                </div>
            <?php
            endforeach;
        endif;
        ?>
    </div>
    <?= $paginator; ?>
</div>