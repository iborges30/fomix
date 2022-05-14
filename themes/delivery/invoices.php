<?php require("header.php"); ?>
<div class="container">
    <div class="mt-30 ds-block">
        <div class="page-item">
            <div class="go-back">
                <a href="#" class="jsc-back poppins" data-product-id="161">
                    <img src="assets/images/seta.png" alt="">
                </a>
            </div>

            <div class="page-item-title">
                <h1 class="poppins text-dark">EXTRATO DE PAGAMENTO</h1>
            </div>
        </div>
    </div>
</div>
<section class="container">
    <ul class="itens mtb-30">
        <?php
        for ($i = 0; $i < 5; $i++):
            ?>
            <li class="mt-10">
                <a href="historic.php">
                    <div class="installments">
                        <div class="icon-informations">
                            <span class="icon-card"><i class="far fa-credit-card text-dark"></i></span>
                        </div>
                        <div class="informations">
                            <p class="text-dark">Pagamento realiado em 15/10/2021</p>
                            <span class="text-default">R$ 8,00</span>
                        </div>
                    </div>
                </a>
            </li>
        <?php
        endfor;
        ?>
    </ul>
</section>
    <?php require("footer.php"); ?>
