<?php $v->layout("_theme"); ?>
<div class="bg-main">
    <div class="container">
        <div class="mt-30 ds-block">
            <div class="page-item">
                <div class="go-back">
                    <a href="#" class="jsc-back poppins jsc-user" data-product-id="161">
                        <img src="<?= theme("/assets/images/seta.png", CONF_VIEW_DELIVERY); ?>" alt="seta">
                    </a>
                </div>

                <div class="page-item-title">
                    <h1 class="poppins text-dark">ATIVIDADES DA SEMANA</h1>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="ballance mtb-30 ds-flex">
                    <div class="col-90">
                        <div class="ballance-of-week">
                            <span class="text-gray">Saldo da semana</span>
                            <p class="text-dark">R$ <b><?= str_price($total); ?></b></p>
                        </div>
                    </div>
                    <div class="col-10">
                        <span class="icon-card"><i class="far fa-credit-card"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="container">
        <ul class="itens">
            <?php
            if (!empty($balance)) {
                foreach ($balance as $p):
                    ?>
                    <li class="mt-10">
                        <div class="installments">
                            <div class="icon-informations">
                                <span class="icon-card"><i class="far fa-credit-card"></i></span>
                            </div>
                            <div class="informations">
                                <p class="text-dark"><?= $p->enterprise; ?></p>
                                <span class="text-gray">Entrega #<?= $p->delivery_id; ?></span>
                                <span class="text-green">R$ <?= str_price($p->price); ?></span>
                            </div>
                            <p class="<?= $p->status; ?>">
                                <?= balanceStatusDelivery($p->status); ?>
                            </p>
                        </div>
                    </li>
                <?php
                endforeach;
            }
            ?>
        </ul>
    </section>
</div>
