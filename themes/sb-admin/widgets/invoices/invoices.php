<?php $v->layout("_admin"); ?>

<div class="container-fluid">

    <?php
    $item = null;
    if (!$item) : ?>
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-fw fa-building"></i>
                Inserir saldo
            </h1>
        </div>

        <form action="<?= url("/admin/enterprise/invoice/create"); ?>" method="post">
            <!--ACTION SPOOFING-->
            <input type="hidden" name="action" value="create" />

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="first_name">Adicionar crédito</label>
                    <input type="text" name="invoice" placeholder="Adicionar crédito" class="form-control mask-money" required>
                </div>
            </div>

            <div class="form-group text-left">
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
                <a href="<?= url("/admin/options/option"); ?>" class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="text">Novo item opcional</span>
                </a>
            </div>
        </div>

        <form action="<?= url("/admin/options/option/{$item->id}"); ?>" method="post">
            <!--ACTION SPOOFING-->
            <p><a href="<?= url("/admin/options/home"); ?>">Itens</a></p>

            <input type="hidden" name="action" value="update" />

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="first_name">Item opcional</label>
                    <input type="text" name="item" value="<?= $item->item; ?>" placeholder="Item opcional" class="form-control" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="inputState">Categoria</label>
                    <select id="inputState" name="category_id" class="form-control" required>
                        <?php
                        foreach ($categories as $p) :
                        ?>
                            <option value="<?= $p->id; ?>" <?= $p->id == $item->category_id ? 'selected' : ''; ?>><?= $p->category; ?></option>
                        <?php
                        endforeach;
                        ?>
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label for="inputState">Status</label>
                    <select id="inputState" name="status" class="form-control" required>
                        <?php
                        foreach (statusOptionsItems() as $key => $value) :
                        ?>
                            <option value="<?= $key; ?>" <?= $key == $item->status ? 'selected' : ''; ?> ><?= $value; ?></option>
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
            </div>
        </form>
    <?php endif; ?>
</div>