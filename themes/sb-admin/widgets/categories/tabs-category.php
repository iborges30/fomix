<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
    <?php

    if (!$category) : ?>
        <!-- Page Heading -->

        <form action="<?= url("/admin/categories/category"); ?>" method="post">
            <!--ACTION SPOOFING-->
            <input type="hidden" name="action" value="create" />

            <div class="form-row">
                <div class="form-group col-md-8">
                    <label for="first_name">Categoria</label>
                    <input type="text" name="category" placeholder="Categoria" class="form-control" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="first_name">Posição</label>
                    <input type="number" name="position"
                           
                           placeholder="Ordenação da categoria"
                           class="form-control" >
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

        <?php else:  ?>
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-fw fa-building"></i>
                Atualizar categoria
            </h1>
            <div class="form-group text-right">
                <a href="<?= url("/admin/categories/category"); ?>" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                    <span class="text">Nova categoria</span>
                </a>
            </div>
        </div>

        <form action="<?= url("/admin/categories/category/{$category->id}"); ?>" method="post">
            <!--ACTION SPOOFING-->

            <input type="hidden" name="action" value="update"/>
            <div class="form-row">

                <div class="form-group col-md-8">
                    <label for="first_name">Categoria</label>
                    <input type="text" name="category"
                           value="<?= $category->category; ?>"
                           placeholder="Categoria"
                           class="form-control" required>
                </div>

                <div class="form-group col-md-4">
                    <label for="first_name">Posição</label>
                    <input type="number" name="position"
                           value="<?= $category->position; ?>"
                           placeholder="Ordenação da categoria"
                           class="form-control" required>
                </div>
            </div>

            <div class="form-group text-right">
                <button class="btn btn-success btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-check"></i>
                    </span>
                    <span class="text">Atualizar</span>
                </button>

                <a href="<?= url("/admin/categories/home"); ?>" class="btn btn-info ml-5 btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-check"></i>
                    </span>
                    <span class="text">Voltar</span>
                </a>
            </div>
        </form>
    <?php endif; ?>
</div>