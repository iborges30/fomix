<div class="row">
    <?php
    if (!empty($riders)):
        foreach ($riders as $p):
            ?>
            <div class="col-md-4" style="margin: 15px 0;">
                <div class="entregas  card ">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">Minhas entregas</h6>
                    </div>
                    <div class="mb-4">
                        <div class="card-body">
                            <div class="details ds-flex border-succes">
                                <div class="avatar">
                                    <?= photo_img($p->image, $p->first_name, 100,100);?>
                                </div>
                                <div class="delivery">
                                    <?= $p->first_name. ' ' .$p->last_name; ?> -
                                    <?= vehicleType($p->vehicle);?></div>
                            </div>
                            <div class="dateils-rice">
                                <div class="ds-flex justify-content-between">
                                    <div class="destino mtb-10">
                                        <span><b>Destino</b></span>
                                        <p><i class="fas fa-location-arrow"></i> <?= $p->arrival; ?></p>
                                        <?php if ($p->back): ?>
                                            <span><b><i class="fas fa-flag"></i> Com volta</b></span>
                                        <?php endif; ?>
                                    </div>

                                    <div class="destino mtb-10">
                                        <span><b>Horário</b></span>
                                        <p><i class="fas fa-history"></i> <?=date_fmt_br( $p->created); ?></p>
                                    </div>
                                </div>

                                <div class="price-race ds-flex justify-content-between mtb-10">
                                    <p><b>VALOR</b></p>
                                    <p>R$ <?= str_price($p->race_price + $p->commission); ?></p>
                                </div>
                            </div>
                        </div>

                      <div class="input-group ml-4">
                            <a href="#" data-phone-delivery="<?=$p->phone;?>" data-race-id="<?=$p->id;?>" class="btn  btn-primary jsc-finish-race">
                                <i class="fas fa-credit-card"></i>
                                Finalizar entrega
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        <?php
        endforeach;
    else:
        echo alert_info("Você ainda não tem entregas geradas no sistema");
    endif;
    ?>
</div>