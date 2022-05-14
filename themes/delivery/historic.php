<?php $v->layout("_theme"); ?>
<div class="container">
    <div class="mt-30 ds-block">
        <div class="page-item">
            <div class="go-back">
                <a href="#" class="jsc-back poppins jsc-user" data-product-id="161">
                    <img src="<?= theme("/assets/images/seta.png", CONF_VIEW_DELIVERY); ?>" alt="seta">
                </a>
            </div>

            <div class="page-item-title">
                <h1 class="poppins text-dark">HISTÓRICO DE ENTREGAS</h1>
            </div>
        </div>
    </div>
</div>
<section class="container">
    <ul class="itens mtb-30">
        <?php
        if (!empty($historic)):
            foreach ($historic as $p):
                ?>
                <li class="mt-10">
                    <div class="installments">

                        <div class="icon-informations">
                            <span class="icon-card"><i class="far fa-credit-card"></i></span>
                        </div>

                        <div class="informations">
                            <p class="text-dark"><?= $p->enterprises->enterprise; ?></p>
                            <span class="text-gray">Entrega #<?= $p->delivery_id; ?> - <?= date_fmt_br($p->created); ?></span>
                            <span class="text-green">R$ <?= str_price($p->price); ?>
                                <span class="<?= $p->status; ?>"
                                      style="margin-left: 20px">
                            <?= balanceStatusDelivery($p->status); ?>
                        </span>
                        </span>
                        </div>


                    </div>
                </li>
            <?php
            endforeach;
        endif;
        ?>
    </ul>
    <?=  $paginator;?>
</section>

