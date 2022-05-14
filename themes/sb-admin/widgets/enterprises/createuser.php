<?php $v->layout("_admin"); ?>

<div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-fw fa-pen-alt"></i>
                Novo Usuário
            </h1>
        </div>

        <form action="<?= url("/admin/enterprise/user/usercreate"); ?>" method="post">
            <!--ACTION SPOOFING-->
            <input type="hidden" name="action" value="create"/>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="first_name">Nome</label>
                    <input type="text" name="first_name"  id="first_name" placeholder="Primeiro nome" class="form-control" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="last_name">Sobrenome</label>
                    <input type="text" name="last_name" id="last_name" placeholder="Último nome" class="form-control" required>
                </div>
            </div>

            <div class="form-group">
                <label for="genre">Genero</label>
                <select name="genre" id="genre" class="form-control">
                    <option value="male">Masculino</option>
                    <option value="female">Feminino</option>
                    <option value="other">Outros</option>
                </select>
            </div>

            <div class="form-group">
                <label for="photo">Foto</label>
                <input type="file" name="photo" id="photo" class="form-control-file">
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="datebirth">Nascimento</label>
                    <input type="text" name="datebirth"  id="datebirth" placeholder="dd/mm/yyyy" class="mask-date form-control">
                </div>
                <div class="form-group col-md-6">
                    <label for="document">Documento</label>
                    <input type="text" name="document" id="document" placeholder="CPF do usuário" class="mask-doc form-control">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="email">E-mail</label>
                    <input type="email" name="email"  id="email" placeholder="Melhor e-mail" class="form-control" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="password">Senha</label>
                    <input type="password" name="password" id="password" placeholder="Senha de acesso" class="form-control" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="level">Level</label>
                    <select name="level" id="level" class="form-control" required>
                        <option value="3">Usuário</option>
                        <option value="4">Admin</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="registered">Registrado</option>
                        <option value="confirmed">Confirmado</option>
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

</div>

