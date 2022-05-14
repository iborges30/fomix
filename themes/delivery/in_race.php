<?php $v->layout("_theme"); ?>
<?= $v->insert("profile"); ?>

<!--EM CORRIDA -->
<section class="container jsc-delivery-in-ride">
    <div class="row">
        <div class="col-1">
            <div class="ride mt-30 in-ride">
                <header><h2 class="text-default center">Entrega em andamento</h2></header>
                <div class="row">
                    <div class="col-1">
                        <div class="initial mt-30">
                            <p class="text-dark"><i class="far fa-compass"></i> <b>ORIGEM</b></p>
                            <span class="text-default"><?= $startRace->enterprise; ?></span>
                            <span class="text-gray">
                                <?= $startRace->address; ?>, <?= $startRace->number; ?> - <?= $startRace->complement; ?>, <?= $startRace->district; ?>
                            </span>
                        </div>

                        <div class="destiny mt-20">
                            <p class="text-dark"><i class="fas fa-map-marker-alt"></i> <b>DESTINO</b></p>
                            <span class="text-gray"><?= $startRace->arrival; ?></span>
                        </div>
                    </div>

                    <div class="col-60">
                        <div class="delivery mt-20">
                            <p class="text-dark"><i class="far fa-credit-card"></i> <b>VALOR DA CORRIDA</b></p>
                        </div>
                    </div>
                    <div class="col-40">
                        <div class="price-delivery mt-20 right">
                            <span class="text-gray">R$ <?= str_price($startRace->race_price); ?></span>
                        </div>
                    </div>

                </div>

                <div class="actions-ride mtb-30 ds-flex">
                    <a href="<?= url("delivery/user/".base64_encode($delivery->id));?>" class="text-white btn-reject jsc-reload-open-rice">Atualizar</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!--EM CORRIDA -->