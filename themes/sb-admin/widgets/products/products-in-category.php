<?php $v->layout("_admin"); ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-fw fa-building"></i>
            Categoria de produtos
        </h1>

    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Categorias de produtos</h6>
        </div>
        <div class="card-body">
            <div class="row mt-3">
                <?php if(!empty($categories)):
                    foreach($categories as $p):
                    ?>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="folder-item">
                        <a href="<?= url("/admin/products/category/{$p->id}/home");?>">
                            <img class="csw" src="<?=theme("/assets/images/icon-folder.png", CONF_VIEW_ADMIN);?>" alt="csw">
                            <div class="folder-title"><?= $p->category;?></div>
                        </a>
                    </div>
                </div>
                <?php endforeach; endif;?>
				
				<?= $paginator; ?>
            </div>
        </div>
    </div>
</div>