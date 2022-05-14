
<div class="all bg-bag ds-none add-checkout-items">
    <div class="bag-content">
        <div class="little-bag">
            <img src="<?= theme('assets/images/bag.jpg'); ?>" alt="bag">
            <span class="bag-number"><?= $amountInBag; ?></span>
        </div>
        <div class="buttom-bag">
            <a href="<?= $url."/checkout";?>" class="jsc-checkout">FINALIZAR COMPRA</a>
        </div>
        <div class="price-bag">
            <p><?= $productPrice;?></p> 
        </div>
    </div>
</div>

