<?php $v->layout("_admin"); ?>

<div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-fw fa-building"></i>
                Atualizar empresa
            </h1>
        </div>
        <div class="row">
            <div class="col-lg-4 order-lg-2">
                <div class="card shadow mb-4">
                    <div class="card-profile-image mt-4 col-md-12 text-center">
                        <figure class="figure">
                            <?= photo_img($enterprise->image, $enterprise->enterprise, 375, 375, null, "rounded-circle image"); ?>
                        </figure>

                        <!-- <figure class="rounded-circle avatar avatar font-weight-bold"
                                 style="font-size: 60px; height: 180px; width: 180px;" data-initial="C">

                         </figure>-->
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

                        <form action="<?= url("/admin/enterprise/update/{$enterprise->id}"); ?>" method="post">
                            <input type="hidden" name="action" value="update"/>
                            <div class="pl-lg-1">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="name">Nome do restaurante<span
                                                        class="small text-danger">*</span></label>
                                            <input type="text" id="name" class="form-control" name="enterprise"
                                                   value="<?= $enterprise->enterprise; ?>"
                                                   placeholder="Nome do restaurante">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="last_name"><span
                                                        class="small text-danger">*</span>Cnpj</label>
                                            <input type="text" value="<?= $enterprise->document_enterprise; ?>"
                                                   class="form-control mask-document-enterprise"
                                                   name="document_enterprise" maxlength="18">
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group focused">
                                            <label class="form-control-label">
                                                <span class="small text-danger">*</span>Telefone</label>
                                            <input type="text" id="last_name" class="form-control mask-phone"
                                                   value="<?= $enterprise->phone; ?>"
                                                   name="phone" maxlength="14">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="email"><span
                                                        class="small text-danger">*</span>Endereço</label>
                                            <input type="text"
                                                   value="<?= $enterprise->address; ?>"
                                                   class="form-control" name="address">
                                        </div>
                                    </div>

                                    <div class="col-lg-2">
                                        <div class="form-group focused">
                                            <label class="form-control-label">Número </label>
                                            <input type="text" value="<?= $enterprise->number; ?>" class="form-control"
                                                   name="number">
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group focused">
                                            <label class="form-control-label">
                                                Bairo</label>
                                            <input type="text" class="form-control"
                                                   value="<?= $enterprise->district; ?>" name="district">
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group focused">
                                            <label class="form-control-label">
                                                Complmento</label>
                                            <input type="text" class="form-control"
                                                   value="<?= $enterprise->complement; ?>"
                                                   name="complement">
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group focused">
                                            <label class="form-control-label">
                                                <span class="small text-danger">*</span>Cep</label>
                                            <input type="text" class="form-control wc_getCep mask-zip-code"
                                                   value="<?= $enterprise->zip_code; ?>"
                                                   name="zip_code" maxlength="9">
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group focused">
                                            <label class="form-control-label">
                                                Cidade</label>
                                            <input type="text" class="form-control wc_localidade" readonly=""
                                                   value="<?= $enterprise->city; ?>"
                                                   name="city">
                                        </div>
                                    </div>

                                    <div class="col-lg-2">
                                        <div class="form-group focused">
                                            <label class="form-control-label">
                                                Estado</label>
                                            <input type="text" class="form-control wc_uf" readonly=""
                                                   value="<?= $enterprise->state; ?>" name="state">
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group focused">
                                            <label class="form-control-label">
                                                Estado</label>
                                            <input type="text" class="form-control wc_uf" readonly=""
                                                   value="<?= $enterprise->state; ?>" name="state">
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group focused">
                                            <label class="form-control-label">Status</label>
                                            <select class="form-control" name="status">
                                                <option <?= $enterprise->status == 'active' ? 'selected' : ''; ?>>
                                                    Ativo
                                                </option>
                                                <option <?= $enterprise->status == 'Inativo' ? 'selected' : ''; ?>>
                                                    Inativo
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-4" style="margin-top: 30px">
                                        <div class="form-group focused">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input wc_loadimage" name="image"
                                                       id="inputGroupFile01">
                                                <label class="custom-file-label" for="inputGroupFile01">Imagem</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col text-right" style="margin-top: 30px">
                                        <div class="form-group ">
                                            <button type="submit" class="btn btn-success">Atualizar</button>
                                            <a href="<?= url('/admin/enterprise/home'); ?>"
                                               class="btn btn-primary ml-4">Voltar</a>
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