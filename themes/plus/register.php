<?php $v->layout("_theme"); ?>

    <!-- MODAL COUPONS-->
    <div class="container">
    <div class="row">
        <div class="col-1">

            <div class="client-title">
                <header>
                    <h1 class="text-center text-dark">MEUS DADOS - CONVÊNIO FOMIX</h1>
                    <p class="text-dark text-center">Cadastre-se para receber 10% de desconto nas lojas parceiras fomix.
                    </p>
                </header>
            </div>


            <div class="client-form register-form-mb">
                <form action="" method="post" id="formFriends" name="formFriends">
                    <input type="hidden" name="action" value="create">
                    <?= csrf_input() ?>
                    <label>
                        <span>NOME</span>
                        <input type="text" name="client" class="js-require" placeholder="Seu Nome" required>
                    </label>

                    <label for=""><span>CPF</span>
                        <input type="tel" name="document" class="mask-document  js-require"
                               placeholder="Seu CPF" required>
                    </label>


                    <label for="">
                        <span>WHATSAPP</span>
                        <input type="tel" class="mask-phone  js-require" name="whatsapp"
                               placeholder="Seu WhatsApp" required>
                    </label>


                    <p class="terms-friends"><a href="#" class="text-dark">Termos de uso convênio Fomix.</a></p>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-1">
            <div class="orders-action-send">
                <div class="load-register">
                    <img src="<?=theme("/assets/images/load2.gif");?>" alt="load">
                </div>
                <input type="submit" name="send" value="Cadastrar" class="btn-register-friends">
                </form>
            </div>
        </div>
    </div>


    <?php $v->start("scripts"); ?>
    <script>
        $("form[name='formFriends']").submit(function (e) {
            e.preventDefault();
            var uri = BASE + '/convenio/cadastro';
            var dados = $(this).serialize();
            $.ajax({
                url: uri,
                data: dados,
                dataType: 'json',
                method: 'post',
                beforeSend: function () {
                    $(".load-register").fadeIn("fast");
                },
                success: function (response) {
                    if (response.error) {
                        alert("O documento informado não é válido");
                    }
                    if (response.friend) {
                        alert("Tudo certo. Seu convênio foi realizado com sucesso. Agora você pode fazer suas compras com 10% de desconto nas lojas parceiras.");
                        window.location.href = "https://fomix.net.br/download/";
                    }
                },
                complete: function () {
                    $(".load-register").fadeOut("fast");
                }
            });
        });
        
    </script>
<?php $v->end("scripts"); ?>