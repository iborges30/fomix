<?php $v->layout("_theme"); ?>

<?php

if (!empty($shop->status == 'close')) :
    ?>
    <div class="close-enterprise" id="close-enterprise" style="display: flex;">
        <div class="modal-close-enterprise text-center">
            <h2 class="poppins text-dark ">Opss. Estamos fechados neste momento.</h2>
            <a href="<?= url(); ?>">Clique aqui para retornar</a>
        </div>
    </div>
<?php
endif;
?>


<?php
if (!empty($couponName)):
    ?>
    <!-- MODAL CUPOM -->
    <div class="js-cupom" data-coupon="<?= $couponName->name; ?>"></div>
    <!-- MODAL CUPOM -->
<?php endif; ?>

    <div class="dialog all">
        <div class="container ajax-modal">
            <!--MODAL-->
            <!--MODAL-->
        </div>
    </div>

    <div class="dialog-home-products">
        <div class="box-load">
            <img src="<?= theme("/assets/images/load.gif"); ?>" alt="load">
        </div>
    </div>

    <div class="all bg-top">
        <div class="top">
            <img src="<?= photo_shops($enterprise->cover); ?>" alt="<?= $enterprise->slug; ?>">
        </div>
        <div class="logo">
            <a href="<?= url("/{$enterprise->slug}"); ?>">
                <img src="<?= photo_shops($enterprise->image); ?>" alt="Logo">
            </a>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-1">
                <div class="segment">
                    <h1 class="poppins"><?= $enterprise->enterprise; ?></h1>
                    <div class="description text-center">
                        <div class="oline">
                            <span class="roboto online"><b id="status">Online Agora</b></span>
                            <p class="roboto" style="margin-top: 3px;">Estamos em: <b><?= $enterprise->city; ?></b></p>
                        </div>
                    </div>

                    <div class="description">
                        <p class="roboto"><?= $enterprise->about_enterprises; ?></p>
                    </div>

                    <div class="mix">
                        <?php
                        if (!empty($coupom)):

                            ?>

                            <div data-cupom-enterprise="<?= $coupom->enterprise_id; ?>"
                                 class="mix-coupon js-coupon-info"
                                 style="background: white; text-align: left;  margin-top: 10px;">
                                <img src="<?= theme('assets/images/coupon-selo.jpg', CONF_VIEW_THEME); ?>"
                                     alt="Mix: Essa empresa aceita cupom de desconto.">
                            </div>


                        <?php
                        endif;
                        ?>

                        <?php
                        if ($enterprise->delivery_fee <= 0):
                            ?>
                            <div class="mix-coupon js-coupon-info">
                                <img src="<?= theme('assets/images/entrega-gratis.jpg', CONF_VIEW_THEME); ?>"
                                     alt="Mix: Você tem entrega grátis nessa empresa.">
                            </div>

                        <?php
                        endif;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="informations">
        <div class="row">

            <div class="col-2 text-center">
                <div class="rate text-right ">
                    <span class="roboto"><b>Entrega:</b> <?= $enterprise->time_delivery; ?></span>
                </div>
            </div>

            <div class="col-2 text-center">
                <div class="rate text-right ">
                    <span class="roboto"><b>Taxa de entrega</b> R$ <?= str_price($enterprise->delivery_fee); ?></span>
                </div>
            </div>


        </div>
    </div>

    <nav class="menu bg-menu">
        <ul>
            <?php

            if (!empty($categories)) :
                foreach ($categories as $p) :
                    ?>
                    <li><a href="<?= $p->slug; ?>" class="roboto jsc-home-category"
                           id="<?= $p->id; ?>"><?= $p->category; ?></a></li>
                <?php
                endforeach;
            endif; ?>
        </ul>
    </nav>

    <div class="search all">
        <form action="<?= url("/search/product"); ?>" method="POST" class="formProductSearch" name="formProductSearch">
            <input type="hidden" name="enterprise_id" class="enterprise_id" value="<?= $enterprise->id; ?>">
            <input type="text" name="s" class="jsc-search" placeholder="O que você gostaria de encontrar">
            <button class="btn btn-search"></button>

            <div class="products-ajax jsc-response">
            </div>
        </form>
    </div>

<?php
if ($enterprise->free_delivery == 'active'):
    ?>
    <div class="all bg-delivery-free">
        <p class="poppins text-white text-center">ENTREGA GRÁTIS PARA PEDIDOS ACIMA DE R$ <?=str_price($enterprise->minimum_amount_free_delivery);?></p>
    </div>
<?php
endif;
?>

<?php

if (!empty($promotions)) : ?>
    <div class="all promotions-remove">
        <div class="promotions">
            <h2 class="poppins">PROMOÇÃO</h2>

            <div class="promotion-items producst-in-home">
                <ul>
                    <?php
                    foreach ($promotions as $p) :
                        ?>
                        <li class="jsc-produt" data-product="<?= $p->id; ?>">
                            <div class="image-promotions">
                                <a title="<?= $p->name; ?>" href="<?= url("/product/{$p->id}"); ?>" class="text-center">
                                    <img name="<?= $p->name; ?>" alt="<?= $p->name; ?>"
                                         src="<?= image($p->image, 600); ?>"/>
                                </a>
                            </div>

                            <p class="text-center roboto"><?= $p->name; ?></p>
                            <p class="roboto text-center text-dark"> R$ <?= str_price($p->price); ?></p>
                        </li>

                    <?php
                    endforeach;
                    ?>
                </ul>
            </div>
        </div>
    </div>
<?php endif; ?>
    <div class="all">
        <div class="container">
            <div class="items producst-in-home">
                <!-- <div class="title-menu">
                        <h2 class="roboto text-dark">Burguers</h2>
                    </div>-->

                <!-- PRODUCTS -->
                <?php $v->insert("products", ["p" => $p]); ?>

            </div>
        </div>
    </div>
    <!-- PRODUCTS -->
<?php if (!empty($_SESSION["cart"])) : ?>
    <a href="<?= url("{$enterprise->slug}"); ?>/checkout" style="position: fixed;right: 10px;
       bottom:130px;z-index: 9;
       padding: 8px;
       border-radius: 50%;
        background: #f68254;
       -webkit-box-shadow: -1px 2px 7px 1px #00000073;
       box-shadow: -1px 2px 7px 1px #00000073;">
        <img src="<?= theme("/assets/images/bag.svg", CONF_VIEW_THEME); ?>" height="40" alt="bag">
    </a>
<?php endif; ?>

    <div class="all bg-footer">
        <div class="container">
            <div class="row">
                <div class="col-1">
                    <div class="footer">
                        <p class="poppins text-default"> <?= $enterprise->enterprise; ?> - <?= $enterprise->city; ?>
                            - <?= $enterprise->state; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--SACOLA -->
    <div class="ajax-bag"></div>


<?php $v->start("scripts"); ?>
    <script>
        $(function () {
            var enterpriseCoupon = $(".mix-coupon").attr("data-cupom-enterprise");
            console.log(enterpriseCoupon);

            CUPOM = $(".js-cupom").attr("data-coupon");
            $("body").on("click", ".jsc-set-cupom-enterprise", function () {
                var coupon = $(".js-cupom").data("coupon");
                var setCoupon = localStorage.setItem("@cupom:item", coupon);
                $(".js-cupom").fadeOut("fast");
                return false;
            });

            var recuperaCupom = localStorage.getItem("@cupom:item");
            if (recuperaCupom == CUPOM) {
                $(".dialog-coupon-home").remove(".dialog-coupon-home");
            } else {
                if (enterpriseCoupon) {
                    $(".js-cupom").html(' <div class="dialog-coupon-home ds-flex"> <div class="position">' +
                        '            <div class="coupom-home">' +
                        '                <img src="<?= theme("/assets/images/cupom.jpg"); ?>" alt="Cupom de desconto"' +
                        '                     class="jsc-set-cupom-enterprise">' +
                        '            </div>' +
                        '            <div class="close-coupon-home">' +
                        '                <a href="#" class="jsc-set-cupom-enterprise">X</a>' +
                        '            </div>' +
                        '        </div>' +
                        '</div>');
                }
            }

        });


    </script>
<?php $v->end("scripts"); ?>