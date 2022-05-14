<?php $v->layout("_admin"); ?>

<div class="container-fluid">

    <?php
    if(empty($feed)):
    ?>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-fw fa-building"></i>
           Novo post
        </h1>
    </div>
    <div class="card-body bg-white radius shadow">
        <div class="tab-content " id="myTabContent">
            <!-- CADASTRO GERAL -->
            <div class="tab-pane fade show active row" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="row">
                    <div class="col-lg-4 order-lg-2">
                        <div class="card shadow mb-4">
                            <div class="card-profile-image mt-4 col-md-12 text-center">
                                <figure class="figure">
                                    <img src="<?= theme("/assets/images/fomix.png", CONF_VIEW_THEME); ?>" alt="CSW" class="js-profile  image">
                                </figure>
                            </div>
                        </div>


                    </div>

                    <div class="col-lg-8 order-lg-1">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <form action="<?=url("/admin/feed/post");?>" method="post" name="formProduct">
                                    <input type="hidden" name="action" value="create">
                                    <div class="pl-lg-1">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group ">
                                                    <label class="form-control-label" for="name">Descrição
                                                        <span class="small text-danger">*</span></label>
                                                    <textarea name="description" class="form-control" id="" cols="30" rows="8" maxlength="255"></textarea>
                                            </div>
                                                <div class="col-md-12" style="margin-top: 30px">
                                                    <div class="form-group focused">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input wc_loadimage"
                                                                   name="image">
                                                            <label class="custom-file-label">Imagem</label>
                                                        </div>
                                                    </div>
                                                </div>

                                            <div class="col text-right" style="margin-top: 30px">
                                                <div class="form-group ">
                                                    <button type="submit" class="btn btn-success">Atualizar</button>
                                                    <a href="https://localhost/bella/admin/product/home" class="btn btn-info ml-4">Voltar</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    else:?>
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-fw fa-building"></i>
                Edit post
            </h1>
        </div>
        <div class="card-body bg-white radius shadow">
            <div class="tab-content " id="myTabContent">
                <!-- CADASTRO GERAL -->
                <div class="tab-pane fade show active row" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="row">
                        <div class="col-lg-4 order-lg-2">
                            <div class="card shadow mb-4">
                                <div class="card-profile-image mt-4 col-md-12 text-center">
                                    <figure class="figure">
                                        <?= photo_img($feed->image, $feed->description, 400, 400, null, "image"); ?>
                                    </figure>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-8 order-lg-1">
                            <div class="card shadow mb-4">
                                <div class="card-body">
                                    <form action="<?=url("/admin/feed/post/{$feed->uuid}");?>" method="post" name="formProduct">
                                        <input type="hidden" name="action" value="update">
                                        <div class="pl-lg-1">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group ">
                                                        <label class="form-control-label" for="name">Descrição
                                                            <span class="small text-danger">*</span></label>
                                                        <textarea name="description" class="form-control"  cols="30" rows="8" maxlength="255"><?= $feed->description;?></textarea>
                                                    </div>
                                                    <div class="col-md-12" style="margin-top: 30px">
                                                        <div class="form-group focused">
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input wc_loadimage"
                                                                       name="image">
                                                                <label class="custom-file-label">Imagem</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col text-right" style="margin-top: 30px">
                                                        <div class="form-group ">
                                                            <button type="submit" class="btn btn-success">Atualizar</button>
                                                            <a href="<?= url("/admin/feed/home");?>" class="btn btn-info ml-4">Voltar</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    endif;
    ?>
</div>
</div>