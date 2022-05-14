<?php $v->layout("_theme"); ?>
<div class="container">
    <div class="row">
        <div class="col-1">

            <div class="checkout">
                <div class="checkout-bag">
                    <img src="<?= theme("/assets/images/bag.jpg"); ?>" alt="Logo">
                </div>
                <div class="checkout-title"><span class="poppins text-dark">MINHA SACOLA</span></div>
            </div>
        </div>

        <div class="product-in-checkout">
            <?php
            $total = 0;
            $totalAdditionals  = 0;
            $totalConta = 0;
            if (!empty($_SESSION["cart"])) :
                foreach ($_SESSION["cart"] as $p) :
                    if(isset($p['productPrice'])):
                        //var_dump($_SESSION);
                        $total += ($p['productPrice'] * $p["amountProduct"]);
                        ?>
                        <div class="row" id="<?= $p["product_id"];?>">
                            <div class="col-1">
                                <p class="roboto text-dark"><?= $p["amountProduct"]; ?> X <?= $p["productName"]; ?></p>
                                
                            </div>
                            <div class="col-1">
                                
                                <?php
                                
                                if(isset($_SESSION['flavors'][$p["product_id"]])){
                                    $flavorsDescriptionItem = '<b>Sabor:</b> ';
                                    foreach ($_SESSION['flavors'][$p["product_id"]] as $value):
                                        $dataflavors = explode('.¢§@.',$value);
                                        $flavorsDescriptionItem = $flavorsDescriptionItem.' '.strtolower($dataflavors[0]).', ';
                                    endforeach;
                                    echo substr($flavorsDescriptionItem,0,-2).'<br>';
                                }
                                if(isset($_SESSION['optional'][$p["product_id"]])){
                                    $optionalDescriptionItem = '<b>Opcional:</b> ';
                                    foreach ($_SESSION['optional'][$p["product_id"]] as $value):
                                        $optional = explode('.¢§@.',$value);
                                        $optionalDescriptionItem = $optionalDescriptionItem.' '.strtolower($optional[0]).', ';
                                    endforeach;
                                    echo substr($optionalDescriptionItem,0,-2).'<br>';
                                }

                                if(isset($_SESSION['aditionals'][$p["product_id"]])){
                                    echo '<b>Adicionais: </b>';
                                    $add = '';
                                    foreach ($_SESSION['aditionals'][$p["product_id"]] as $value):
                                        $Additionais =  explode('.¢§@.',$value);
                                        $valorAdditionais = str_replace(",",".",$Additionais[0]);
                                        $qntAdditionais = $Additionais[1];
                                        $descricaoAdditionais = strtolower($Additionais[2]);
                                        $totalAdditionals += $p["amountProduct"]*($qntAdditionais * $valorAdditionais);
                                        $add = $add.''.$qntAdditionais .' '.$descricaoAdditionais.', ';
                                    endforeach;
                                    echo substr($add,0,-2);
                                }
                                $totalConta = $totalConta+$total+$totalAdditionals
                                ?>
                                <br>
                                <span id="price-<?= $p["product_id"];?>" class="roboto text-dark"><h3>Valor: R$ <?= str_price($total+$totalAdditionals); ?></h3></span>
                            </div>
                            <div class="col-3">&nbsp;<!-- Quantidade: <span class="checout-amount"><?= $p["amountProduct"]; ?></span> --></div>

                            <div class="col-3">
                            <i><?php
                                if (!empty($p["observations"])){
                                    echo 'Obs: '.$p["observations"];
                                };?></i>
                            </div>

                            <div class="col-3">
                                <div class="remove-item remove-item-sacolinha" data-price="<?= $total+$totalAdditionals; ?>" data-remove="<?= $p["product_id"];?>">
                                    <span class="jsc-checkout-clear">X</span>
                                </div>
                            </div>

                        </div>
                <?php
                    $totalAdditionals =0;
                    $total = 0;
                        endif;
                endforeach;
            endif; ?>
        </div>

    </div>

    <?php if($totalConta != 0):?>   
    <div class="row">
    <label for="request_observation" id="request_observation_label">Observação geral do pedido</label>
    <textarea name="request_observation" id="request_observation" class="form-control"  rows="3" placeholder="Alguma observação a mais?"></textarea>
    </div>   
    <div class="row">
        <div class="col-1">
            <div class="check-sub-total">
                <h3 class="poppins text-dark text-center">SUBTOTAL</h3>
                <p id="total-compra" data-price="<?= $totalConta;?>" class="roboto text-dark text-center">Valor: R$ <?= str_price($totalConta);?></p>
                <a href="<?= url(slug_interprise()."/pedido/meus-dados"); ?>" class="roboto text-center jsc-close-sale" >FECHAR COMPRA</a>
                <a href="<?= url(slug_interprise()); ?>" class="roboto text-center jsc-close-sale btn-next-sale" >CONTINUAR COMPRANDO</a>
                <a href="<?= url(slug_interprise()); ?>" class="roboto text-center jsc-close-sale btn-refresh" id="refazer-pedido" >REFAZER PEDIDO</a>
                
            </div>
        </div>
    </div>
    <?php else: ?>

    <?php endif;?>
</div>