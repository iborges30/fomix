<?php $v->layout("_admin"); ?>

    <div class="container-fluid">

        <?php
        if (empty($cupom)) : ?>
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="fas fa-tags"></i>
                    Novo Cupom de desconto
                </h1>
            </div>
            <div class="card shadow">
                <div class="card-body">
                    <form action="<?= url("/admin/coupons/coupons"); ?>" method="post">
                        <!--ACTION SPOOFING-->

                        <input type="hidden" name="action" value="create"/>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="first_name">Cupom</label>
                                <input type="text" name="name" placeholder="Cupom" class="form-control" required>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="first_name">Desconto</label>
                                <input type="text" name="disconunt" placeholder="Informe o valor do desconto em %"
                                       class="form-control" required>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="inputState">Aceita Valor mínimo</label>
                                <select id="minimum" name="minimum" class="form-control" required>
                                    <option value="no">Não</option>
                                    <option value="yes">Sim</option>

                                </select>
                            </div>

                            <div class="form-group col-md-4 ds-none minimum-value">
                                <label for="first_name">Valor mínimo</label>
                                <input type="text" name="minimum_price" placeholder="Informe um valor mínimo"
                                       class="form-control">
                            </div>


                            <div class="form-group col-md-4">
                                <label for="inputState">Aceita Valor máximo</label>
                                <select id="maximum" name="maximum" class="form-control" required>
                                    <option value="no">Não</option>
                                    <option value="yes">Sim</option>

                                </select>
                            </div>

                            <div class="form-group col-md-4 ds-none maximum-discount">
                                <label for="first_name">Valor máximo</label>
                                <input type="text" name="maximum_discount" placeholder="Informe um valor máximo"
                                       class="form-control mask-money">
                            </div>


                            <div class="form-group col-md-4">
                                <label for="first_name">Início</label>
                                <input type="date" name="initial_date" placeholder="Informe uma data para início"
                                       class="form-control" required>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="first_name">Fim</label>
                                <input type="date" name="end_date" placeholder="Informe uma data para final"
                                       class="form-control" required>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="first_name">Quantidade</label>
                                <input type="number" name="amount" placeholder="Informe a quantidade limite"
                                       class="form-control" required>
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
                </div>
            </div>

        <?php else : ?>
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="fas fa-fw fa-building"></i>
                    Atualizar Cupom
                </h1>
                <div class="form-group text-right">
                    <a href="<?= url("/admin/coupons/coupons"); ?>" class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>
                        <span class="text">Novo cupom</span>
                    </a>
                </div>
            </div>
            <div class="card shadow">
                <div class="card-body">
                    <form action="<?= url("/admin/coupons/coupons/{$cupom->id}"); ?>" method="post">
                        <!--ACTION SPOOFING-->
                        <input type="hidden" name="action" value="update"/>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="first_name">Cupom</label>
                                <input type="text" name="name" placeholder="Cupom" value="<?= $cupom->name; ?>"
                                       class="form-control" required>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="first_name">Desconto</label>
                                <input type="text" name="disconunt" value="<?= $cupom->disconunt; ?>"
                                       placeholder="Informe o valor do desconto em %" class="form-control" required>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="inputState">Aceita Valor mínimo</label>
                                <select id="minimum" name="minimum" class="form-control" required>
                                    <option value="no" <?= $cupom->minimum == 'no' ? ' selected' : ''; ?>>Não</option>
                                    <option value="yes" <?= $cupom->minimum == 'yes' ? ' selected' : ''; ?>>Sim</option>

                                </select>
                            </div>

                            <div class="form-group col-md-4 minimum-value <?= $cupom->minimum == "yes" ? '' : 'ds-none'; ?>">
                                <label for="first_name">Valor mínimo</label>
                                <input type="text" value="<?= $cupom->minimum_price; ?>" name="minimum_price"
                                       placeholder="Informe um valor mínimo" class="form-control mask-money">
                            </div>


                            <div class="form-group col-md-4">
                                <label for="inputState">Aceita Valor máximo</label>
                                <select id="maximum" name="maximum" class="form-control" required>
                                    <option value="no" <?= $cupom->maximum == 'no' ? ' selected' : ''; ?>>Não</option>
                                    <option value="yes" <?= $cupom->maximum == 'yes' ? ' selected' : ''; ?>>Sim</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4  maximum-discount <?= $cupom->maximum == "yes" ? '' : 'ds-none'; ?>">
                                <label for="first_name">Valor máximo</label>
                                <input type="text" value="<?= $cupom->maximum_discount; ?>" name="maximum_discount"
                                       placeholder="Informe um valor máximo" class="form-control mask-money">
                            </div>


                            <div class="form-group col-md-3">
                                <label for="first_name">Início</label>
                                <input type="text"
                                       name="initial_date"
                                       value="<?= date("d/m/Y", strtotime($cupom->initial_date)); ?>"
                                       placeholder="Informe uma data para início" class="form-control mask-date"
                                       required>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="first_name">Fim</label>
                                <input type="text" name="end_date"
                                       value="<?= date("d/m/Y", strtotime($cupom->end_date)); ?>"
                                       placeholder="Informe uma data para final" class="form-control mask-date"
                                       required>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="first_name">Quantidade</label>
                                <input type="number" name="amount" value="<?= $cupom->amount; ?>"
                                       placeholder="Informe a quantidade limite" class="form-control" required>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="inputState">Status</label>
                                <select name="status" class="form-control" required>
                                    <option value="active" <?= $cupom->status == 'active' ? ' selected' : ''; ?>>Ativo
                                    </option>
                                    <option value="inactive" <?= $cupom->status == 'inactive' ? ' selected' : ''; ?>>
                                        Inativo
                                    </option>
                                </select>
                            </div>
                        </div>


                        <div class="form-group text-right">
                            <button class="btn btn-info btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fas fa-check"></i>
                            </span>
                                <span class="text">Atualizar</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </div>

<?php $v->start("scripts"); ?>
    <script>
        $(function () {

            //APRESENTA O CAMPO E COLOCA COMO OBRIGATÓRIO MÌNIMO
            $('#minimum').change(function () {
                var dados = $(this).val();
                if (dados === 'yes') {
                    $(".minimum-value").show();
                    $("input[name='minimum_price']").prop("required", "true");
                } else {
                    $(".minimum-value").hide();
                    $("input[name='minimum_price']").removeAttr("required");
                    $("input[name='minimum_price']").val(0);
                }
            });

            //APRESENTA O CAMPO E COLOCA COMO OBRIGATÓRIO MÁXIMO
            $('#maximum').change(function () {
                var dados = $(this).val();
                if (dados === 'yes') {
                    $(".maximum-discount").show();
                    $("input[name='maximum_discount']").prop("required", "true");
                } else {
                    $(".maximum-discount").hide();
                    $("input[name='maximum_discount']").removeAttr("required");
                    $("input[name='maximum_discount']").val(0);
                }
                console.log($(this).val());
            });

        });
    </script>
<?php $v->end("scripts"); ?>