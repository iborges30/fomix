<?php $v->layout("_admin"); ?>

<div class="container-fluid">

    <?php

    if (!$additional) : ?>
        <!-- Page Heading -->
        <div class="d-sm-flex align-additionals-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-fw fa-building"></i>
                Novo item adicional
            </h1>
        </div>

        <form action="<?= url("/admin/additional/manager"); ?>" method="post">
            <!--ACTION SPOOFING-->
            <input type="hidden" name="action" value="create" />

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="first_name">Adicional</label>
                    <input type="text" name="additional" placeholder="item" class="form-control" required>
                </div>

                <div class="form-group col-md-2">
                    <label for="first_name">Preço</label>
                    <input type="tel" name="price" placeholder="valor do item adicional" class="form-control mask-money" required>
                </div>

                
                <div class="form-group col-md-2">
                    <label for="first_name">Qtd. Máxima por produto</label>
                    <input type="tel" name="max_additional" placeholder="Quantidade máxima permitida por produto" class="form-control" required>
                </div>


                <div class="form-group col-md-3">
                    <label for="inputState">Categoria</label>
                    <select id="inputState" name="category_id" class="form-control" required>
                        <?php
                        foreach ($categories as $p) :
                        ?>
                            <option value="<?= $p->id; ?>"><?= $p->category; ?></option>
                        <?php
                        endforeach;
                        ?>
                    </select>
                </div>

                <div class="form-group col-md-2">
                    <label for="inputState">Status</label>
                    <select id="inputState" name="status" class="form-control" required>
                        <?php
                        foreach (statusAdditionalItems() as $key => $additional) :
                        ?>
                            <option value="<?= $key; ?>"><?= $additional; ?></option>
                        <?php
                        endforeach;
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group text-right">
                <button class="btn btn-success btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-check"></i>
                    </span>
                    <span class="text">Cadastrar</span>
                </button>
            </div>
        </form>
    <?php else :  ?>
        <!-- Page Heading -->
        <div class="d-sm-flex align-additionals-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-fw fa-building"></i>
                Atualizar item
            </h1>
            <div class="form-group text-right">
                <a href="<?= url("/admin/additional/manager"); ?>" class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="text">Novo item adicional</span>
                </a>
            </div>
        </div>

        <form action="<?= url("/admin/additional/manager/{$additional->id}"); ?>" method="post">
            <!--ACTION SPOOFING-->
            <input type="hidden" name="action" value="update" />

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="first_name">Item adicional</label>
                    <input type="text" name="additional" value="<?= $additional->additional; ?>" placeholder="item " class="form-control" required>
                </div>

                <div class="form-group col-md-2">
                    <label for="first_name">Preço</label>
                    <input type="tel" name="price" placeholder="valor do item adicional"
                    
                    value="<?= str_price($additional->price); ?>"
                     class="form-control mask-money" required>
                </div>

                <div class="form-group col-md-2">
                    <label for="first_name">Qtd. Máxima por produto</label>
                    <input type="tel" name="max_additional" value="<?= $additional->max_additional; ?>" placeholder="Quantidade máxima permitida por produto" class="form-control" required>
                </div>

                <div class="form-group col-md-3">
                    <label for="inputState">Categoria</label>
                    <select id="inputState" name="category_id" class="form-control" required>
                        <?php
                        foreach ($categories as $p) :
                        ?>
                            <option value="<?= $p->id; ?>" <?= $p->id == $additional->category_id ? 'selected' : ''; ?>><?= $p->category; ?></option>
                        <?php
                        endforeach;
                        ?>
                    </select>
                </div>

                <div class="form-group col-md-2">
                    <label for="inputState">Status</label>
                    <select id="inputState" name="status" class="form-control" required>
                        <?php
                        foreach (statusAdditionalItems() as $key => $value) :
                        ?>
                            <option value="<?= $key; ?>" <?= $key == $additional->status ? 'selected' : ''; ?>><?= $value; ?></option>
                        <?php
                        endforeach;
                        ?>
                    </select>
                </div>

            </div>

            <div class="form-group text-right">
                <button class="btn btn-success btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-check"></i>
                    </span>
                    <span class="text">Atualizar</span>
                </button>

                <a class="btn btn-info btn-icon-split" href="<?= url("/admin/additional/home");?>">
                    <span class="text">Voltar</span>
                </a>
            </div>
        </form>
    <?php endif; ?>
</div>