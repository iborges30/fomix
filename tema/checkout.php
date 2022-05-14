<?php require("inc/header.php"); ?>

<div class="container">
    <div class="row">
        <div class="col-1">

            <div class="checkout">
                <div class="checkout-bag">
                    <img src="assets/images/bag.jpg" alt="bag">
                </div>
                <div class="checkout-title"><span class="poppins text-dark">MINHA SACOLA</span></div>
            </div>
        </div>

        <div class="product-in-checkout">
            <?php
            for ($i = 0; $i < 5; $i++) :
            ?>
                <div class="row">
                    <div class="col-1">
                        <p class="roboto text-dark">CORCEL II (FILÉ) APIMENTADO COM BACON!</p>
                        <span class="roboto text-dark">Valor: R$ 45,23</span>
                    </div>

                    <div class="col-3">Quantidade: <span class="checout-amount">1</span></div>

                    <div class="col-3">
                        <div class="checkout-amount-actions">
                            <span class="poppins text-dark jsc-checkout-plus" data-product-amount="1">+</span>

                            <span class="poppins text-dark jsc-checkout-remove">-</span>
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="remove-item">
                            <span class="jsc-checkout-clear">X</span>
                        </div>
                    </div>

                </div>
            <?php endfor; ?>
        </div>

    </div>


    <div class="row">
        <div class="col-1">
            <div class="check-sub-total">
                <h3 class="poppins text-dark text-center">SUBTOTAL</h3>
                <p class="roboto text-dark text-center">Valor: R$ 93,60</p>

                <a href="#" class="roboto text-center">FECHAR COMPRA</a>
            </div>
        </div>
    </div>
</div>

<?php require("inc/footer.php"); ?>