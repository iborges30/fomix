<?php $v->layout("_admin"); ?>

<div class="container-fluid">

    <?php

    if (!$flavor) : ?>
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-fw fa-building"></i>
                Novo sabor
            </h1>
        </div>

        <form action="<?= url("/admin/flavors/manager"); ?>" method="post">
            <!--ACTION SPOOFING-->
            <input type="hidden" name="action" value="create" />
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="first_name">Sabor</label>
                    <input type="text" name="flavor" placeholder="Sabor" class="form-control" required>
                </div>


                <div class="form-group col-md-4">
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

                <div class="form-group col-md-4">
                    <label for="inputState">Status</label>
                    <select id="inputState" name="status" class="form-control" required>
                        <?php
                        foreach (statusFlavorItems() as $key => $item) :
                        ?>
                            <option value="<?= $key; ?>"><?= $item; ?></option>
                        <?php
                        endforeach;
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group col-md-12">
                <label for="inputState">Descrição</label>
                <textarea name="description" class="form-control" cols="30" rows="10"></textarea>
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
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-fw fa-building"></i>
                Atualizar item opcional
            </h1>
            <div class="form-group text-right">
                <a href="<?= url("/admin/flavors/manager"); ?>" class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="text">Novo sabor</span>
                </a>
            </div>
        </div>

        <form action="<?= url("/admin/flavors/manager/{$flavor->id}"); ?>" method="post">
            <!--ACTION SPOOFING-->
            <input type="hidden" name="action" value="update" />
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="first_name">Sabor</label>
                    <input type="text" name="flavor" value="<?= $flavor->flavor; ?>" placeholder="Sabor" class="form-control" required>
                </div>


                <div class="form-group col-md-4">
                    <label for="inputState">Categoria</label>
                    <select id="inputState" name="category_id" class="form-control" required>
                        <?php
                        foreach ($categories as $p) :
                        ?>
                            <option value="<?= $p->id; ?>" <?= $p->id == $flavor->category_id ? "selected" : ""; ?> ><?= $p->category; ?></option>
                        <?php
                        endforeach;
                        ?>
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label for="inputState">Status</label>
                    <select id="inputState" name="status" class="form-control" required>
                        <?php
                        foreach (statusFlavorItems() as $key => $item) :
                        ?>
                            <option value="<?= $key; ?>" <?= $key == $flavor->status ? "selected" : ""; ?>><?= $item; ?></option>
                        <?php
                        endforeach;
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group col-md-12">
                <label for="inputState">Descrição</label>
                <textarea name="description" class="form-control" cols="30" rows="10"> <?= $flavor->description; ?></textarea>
            </div>

            <div class="form-group text-right">
                <button class="btn btn-success btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-check"></i>
                    </span>
                    <span class="text">Atualizar</span>
                </button>
                <a href="<?= url("/admin/flavors/home");?>" class="btn btn-info btn-icon-split ml-5">
                    <span class="icon text-white-50">
                        <i class="fas fa-check"></i>
                    </span>
                    <span class="text">Voltar</span>
                </a>
            </div>
        </form>
    <?php endif; ?>
</div>