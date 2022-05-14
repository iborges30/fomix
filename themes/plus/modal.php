<?php

//unset($_SESSION["cart"]); 
?>
<div class="modal">
    <div class="page-item">
        <div class="go-back">
            <a href="#" class="jsc-back" data-product-id="<?= $product->id; ?>"><img src="<?= theme("/assets/images/go-back.png"); ?>" alt="go-back"></a>
        </div>
        <div class="page-item-title">
            <h1 class="poppins text-dark"><?= $product->name; ?></h1>
        </div>
    </div>

    <div class="row">
        <div class="col-1">
            <div class="page-item-image">
                <img name="<?= $product->name; ?>" alt="<?= $product->name; ?>" src="<?= image($product->image, "1024"); ?>" />
            </div>
            <div class="page-product-description">
                <?= $product->description; ?>
            </div>
            <div class="page-item-price">
                <p><b class="roboto text-dark">R$ <?= str_price($product->price); ?></b></p>
            </div>
        </div>
    </div>
    <?php
    if (!empty($flavors) && $product->max_flavors > 0) : ?>
        <div class="page-item-flavors" data-flavor="1">
            <div class="item-title-flavors">
                <p><b>SABORES</b></p>
                <span data-max-flavors="<?= $product->max_flavors; ?>">Escolha até <?= $product->max_flavors; ?> opções. </span>
                <input type="hidden" id="qnt_max_flavors" value="<?= $product->max_flavors; ?>">
            </div>
            <ul>
                <?php
                foreach ($flavors as $p) :
                ?>
                    <li class="jsc-get-flavor no-clicked " data-product="<?= $product->id; ?>" flavor-name-item="<?= $p->flavor; ?>"   data-flavor-item="<?= $p->id; ?>">
                        <div class="item-flavors">
                            <label>
                                <p><?= $p->flavor; ?></p>
                                <span><?= $p->description; ?></span>
                            </label>

                            <div class="select-flavor jsc-select-flavor-<?= $p->id; ?>">
                                <i class="icon-check"></i>
                            </div>
                        </div>

                    </li>
                <?php
                endforeach; ?>
            </ul>
        </div>
    <?php
    endif;
    ?>

    <?php
    if (!empty($options) && $product->max_option > 0) : ?>
        <div class="page-item-options">
            <p><b>ITENS OPCIONAIS</b></p>
            <span data-max-options="<?= $product->max_option; ?>">Escolha até <?= $product->max_option; ?> opções. </span>

            <ul>
                <?php
                foreach ($options as $p) :
                ?>
                    <li>
                        <div class="item-option">
                            <label class="jsc-get-item-options">
                                <input type="checkbox" data-name-item="<?= $p->item; ?>" value="<?= $p->id; ?>" name="item_options[]" class="items-options-checked"  data-check-produt-id="<?=$product->id;?>">
                                <span><?= $p->item; ?></span>
                            </label>

                        </div>
                    </li>
                <?php
                endforeach; ?>
            </ul>
        </div>

    <?php
    endif;
    ?>

    <?php
    if (!empty($add) && $product->max_additional > 0) : ?>
        <div class="page-item-add">
            <p><b>ITENS ADICIONAIS</b></p>
            <?php
            if (!empty($product->max_additional)) : ?>
                <span data-max-add="<?= $product->max_additional; ?>">Escolha até <?= $product->max_additional; ?> itens adicionais. </span>
            <?php
            endif; ?>
            <ul>
                <form action="">
                    <?php
                    foreach ($add as $p) :
                    ?>
                        <li>
                            <div class="item-add">
                                <p><?= $p->additional; ?></p>
                                <span >R$ <?= str_price($p->price); ?></span>
                            </div>
                            <div class="item-add-controller">
                                <span class="plus" data-price="<?= str_price($p->price); ?>"
                                 id="<?= $p->id; ?>" data-additional-name="<?= $p->additional; ?>" data-max-allow="<?= $p->max_additional; ?>">+</span>
                                <input type="text" name="product-amount" readonly value="0" class="set-amount-<?= $p->id; ?>">
                                <span class="down" data-price="<?= str_price($p->price); ?>"  id="<?= $p->id; ?>" data-additional-name="<?= $p->additional; ?>" data-max-allow="<?= $p->max_additional; ?>">-</span>
                            </div>
                        </li>
                    <?php
                    endforeach; ?>
                </form>
            </ul>
        </div>

    <?php
    endif;
    ?>

    <div class="page-item-observations">
        <p class="roboto text-dark">Alguma Observação</p>

        <form action="">
            <textarea name="observation" cols="30" rows="8"></textarea>
        </form>
    </div>

    <div class="page-item-buy">
        <div class="row">
            <div class="col-2">
                <form action="">
                    <input type="hidden" name="productId" value="<?= $product->id; ?>">
                    <input type="hidden" name="productName" value="<?= $product->name; ?>">
                    <input type="hidden" name="productPrice" value="<?= $product->price; ?>">
                    <span class="item-buy-plus">+</span>
                    <input type="tel" name="amount" value="1" readonly>
                    <span class="item-buy-minus">-</span>
                </form>
            </div>
            <div class="col-2">
                <a href="javascript:void(0);" class="bt-add-buy" id="<?= $product->id; ?>" <?= $options ? 'data-option="1"' : 'data-option="0"'; ?> <?= $flavors ? 'data-flavor="1"' : 'data-flavor="0"'; ?>>
                    <i>Adicionar</i></a>
            </div>
        </div>
    </div>
</div>