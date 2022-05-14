<?php $v->layout("_admin"); ?>

<div class="container-fluid">
    <?php if (empty($delivery)): ?>
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-fw fa-plus-circle"></i>
               Novo entrgador
            </h1>
        </div>

    <form action="<?= url("/admin/delivery/user/create"); ?>" method="post">
        <div class="tab-pane fade show active " id="home" role="tabpanel" aria-labelledby="home-tab">
            <!--ACTION SPOOFING-->
            <input type="hidden" name="action" value="create"/>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="first_name">Nome</label>
                    <input type="text" name="first_name" id="first_name"
                           placeholder="Primeiro nome"
                           class="form-control" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="last_name">Sobrenome</label>
                    <input type="text" name="last_name" id="lastname" placeholder="Último nome"
                           class="form-control"
                           required>
                </div>


                <div class="form-group col-md-3">
                    <label for="last_name">Cep</label>
                    <input type="text" name="zipcode" id="cep" placeholder="CEP"
                           class="form-control wc_getCep mask-zip-code" required>
                </div>

                <div class="form-group col-md-3">
                    <label for="last_name">Cidade</label>
                    <input type="text" name="city" id="cep" placeholder="Cidade"
                           class="form-control wc_localidade"
                           required readonly>
                </div>

                <div class="form-group col-md-3">
                    <label for="last_name">Estado</label>
                    <input type="text" name="state" id="cep" placeholder="Estado"
                           class="form-control wc_uf" required
                           readonly>
                </div>

                <div class="form-group col-md-3">
                    <label for="genre">Genero</label>
                    <select name="genre" id="genre" class="form-control">
                        <option value="male">Masculino</option>
                        <option value="female">Feminino</option>
                        <option value="other">Outros</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="photo">Foto</label>
                <input type="file" name="image" id="photo" class="form-control-file">
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="datebirth">Nascimento</label>
                    <input type="text" name="datebirth" id="datebirth" placeholder="dd/mm/yyyy"
                           class="mask-date form-control">
                </div>
                <div class="form-group col-md-4">
                    <label for="document">Documento</label>
                    <input type="text" name="document" id="document"
                           placeholder="CPF do usuário"
                           class="mask-doc form-control">
                </div>

                <div class="form-group col-md-4">
                    <label for="document">Celular</label>
                    <input type="text" name="phone" id="phone" placeholder="Celular"
                           class="mask-phone form-control">
                </div>

                <div class="form-group col-md-4">
                    <label for="document">Veículo</label>
                    <select name="vehicle" id="genre" class="form-control">
                        <?php foreach (vehicleType() as $key => $p):?>
                            <option value="<?= $key;?>"><?= $p;?></option>
                        <?php endforeach;?>

                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label for="document">Documento de Habilitação</label>
                    <input type="text" name="license" id="phone" placeholder="Habilitação"
                           class="form-control">
                </div>


                <div class="form-group col-md-4">
                    <label for="document">Tipo de Habilitação</label>
                    <select name="type" class="form-control">
                        <?php foreach (licenseType() as $key => $p):?>
                            <option value="<?= $key;?>"><?= $p;?></option>
                        <?php endforeach;?>
                    </select>
                </div>

            </div>


            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="password">Pix</label>
                    <input type="text" name="key_pix" id="password"
                           placeholder="Chave de pagamento"
                           class="form-control" required>
                </div>

                <div class="form-group col-md-6">
                    <label for="password">Senha</label>
                    <input type="password" name="password" id="password"
                           placeholder="Senha de acesso"
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
        </div>
    </form>
</div>
</div>



    <?php else: ?>
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-fw fa-comments"></i>
                Editar Entregador
            </h1>

            <div class="form-group text-right">
                <a href="#" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-plus-circle"></i>
                </span>
                    <span class="text">Novo cadastro</span>
                </a>
            </div>
        </div>

<form action="<?= url("/admin/delivery/user/update/$delivery->id"); ?>" method="post">
    <div class="tab-pane fade show active " id="home" role="tabpanel" aria-labelledby="home-tab">
        <!--ACTION SPOOFING-->
        <input type="hidden" name="action" value="update"/>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="first_name">Nome</label>
                <input type="text" name="first_name" id="first_name"
                       placeholder="Primeiro nome"
                       value="<?= $delivery->first_name;?>"
                       class="form-control" required>
            </div>
            <div class="form-group col-md-6">
                <label for="last_name">Sobrenome</label>
                <input type="text" name="last_name" id="lastname"
                       placeholder="Último nome"
                       value="<?= $delivery->last_name;?>"
                       class="form-control"
                       required>
            </div>


            <div class="form-group col-md-3">
                <label for="last_name">Cep</label>
                <input type="text" name="zipcode" id="cep" placeholder="CEP"
                       class="form-control wc_getCep mask-zip-code"  value="<?= $delivery->zipcode;?>" required>
            </div>

            <div class="form-group col-md-3">
                <label for="last_name">Cidade</label>
                <input type="text" name="city" id="cep" placeholder="Cidade"
                       class="form-control wc_localidade"
                       value="<?= $delivery->city;?>"
                       required readonly>
            </div>

            <div class="form-group col-md-3">
                <label for="last_name">Estado</label>
                <input type="text" name="state" id="cep" placeholder="Estado"
                       class="form-control wc_uf" required
                       value="<?= $delivery->state;?>"
                       readonly>
            </div>

            <div class="form-group col-md-3">
                <label for="genre">Genero</label>
                <select name="genre" id="genre" class="form-control">
                    <option value="male" <?= $delivery->genre == 'male' ? "selected " : '';?> >Masculino</option>
                    <option value="female" <?= $delivery->genre == 'female' ? "selected " : '';?> >Feminino</option>
                    <option value="other" <?= $delivery->genre == 'other' ? "selected " : '';?>>Outros</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="photo">Foto</label>
            <input type="file" name="image" id="photo" class="form-control-file">
        </div>

        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="datebirth">Nascimento</label>
                <input type="text" name="datebirth" id="datebirth"
                       value="<?= date_fmt_br($delivery->datebirth);?>"
                       class="mask-date form-control">
            </div>
            <div class="form-group col-md-4">
                <label for="document">Documento</label>
                <input type="text" name="document" id="document"
                       placeholder="CPF do usuário"
                       value="<?= $delivery->document;?>"
                       class="mask-doc form-control">
            </div>

            <div class="form-group col-md-4">
                <label for="document">Celular</label>
                <input type="text" name="phone"
                       value="<?= $delivery->phone;?>"
                       id="phone" placeholder="Celular"
                       class="mask-phone form-control">
            </div>

            <div class="form-group col-md-4">
                <label for="document">Veículo</label>
                <select name="vehicle" id="genre" class="form-control">
                    <?php foreach (vehicleType() as $key => $p):?>
                        <option value="<?= $key;?>" <?= $key == $delivery->vehicle ? ' selected' : '';?>><?= $p;?></option>
                    <?php endforeach;?>

                </select>
            </div>

            <div class="form-group col-md-4">
                <label for="document">Documento de Habilitação</label>
                <input type="text" name="license" id="phone"
                       value="<?= $delivery->license;?>"
                       placeholder="Habilitação"
                       class="form-control">
            </div>


            <div class="form-group col-md-4">
                <label for="document">Tipo de Habilitação</label>
                <select name="type" class="form-control">
                    <?php foreach (licenseType() as $key => $p):?>
                        <option value="<?= $key;?>" <?= $key == $delivery->type ? ' selected' : '';?>><?= $p;?></option>
                    <?php endforeach;?>
                </select>
            </div>

        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="password">Senha</label>
                <input type="password" name="password"
                       id="password"
                       placeholder="Senha de acesso"
                       class="form-control" >
            </div>

            <div class="form-group col-md-6">
                <label for="password">Status</label>
                <select name="status" id="" class="form-control">
                    <option value="active" <?= $delivery->status == 'active' ? " selected" : '';?>>Ativo</option>
                    <option value="inactive" <?= $delivery->status == 'inactive' ? " selected" : '';?>>Inativo</option>
                    <option value="bad" <?= $delivery->status == 'bad' ? " selected" : '';?>>Banido</option>
                </select>
            </div>


            <div class="form-group col-md-6">
                <label for="password">Pix</label>
                <input type="text" name="key_pix"
                       value="<?= $delivery->key_pix;?>"
                       placeholder="Chave de pagamento"
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
        </div>
    </div>
    <?php endif; ?>
</form>
</div>

