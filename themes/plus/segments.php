<?php $v->layout("_theme"); ?>

<div class="all bg-segments-types">
    <div class="container">
        <div class="row">
            <div class="col-1 ">
                <div class="segments-types">
                    <div class="logo-black">
                        <img src="<?= theme("assets/images/fomix-black.png", CONF_VIEW_THEME); ?>" alt="Fomix">
                    </div>
                    <p class="roboto">Escolha um segmento </p>
                </div>
            </div>
        </div>

        <div class="types-enterprises">
            <div class="row">

                <div class="col-2">
                    <div class="box-buttom">
                        <div class="segments-type-item">
                            <a href="<?= url("/plus");?>">
                                <img src="<?= theme("assets/images/fastfood.png", CONF_VIEW_THEME); ?>"
                                     alt="fast food">
                            </a>
                            <p><a href="<?= url("/plus");?>" class="text-center roboto text-dark">Restuarantes e Fast Food</a></p>
                        </div>
                    </div>
                </div>

                <div class="col-2">
                    <div class="box-buttom">
                        <div class="segments-type-item">
                            <a href="https://rolapapo.com.br">
                                <img src="<?= theme("assets/images/pizza.png", CONF_VIEW_THEME); ?>"
                                     alt="Pizzarias">
                            </a>
                            <p><a href="https://rolapapo.com.br" class="text-center roboto text-dark">Pizzarias</a></p>
                        </div>
                    </div>
                </div>

                <div class="col-2">
                    <div class="box-buttom">
                        <div class="segments-type-item">
                            <a href="https://darlu.darluck.com.br/">
                                <img src="<?= theme("assets/images/cosmetic.png", CONF_VIEW_THEME); ?>"
                                     alt="Sabonetes e Cosméticos">
                            </a>
                            <p><a href="https://darlu.darluck.com.br/" class="text-center roboto text-dark">Sabonetes e Cosméticos</a></p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>