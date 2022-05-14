<?php
if (!empty($deliveries)):
    foreach ($deliveries as $p):
        ?>
        <section class="container  jsc-request " id="<?= $p->id; ?>">
            <div class="row">
                <div class="col-1">
                    <div class="ride mt-30">
                        <header><h2 class="text-default center">Solicitação de Entrega</h2></header>
                        <div class="row">
                            <div class="col-1">
                                <div class="initial mt-30">
                                    <p class="text-dark"><i class="far fa-compass"></i> <b>ORIGEM</b></p>
                                    <span class="text-default"><?= $p->enterprise; ?></span>
                                    <span class="text-gray"><?= $p->address; ?>, <?= $p->number; ?>, <?= $p->district; ?></span>
                                </div>

                                <div class="destiny mt-20">
                                    <p class="text-dark"><i class="fas fa-map-marker-alt"></i> <b>DESTINO</b></p>
                                    <span class="text-gray"><?= $p->arrival; ?></span>
                                </div>
                            </div>

                            <div class="col-60">
                                <div class="delivery mt-20">
                                    <p class="text-dark"><i class="far fa-credit-card"></i> <b>VALOR DA CORRIDA</b>
                                    </p>
                                </div>
                            </div>

                            <div class="col-40">
                                <div class="price-delivery mt-20 right">
                                    <span class="text-gray">R$ <?= str_price($p->race_price); ?></span>
                                </div>
                            </div>
                            <?php
                            if ($p->observations): ?>
                            <div class="col-1">
                                <div class=mt-20 right
                                ">
                                <span class="text-gray"><b>Observação</b>: <?= $p->observations; ?></span>
                            </div>
                        </div>
                        <?php endif ?>
                    </div>

                    <div class="actions-ride mtb-30 ds-flex">
                        <a href="#" data-delivery="<?= $deliveryId; ?>"
                           class="text-white btn-accept jsc-accept-race">Aceitar</a>
                        <!-- <a href="#" class="text-white btn-reject">Rejeitar</a>-->
                    </div>
                </div>
            </div>
            </div>
        </section>
    <?php
    endforeach;
else: echo "<div class='solicita'>Você não tem nenhuma solicitação de entrega ainda.</div>";
endif;
?>