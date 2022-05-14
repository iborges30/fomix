<?php $v->layout("_admin"); ?>

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-fw fa-building"></i>
            Atualizar empresa
        </h1>
    </div>
    <div class="col-sm-12">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Dados</a>
            </li>

            <li class="nav-item" role="presentation">
                <a class="nav-link" id="capa-tab" data-toggle="tab" href="#capa" role="tab" aria-controls="capa" aria-selected="true">Capa</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="configuracoes-tab" data-toggle="tab" href="#configuracao" role="tab" aria-controls="home" aria-selected="true">Configurações Gerais</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="free-delivery-tab" data-toggle="tab" href="#free-delivery" role="tab" aria-controls="home" aria-selected="true">Entrega grátis</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="param-products-tab" data-toggle="tab" href="#param-products" role="tab" aria-controls="home" aria-selected="true">Parametrizar produtos</a>
            </li>

        </ul>
    </div>
    <div class="card-body bg-white radius shadow-sm">
        <div class="tab-content " id="myTabContent">
            <!-- CADASTRO GERAL -->
            <div class="tab-pane fade show active ajax-form-student row" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="row">
                    <div class="col-lg-3 order-lg-2">
                        <div class="card shadow mb-4">
                            <div class="card-profile-image mt-4 col-md-12 text-center">
                                <figure class="figure">
                                    <?= photo_img($enterprise->image, $enterprise->enterprise, 375, 375, null, "js-profile rounded-circle image"); ?>
                                </figure>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="text-center">
                                            <h5 class="font-weight-bold"><?= $enterprise->enterprise; ?></h5>
                                            <p>CNPJ: <?= $enterprise->document_enterprise; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8 order-lg-1">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <?= $enterprise->enterprise; ?>
                                </h6>
                            </div>
                            <div class="card-body">

                                <form action="<?= url("/admin/enterprise/myenterprise/update"); ?>" method="post">
                                    <input type="hidden" name="action" value="update" />
                                    <div class="pl-lg-1">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group focused">
                                                    <label class="form-control-label" for="name">Nome do
                                                        restaurante<span class="small text-danger">*</span></label>
                                                    <input type="text" id="name"
                                                           class="form-control"
                                                           readonly
                                                           name="enterprise" value="<?= $enterprise->enterprise; ?>" placeholder="Nome do restaurante">
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group focused">
                                                    <label class="form-control-label" for="last_name"><span class="small text-danger">*</span>Cnpj</label>
                                                    <input type="text" readonly value="<?= $enterprise->document_enterprise; ?>" class="form-control mask-document-enterprise" name="document_enterprise" maxlength="18">
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="form-group focused">
                                                    <label class="form-control-label">
                                                        <span class="small text-danger">*</span>Telefone</label>
                                                    <input type="text" id="last_name" class="form-control mask-phone" value="<?= $enterprise->phone; ?>" name="phone" maxlength="14">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label" for="email"><span class="small text-danger">*</span>Endereço</label>
                                                    <input type="text" value="<?= $enterprise->address; ?>" class="form-control" name="address">
                                                </div>
                                            </div>

                                            <div class="col-lg-2">
                                                <div class="form-group focused">
                                                    <label class="form-control-label">Número </label>
                                                    <input type="text" value="<?= $enterprise->number; ?>" class="form-control" name="number">
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="form-group focused">
                                                    <label class="form-control-label">
                                                        Bairo</label>
                                                    <input type="text" class="form-control" value="<?= $enterprise->district; ?>" name="district">
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="form-group focused">
                                                    <label class="form-control-label">
                                                        Complmento</label>
                                                    <input type="text" class="form-control" value="<?= $enterprise->complement; ?>" name="complement">
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="form-group focused">
                                                    <label class="form-control-label">
                                                        <span class="small text-danger">*</span>Cep</label>
                                                    <input type="text" class="form-control wc_getCep mask-zip-code" value="<?= $enterprise->zip_code; ?>" name="zip_code" maxlength="9">
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="form-group focused">
                                                    <label class="form-control-label">
                                                        Cidade</label>
                                                    <input type="text" class="form-control wc_localidade" readonly="" value="<?= $enterprise->city; ?>" name="city">
                                                </div>
                                            </div>

                                            <div class="col-lg-2">
                                                <div class="form-group focused">
                                                    <label class="form-control-label">
                                                        Estado</label>
                                                    <input type="text" class="form-control wc_uf" readonly="" value="<?= $enterprise->state; ?>" name="state">
                                                </div>
                                            </div>


                                            <div class="col-lg-12" style="margin-top: 30px">
                                                <div class="form-group focused">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input wc_loadimage" name="image" id="inputGroupFile01">
                                                        <label class="custom-file-label" for="inputGroupFile01">Imagem</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col text-right" style="margin-top: 30px">
                                                <div class="form-group ">
                                                    <button type="submit" class="btn btn-success">Atualizar</button>
                                                    <a href="<?= url('/admin/enterprise/home'); ?>" class="btn btn-primary ml-4">Voltar</a>
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
            <!-- CAPA -->
            <div class="row tab-pane fade show  ajax-form-student" id="capa" role="tabpanel" aria-labelledby="capa-tab">
                <div class="row">
                    <div class="col-lg-6 order-lg-2">
                        <div class="card shadow mb-4">
                            <div class="card-profile-image mt-4 col-md-12 text-center">
                                <figure class="figure">
                                    <?= photo_img($enterprise->cover, $enterprise->enterprise, 375, null, null, "js-capa imagecover"); ?>
                                </figure>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 order-lg-1">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <?= $enterprise->enterprise; ?>
                                </h6>
                            </div>
                            <div class="card-body">

                                <form action="<?= url("/admin/enterprise/myenterprise/update-cover"); ?>" method="post">
                                    <input type="hidden" name="action" value="update" />
                                    <div class="pl-lg-1">
                                        <div class="row">


                                            <div class="col-lg-12" style="margin-top: 30px">
                                                <div class="form-group focused">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input wc_loadimage" name="imagecover" id="inputGroupFile02">
                                                        <label class="custom-file-label" for="inputGroupFile02">Imagem</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col text-right" style="margin-top: 30px">
                                                <div class="form-group ">
                                                    <button type="submit" class="btn btn-success">Atualizar</button>
                                                    <a href="<?= url('/admin/enterprise/home'); ?>" class="btn btn-primary ml-4">Voltar</a>
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
            <!-- CONFIGURAÇÕES -->
            <div class="row tab-pane fade show  ajax-form-student" id="configuracao" role="tabpanel" aria-labelledby="configuracao-tab">
                <div class="row">

                    <div class="col-lg-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <?= $enterprise->enterprise; ?>
                                </h6>
                            </div>
                            <div class="card-body">

                                <form action="<?= url("/admin/enterprise/myenterprise/update-config"); ?>" method="post">
                                    <input type="hidden" name="action" value="update" />
                                    <div class="pl-lg-1">
                                        <div class="row">

                                            <div class="col-lg-3">
                                                <div class="form-group focused">
                                                    <label class="form-control-label" for="delivery-fee"><span class="small text-danger">*</span>Taxa mínima de Entrega</label>
                                                    <input type="text" value="<?= $enterprise->delivery_fee; ?>" id="delivery-fee" class="form-control" name="delivery_fee" maxlength="18">
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="form-group focused">
                                                    <label class="form-control-label" for="delivery-fee"><span class="small text-danger">*</span>Taxa Máxima de Entrega</label>
                                                    <input type="text" value="<?= $enterprise->delivery_fee_max; ?>" id="delivery-fee" class="form-control" name="delivery_fee_max" maxlength="18">
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="form-group focused">
                                                    <label class="form-control-label" for="delivery-fee"><span class="small text-danger">*</span>Valor por km</label>
                                                    <input type="text" value="<?= $enterprise->bit_rate; ?>" id="bet_rate-fee" class="form-control mask-money" name="bit_rate" maxlength="18">
                                                </div>
                                            </div>


                                            <div class="col-lg-3">
                                                <div class="form-group focused">
                                                    <label class="form-control-label" for="delivery-fee"><span class="small text-danger">*</span>Tempo para entrega
                                                    </label>
                                                    <input type="text" value="<?= $enterprise->time_delivery; ?>" class="form-control" name="time_delivery" maxlength="18">
                                                </div>
                                            </div>


                                            <div class="col-lg-12">
                                                <div class="form-group focused">
                                                    <label class="form-control-label" for="about_enterprises"><span class="small text-danger">*</span>Mensagem de
                                                        Saudação</label>
                                                    <textarea class="form-control" name="about_enterprises" maxlength="200" id="about_enterprises" rows="6"><?= $enterprise->about_enterprises; ?></textarea>
                                                </div>
                                            </div>
                                            <div class="col text-right" style="margin-top: 30px">
                                                <div class="form-group ">
                                                    <button type="submit" class="btn btn-success">Atualizar</button>
                                                    <a href="<?= url('/admin/enterprise/home'); ?>" class="btn btn-primary ml-4">Voltar</a>
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
            <!-- TAXA GRATIS -->
            <div class="row tab-pane fade show  ajax-form-student" id="free-delivery" role="tabpanel" aria-labelledby="free-delivery">
                <div class="row">

                    <div class="col-lg-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <?= $enterprise->enterprise; ?>
                                </h6>
                            </div>
                            <div class="card-body">

                                <form action="<?= url("/admin/enterprise/myenterprise/update-free-delivery"); ?>" method="post">
                                    <input type="hidden" name="action" value="update" />
                                    <div class="pl-lg-1">
                                        <div class="row">

                                            <div class="col-lg-3">
                                                <div class="form-group focused">
                                                    <label class="form-control-label" for="delivery-fee"><span class="small text-danger">*</span>Valor Mínimo</label>
                                                    <input type="text" value="<?= $enterprise->minimum_amount_free_delivery; ?>" id="minimum_amount_free_delivery"
                                                           class="form-control mask-money" name="minimum_amount_free_delivery" maxlength="18">
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="form-group focused">
                                                    <label class="form-control-label" for="delivery-fee"><span class="small text-danger">*</span>Ativar/Desativar</label>

                                                    <select name="free_delivery" id="" class="form-control">
                                                        <option value="inactive" <?= $enterprise->free_delivery == 'inactive' ?  'selected' :''; ?>>Desativada</option>
                                                        <option value="active" <?= $enterprise->free_delivery == 'active' ?  'selected' :''; ?>>Ativado</option>
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="col text-right" style="margin-top: 30px">
                                                <div class="form-group ">
                                                    <button type="submit" class="btn btn-success">Atualizar</button>
                                                    <a href="<?= url('/admin/enterprise/home'); ?>" class="btn btn-primary ml-4">Voltar</a>
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


            <!-- PARAMETRIZAR PRODUTOS -->
            <div class="row tab-pane fade show  ajax-form-student" id="param-products" role="tabpanel" aria-labelledby="param-products">
                <div class="row">

                    <div class="col-lg-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <?= $enterprise->enterprise; ?>
                                </h6>
                            </div>
                            <div class="card-body">

                                <form action="<?= url("/admin/enterprise/myenterprise/update-param-products"); ?>" method="post">
                                    <input type="hidden" name="action" value="update" />
                                    <div class="pl-lg-1">
                                        <div class="row">


                                            <div class="col-lg-3">
                                                <div class="form-group focused">
                                                    <label class="form-control-label" for="parameterize_products"><span class="small text-danger">*</span>Sim/Não</label>
                                                    <select name="parameterize_products" id="parameterize_products" class="form-control">
                                                        <option value="inactive" <?= $enterprise->parameterize_products == 'inactive' ?  'selected' :''; ?>>Não</option>
                                                        <option value="active" <?= $enterprise->parameterize_products == 'active' ?  'selected' :''; ?>>sim</option>
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="col text-right" style="margin-top: 30px">
                                                <div class="form-group ">
                                                    <button type="submit" class="btn btn-success">Atualizar</button>
                                                    <a href="<?= url('/admin/enterprise/home'); ?>" class="btn btn-primary ml-4">Voltar </a>
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
</div>