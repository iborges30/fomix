<?php $v->layout("_theme"); ?>
<div class="all ds-flex login_box">
    <div class="login ">
        <img src="<?= theme("/assets/images/fomix-logo.png", CONF_VIEW_DELIVERY);?>"/>
    </div>
    <div class="login-form ">
        <form action="<?=url("/login/delivery/auth");?>" name="formLogin" method="post">
            <input type="hidden" name="action" value="login" />
            <?= csrf_input(); ?>
            <label for="">
                <input type="tel" name="document" placeholder="CPF">
            </label>

            <label for="">
                <input type="password" name="password" placeholder="SENHA">
            </label>

            <label for="">
                <input type="submit" name="login" value="ENTRAR">
            </label>
        </form>
    </div>
</div>
