


    <?php $v->layout("_admin"); ?>
<div class="container-fluid">

    <!--- MODAL  --->
    <div class="modal fade " tabindex="-1" role="dialog" id="new-category">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="border: none">
                <div class="modal-header bg-info">
                    <h5 class="modal-title" style="color: #fff;"><i class="fas fa-keyboard"></i> Nova categoria
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?= url("/admin/category/products"); ?>" name="formCategoryProducts" class="ajax_off" method="post">
                        <div class="row">
                            <div class="col-md-12 ajax_response"></div>
                        </div>
                        <div class="form-row">

                            <div class="form-group col-md-12">
                                <input type="hidden" name="action" value="createCategory">
                            </div>

                            <div class="form-group col-md-12">
                                <label for="inputEmail4">Categoria</label>
                                <input type="text" name="category" required class="form-control">
                            </div>
                        </div>
                        <button type="submit" class="jsc-send-income btn btn-primary"><i class="fas fa-keyboard"></i>
                            Nova categoria
                        </button>
                        <img class="csw-load ml-4 ds-none" src="<?= theme("/assets/images/load.gif", CONF_VIEW_ADMIN); ?>" alt="load">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--- MODAL -->

    <?php

    if (!$product) : ?>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Novo Produto</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <form action="<?= url("/admin/products/manager"); ?>" method="post" name="formProduct" class="p-2">
                        <!--ACTION SPOOFING-->
                        <input type="hidden" name="action" value="create" />
                        <div class="row">
                            <div class="col-lg-4 col-xl-3 order-1">
                                <figure class="figure">
                                    <img src="<?= theme("/assets/images/webp/no-image-available-16by9.webp", CONF_VIEW_THEME); ?>" class="image" alt="Produto" default="">
                                </figure>

                            </div>

                            <div class="col-lg-8 col-xl-9 order-2">
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label for="name">Código do produto</label>
                                        <input type="text" name="code" placeholder="Código do produto" class="form-control">
                                    </div>
                                    <div class="form-group col-md-9">
                                        <label for="name">Nome do produto</label>
                                        <input type="text" name="name" placeholder="Nome do produto" class="form-control" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="last_name">Categoria</label>
                                        <select name="category_id" class="form-control jsc-category" required>
                                            <?php
                                            foreach ($categories as $p) :
                                            ?>
                                                <option value="<?= $p->id; ?>"><?= $p->category; ?></option>
                                            <?php
                                            endforeach;
                                            ?>
                                            <option value="category">Nova categoria</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="genre">Valor</label>
                                        <input type="text" name="price" placeholder="Informe o valor" class="form-control mask-money" required>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="genre">Status</label>
                                        <select name="status" id="" class="form-control">
                                            <option value="active">Ativo</option>
                                            <option value="inactive">Inativo</option>
                                        </select>
                                    </div>


                                    <div class="form-group col-md-12">
                                        <label for="exampleFormControlTextarea1">Descrição</label>
                                        <textarea class="form-control" name="description" rows="3" required></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="photo">Imagem do produto</label>
                                    <input type="file" name="image" accept="image/jpeg, image/jpg, image/png" id="photo" class="form-control-file wc_loadimage">
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12 text-right">
                                <button class="btn btn-info btn-icon-split">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-check"></i>
                                    </span>
                                    <span class="text">Cadastrar</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php else : ?>
        <div class="align-items-center justify-content-between mb-4">
            <div class="form-group text-right">
                <a href="<?= url("/admin/products/manager"); ?>" class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="text">Novo Produto</span>
                </a>
            </div>
        </div>
        <!-- Page Heading -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Editar Produto: <?= $product->name; ?></h6>
            </div>
            <div class="card-body">
                <form action="<?= url("/admin/products/manager/{$product->id}"); ?>" method="post" name="formUpdateProduct" class="p-2" enctype="multipart/form-data">
                    <!--ACTION SPOOFING-->
                    <input type="hidden" name="action" value="update" />
                    <div class="row">
                        <div class="col-lg-4 col-xl-3 order-1">
                            <figure class="figure">
                                <?= photo_img($product->image, $product->name, 400, 400, null, "image"); ?>
                            </figure>

                        </div>

                        <div class="col-lg-8 col-xl-9 order-2">
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="name">Código do produto</label>
                                    <input type="text" name="code" value="<?= !empty($product->code) ? $product->code : $product->id; ?>" placeholder="Código do produto" class="form-control">
                                </div>
                                <div class="form-group col-md-9">
                                    <label for="name">Nome do produto</label>
                                    <input type="text" name="name" value="<?= $product->name; ?>" placeholder="Nome do produto" class="form-control" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="last_name">Categoria</label>
                                    <select name="category_id" class="form-control jsc-category" required>
                                        <?php
                                        foreach ($categories as $p) :
                                        ?>
                                            <option value="<?= $p->id; ?>" <?= $product->category_id == $p->id ? 'selected' : ''; ?>><?= $p->category; ?></option>
                                        <?php
                                        endforeach;
                                        ?>
                                        <option value="category">Nova categoria</option>
                                    </select>
                                </div>



                                <div class="form-group col-md-4">
                                    <label for="genre">Valor</label>
                                    <input type="text" name="price" value="<?= $product->price; ?>" placeholder="Informe o valor" class="form-control mask-money" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="genre">Status</label>
                                    <select name="status" class="form-control">
                                        <option value="active" <?= $product->status == 'active' ? 'selected' : ''; ?>>
                                            Ativo
                                        </option>
                                        <option value="inactive" <?= $product->status == 'inactive' ? 'selected' : ''; ?>>Inativo</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="exampleFormControlTextarea1">Descrição</label>
                                    <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3" required><?= $product->description; ?></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="photo">Imagens do produto</label>
                                <input type="file" name="image" accept="image/jpeg, image/jpg, image/png" class="form-control-file wc_loadimage">
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12 text-right">
                            <button class="btn btn-info btn-icon-split">
                                <span class="icon text-white-50">
                                    <i class="fas fa-check"></i>
                                </span>
                                <span class="text">Atualizar</span>
                            </button>
                            <a href="<?= url("/admin/products/home"); ?>" class="btn btn-warning btn-icon-split ml-4">
                                <span class="text">Voltar</span>
                            </a>
                        </div>
                    </div>
                </form>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <p>Adicionas </p>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

</div>
<?= $v->start("scripts"); ?>

<script>
    //ABRE A MODAL PARA GERAR NOVA CATEGORIA
    $(".jsc-category").change(function() {
        var category = $(this).val();
        if (category === 'category') {
            $('#new-category').modal("show");
        }
    });

    //GERA A NOVA CATEGORIA
    $("form[name='formCategoryProducts']").submit(function() {
        var dados = $(this).serialize();
        var url = $(this).attr("action");

        $.ajax({
            url: url,
            method: 'post',
            dataType: 'json',
            data: dados,
            beforeSend: function() {
                $(".csw-load").fadeIn("fast");
            },
            success: function(response) {
                if (response.message == 'error') {
                    alert("Verifique o nome da categoria informada, possívelmente ela já existe no sistema.");
                } else {
                    $("#new-category").modal("hide");
                    $(".jsc-category").append("<option selected value='" + response.value + "'>" + response.name + "</option>");
                }
            },
            complete: function() {
                $(".csw-load").fadeOut("fast");
            }
        });

        return false;
    });

    //ABRE A MODAL DO FABRICANTE
    $(".jsc-brand").change(function() {
        var brand = $(this).val();
        if (brand === 'brand') {
            $('#new-brand').modal("show");
        }
    });

    $("form[name='formBrandproducts']").submit(function() {
        var dados = $(this).serialize();
        var url = $(this).attr("action");

        $.ajax({
            url: url,
            method: 'post',
            dataType: 'json',
            data: dados,
            beforeSend: function() {
                $(".csw-load").fadeIn("fast");
            },
            success: function(response) {
                if (response.message == 'error') {
                    alert("Verifique o nome do fabricante. É possívelmente ela já existe no sistema.");
                } else {
                    $("#new-brand").modal("hide");
                    $(".jsc-brand").append("<option selected value='" + response.value + "'>" + response.name + "</option>");
                }
            },
            complete: function() {
                $(".csw-load").fadeOut("fast");
            }
        });

        return false;
    });
</script>
<?= $v->end("scripts"); ?>