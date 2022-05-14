<?php
if (!$product) : ?>

    <div class="tab-pane fade show active ajax-form-student" id="home" role="tabpanel" aria-labelledby="home-tab">

        <!--ACTION SPOOFING-->
        <input type="hidden" name="action" value="create" />
        <div class="row">
            <div class="col-lg-4 col-xl-3 order-1">
                <figure class="figure">
                    <img src="#" class="image" alt="Produto" default="">
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
                    <div class="form-group col-md-3">
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

                    <div class="form-group col-md-3">
                        <label for="genre">Valor</label>
                        <input type="text" name="price" placeholder="Informe o valor" class="form-control mask-money" required>
                    </div>


                    <div class="form-group col-md-3">
                        <label for="genre">Status</label>
                        <select name="status" id="" class="form-control">
                            <option value="active">Ativo</option>
                            <option value="inactive">Inativo</option>
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="genre">Promoção</label>
                        <select name="promotion" id="" class="form-control">
                            <option value="no">Não</option>
                            <option value="yes">Sim</option>
                        </select>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="exampleFormControlTextarea1">Descrição</label>
                        <textarea class="form-control" name="description" rows="3"></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label for="photo">Imagem do produto</label>
                    <input type="file" name="image" accept="image/jpeg, image/jpg, image/png" id="photo" class="form-control-file wc_loadimage">
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-10">
            </div>
            <div class="col-md-2 text-right">
                <a class="btn btn-info btn-right tab-button nav-link" data-next="#flavor-tab" data-toggle="tab" href="#flavor" role="tab" aria-controls="flavor" aria-selected="true">PRÓXIMO</a>
            </div>
        </div>
    </div>
    <div class="tab-pane fade show ajax-form-student" id="flavor" role="tabpanel" aria-labelledby="flavor-tab">
        <!-- TAB NEW FLAVOR -->
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="genre">Sabores</label>
                <select name="flavors" id="" class="form-control jsc-flavors" require>
                    <option value="no">Não</option>
                    <option value="yes">Sim</option>
                </select>
            </div>

            <div class="form-group col-md-6 ds-none jsc-max-flavors">
                <label for="genre">Qtd. Sabores</label>
                <input type="tel" name="max_flavors" placeholder="Informe a quantidade de sabores" class="form-control">
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">

            </div>
            <div class="col-md-4 ds-none-tab-flavor" id="modal-flavor-add">
                <h3>SABORES ATIVOS</h3>
                <?php foreach ($flavors as  $f) : ?>
                    <span id="<?= $f->id; ?>" data-name="<?= $f->flavor; ?>" data-id="<?= $f->id; ?>" class="btn btn-block btn-light js-flavor-add"><?= $f->flavor; ?> &nbsp; <i class="fas fa-angle-double-right"></i></span>
                <?php endforeach; ?>
            </div>
            <div class="col-md-4  ds-none-tab-flavor" id="modal-flavor-rm">
                <h3>SABORES INATIVOS</h3>

            </div>
            <div class="col-md-2">

            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-10">
            </div>
            <div class="col-md-2 text-right">
                <a class="btn btn-info btn-right tab-button nav-link" data-next="#options-tab" data-toggle="tab" href="#options" role="tab" aria-controls="options" aria-selected="true">PRÓXIMO</a>
            </div>
        </div>
    </div>
    <div class="tab-pane fade show ajax-form-student" id="options" role="tabpanel" aria-labelledby="options-tab">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="genre">Opcionais</label>
                <select name="option" class="form-control jsc-option" require>
                    <option value="no">Não</option>
                    <option value="yes">Sim</option>
                </select>
            </div>

            <div class="form-group col-md-6 ds-none jsc-max-option">
                <label for="genre">Qtd. Máxima</label>
                <input type="text" name="max_option" placeholder="Informe a quantidade máxima" class="form-control">
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-10">
            </div>
            <div class="col-md-2 text-right">
                <a class="btn btn-info btn-right tab-button nav-link" data-next="#additional-tab" data-toggle="tab" href="#additional" role="tab" aria-controls="additional" aria-selected="true">PRÓXIMO</a>
            </div>
        </div>
    </div>
    <div class="tab-pane fade show ajax-form-student" id="additional" role="tabpanel" aria-labelledby="additional-tab">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="genre">Adicionais</label>
                <select name="additional" id="" class="form-control jsc-additional" require>
                    <option value="no">Não</option>
                    <option value="yes">Sim</option>
                </select>
            </div>

            <div class="form-group col-md-6 ds-none jsc-max-additional">
                <label for="genre">Qtd. Máxima</label>
                <input type="tel" name="max_additional" placeholder="Informe o valor" class="form-control">
            </div>
        </div>
        <hr>
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
    </div>
<?php
else : ?>
    <div class="tab-pane fade show active ajax-form-student" id="home" role="tabpanel" aria-labelledby="home-tab">
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

                    <div class="form-group col-md-3">
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
                    <div class="form-group col-md-3">
                        <label for="genre">Valor</label>
                        <input type="text" name="price" value="<?= $product->price; ?>" placeholder="Informe o valor" class="form-control mask-money" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="genre">Status</label>
                        <select name="status" class="form-control">
                            <option value="active" <?= $product->status == 'active' ? 'selected' : ''; ?>>
                                Ativo
                            </option>
                            <option value="inactive" <?= $product->status == 'inactive' ? 'selected' : ''; ?>>Inativo</option>
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="genre">Promoção</label>
                        <select name="promotion" id="" class="form-control">
                            <option value="no" <?= $product->promotion == 'no' ? 'selected' : ''; ?>>Não</option>
                            <option value="yes" <?= $product->promotion == 'yes' ? 'selected' : ''; ?>>Sim</option>
                        </select>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="exampleFormControlTextarea1">Descrição</label>
                        <textarea class="form-control" name="description" rows="8"><?= $product->description; ?></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label for="photo">Imagens do produto</label>
                    <input type="file" name="image" accept="image/jpeg, image/jpg, image/png" class="form-control-file wc_loadimage">
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-10">
            </div>
            <div class="col-md-2 text-right">
                <a class="btn btn-info btn-right tab-button nav-link" data-next="#flavor-tab" data-toggle="tab" href="#flavor" role="tab" aria-controls="flavor" aria-selected="true">PRÓXIMO</a>
            </div>
        </div>
    </div>
    <div class="tab-pane fade show ajax-form-student" id="flavor" role="tabpanel" aria-labelledby="flavor-tab">
        <!-- TAB NEW FLAVORS -->
        <div class="form-row">
            <div class="form-group col-md-3">
                <label for="genre">Sabores</label>
                <select name="flavors" id="" class="form-control jsc-flavors" require>
                    <option value="no" <?= $product->flavors == 'no' ? 'selected' : ''; ?>>Não</option>
                    <option value="yes" <?= $product->flavors == 'yes' ? 'selected' : ''; ?>>Sim</option>
                </select>
            </div>

            <div class="form-group col-md-3 jsc-max-flavors <?= $product->flavors == 'no' ? 'ds-none' : ''; ?>">
                <label for="genre">Qtd. Sabores</label>
                <input type="tel" name="max_flavors" value="<?= $product->max_flavors; ?>" placeholder="Informe a quantidade de sabores" class="form-control">
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">

            </div>
            <div class="col-md-4 ds-none-tab-flavor<?= $product->flavors == 'not' ? 'ds-none-tab-flavor' : ''; ?>" id="modal-flavor-add">
                <h3>SABORES ATIVOS</h3>
                <?php foreach ($flavorsActive as  $f) : ?>
                    <span id="<?= $f->id; ?>" data-name="<?= $f->flavor; ?>" data-id="<?= $f->id; ?>" class="btn btn-block btn-light js-flavor-add"><?= $f->flavor; ?> &nbsp; <i class="fas fa-angle-double-right"></i></span>
                <?php endforeach; ?>
            </div>
            <div class="col-md-4  ds-none-tab-flavor<?= $product->flavors == 'not' ? 'ds-none-tab-flavor' : ''; ?>" id="modal-flavor-rm">
                <h3>SABORES INATIVOS</h3>
                <?php foreach ($flavorsDesable as  $f) : ?>
                    <span id="<?= $f->id; ?>" data-name="<?= $f->flavor; ?>" data-id="<?= $f->id; ?>" class="btn btn-block btn-light js-flavor-rm"><i class="fas fa-angle-double-left"></i> &nbsp; <?= $f->flavor; ?></span>
                <?php endforeach; ?>
            </div>
            <div class="col-md-2">

            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-10">
            </div>
            <div class="col-md-2 text-right">
                <a class="btn btn-info btn-right tab-button nav-link" data-next="#options-tab" data-toggle="tab" href="#options" role="tab" aria-controls="options" aria-selected="true">PRÓXIMO</a>
            </div>
        </div>
    </div>
    <div class="tab-pane fade show ajax-form-student" id="options" role="tabpanel" aria-labelledby="options-tab">
        <div class="form-row">

            <div class="form-group col-md-3">
                <label for="genre">Opcionais</label>
                <select name="option" class="form-control jsc-option" require>
                    <option value="no" <?= $product->option == 'no' ? 'selected' : ''; ?>>Não</option>
                    <option value="yes" <?= $product->option == 'yes' ? 'selected' : ''; ?>>Sim</option>
                </select>
            </div>

            <div class="form-group col-md-3  jsc-max-option <?= $product->option == 'no' ? 'ds-none' : ''; ?>">
                <label for="genre">Qtd. Máxima</label>
                <input type="text" name="max_option" value="<?= $product->max_option; ?>" placeholder="Informe a quantidade máxima" class="form-control">
            </div>
        </div>

        <hr>
        <div class="row">
            <div class="col-md-10">
            </div>
            <div class="col-md-2 text-right">
                <a class="btn btn-info btn-right tab-button nav-link" data-next="#additional-tab" data-toggle="tab" href="#additional" role="tab" aria-controls="additional" aria-selected="true">PRÓXIMO</a>
            </div>
        </div>
    </div>
    <div class="tab-pane fade show ajax-form-student" id="additional" role="tabpanel" aria-labelledby="additional-tab">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="genre">Adicionais</label>
                <select name="additional" id="" class="form-control jsc-additional" require>
                    <option value="no" <?= $product->additional == 'no' ? 'selected' : ''; ?>>Não</option>
                    <option value="yes" <?= $product->additional == 'yes' ? 'selected' : ''; ?>>Sim</option>
                </select>
            </div>

            <div class="form-group col-md-6 jsc-max-additional <?= $product->additional == 'no' ? 'ds-none' : ''; ?>">
                <label for="genre">Qtd. Máxima</label>
                <input type="tel" name="max_additional" value="<?= $product->max_additional; ?>" placeholder="Informe o valor" class="form-control">
            </div>
        </div>
        <hr>
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
    </div>
<?php
endif; ?>