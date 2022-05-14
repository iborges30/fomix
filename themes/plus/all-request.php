<?php $v->layout("_theme"); ?>
<style>
    

    .text-purpule{
        background: #451A9F;
    }

    .my-list-request {
        margin-top: 35px;
    }

    .my-list-request h2 {
        font-weight: normal;
        font-size: 20px;
        color: #111111;
    }

    .bg-my-list-request {
        background: #FCFCFC;
    }

    .my-list-request ul {
        margin-top: 30px;
        margin-bottom: 100px;
    }

    .my-list-request li {
        border: 1px solid #ECECEC;
        border-radius: 10px;
        margin-bottom: 15px;
        padding: 15px 8px;
        background: #fff;

    }

    .my-list-request a {
        text-decoration: none;
    }

    .my-list-request .ds-flex {
        justify-content: space-between;
        align-items: center;
    }

    .client-request p {
        margin: 2px 0;
        color: #373737;
        font-size: .875em;

    }

    .client-request .time-request {
        font-size: 12px;
        color: #7F7F7F;
    }

    .client-request span {
        color: #01C587;
        font-size: .75em;
    }

    .new-request {
        padding: 10px;
        border-radius: 8px;
        color: #fff;
    }

    .div select {
        padding: 10px 5px;
        margin-top: 11px;
        border-radius: 4px;
        display: none;
    }

    .paginator {
        width: 90%;
        margin: 20px auto;
        padding: 10px;
    }

    nav.paginator .paginator_item {
        padding: 10px 15px;
        border: 1px solid #111;
        border-radius: 20px;
        width: 40px;
        height: 40px;
        margin: 5px;
        text-decoration: none;
        color: #111;
    }

    .paginator_item.paginator_active {
        background: #000;
        color: #FFFFFF !important;
    }

    .dialog-evaluate {
        width: 100%;
        height: 100%;
        position: fixed;
        background: #ffffff;
        justify-content: center;
        align-items: center;
    }

    .mtb-30 {
        margin: 30px 0;
    }

    .modal-evaluate {
        margin: 0;
        padding: 20px;
        background: #fff;
        border-radius: 4px;
        box-shadow: 0 2px 60px rgb(29 38 45 / 50%);
        width: 90%;
        position: relative;

    }

    .ds-none {
        display: none;
    }

    textarea {
        padding: 5px !important;
        border-radius: 4px;
        border: 1px solid #111;
        width: 100%;
        margin-top: 50px;
        margin-bottom: 10px;
    }

    .btn-evaluation {
        padding: 10px;
        background: #451A9F;
        margin: 20px 0;
        display: block;
        max-width: 120px;
        text-align: center;
        text-decoration: none;
        border-radius: 4px;
        color: #fff;
        border: 0;
        cursor: pointer;
    }

    .modal-close-evaluation {
        position: absolute;
        right: 30px;
        border: 2px solid #111;
        border-radius: 20px;
        padding: 2px 8px;
        font-size: 1.7em;
        margin-bottom: 10px;
        cursor: pointer;
    }

    .text-center {
        text-align: center;
    }

    .load {
        width: 80px;
    }
</style>

<div class="dialog-evaluate jsc-dialog-evaluate ds-none">
    <h2 class="poppins text-center mtb-30">Minha avaliação</h2>
    <
</div>

<div class="all bg-my-list-request">
    <div class="container my-list-request">
        <div class="row">
            <div class="col-1">
                <h2 class="poppins text-center">MEUS PEDIDOS</h2>
                <p class="poppins text-center ds-none"> Clique no nome do cliente para visualizar o pedido </p>
            </div>
        </div>
        <div class="row">
            <div class="col-1">
                <ul>
                    <?php
                    if (!empty($orders)):
                        foreach ($orders as $p):
                            ?>
                            <li>
                                <div class="ds-flex">
                                    <a href="<?= url("/my-request/" . $p->transaction_key); ?>">
                                        <div class="client-request">
                                            <p>Pedido: #<?= $p->id; ?></p>
                                            <p><?= $p->client; ?></p>
                                            <p class="time-request"><?= date_fmt_br($p->created); ?></p>
                                            <span>R$: <b><?= str_price($p->total_orders + $p->delivery_rate); ?></b></span>
                                        </div>
                                    </a>

                                    <!-- VER AQUI O LANCE DAS MENSAGEM -->

                                    <div class="div">
                                        <a href="#"
                                           data-client-id="<?= $p->client_id; ?>"
                                           data-enterprise="<?= $p->enterprise; ?>"
                                           data-enterprise-phone="<?= $p->phone; ?>"
                                           class="jsc-evaluate-order"
                                           id="<?= $p->id; ?>">
                                            <div class="actions poppins">
                                                 <span class="new-request text-purpule">
                                                    Avaliar Pedido
                                                </span>
                                            </div>
                                        </a>
                                    </div>
                                    <!-- VER AQUI O LANCE DAS MENSAGEM -->
                                </div>
                            </li>
                        <?php
                        endforeach;
                    endif;
                    ?>
                    <?= $paginator; ?>
                </ul>

            </div>
        </div>
    </div>
</div>

<script>
    var urlAtual = location.href;
    var link = localStorage.setItem('uri', urlAtual);

</script>