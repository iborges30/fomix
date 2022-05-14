<?php $v->layout("_theme"); ?>

<?php $v->insert("modal-coupons"); ?>
<!-- MODAL COUPONS-->

<!-- MODAL COUPONS-->
<div class="container">
    <div class="row">
        <div class="col-1">

            <div class="client-title">
                <header>
                    <h1 class="text-center text-dark">DADOS DO CLIENTE</h1>
                </header>
            </div>
            <?php
            //var_dump($_SESSION);
            //  print_r($_SESSION["optional"]);
            ?>

            <div class="client-form">
                <form action="" method="post" id="formClient" name="formClient">
                    <?= csrf_input() ?>
                    <input type="hidden" name="city" value="<?= $_SESSION['enterprise_id']->city; ?>">
                    <input type="hidden" name="state" value="<?= $_SESSION['enterprise_id']->state; ?>">
                    <input type="hidden" name="discount" value="0" id="discount">
                    <input type="hidden" name="coupon_id" id="coupomId">
                    <input type="hidden" name="coupon" id="coupon">
                 
                        <label for=""><span>CPF</span>
                            <input type="tel" name="document" class="mask-document jsc-document-client  js-require" placeholder="Seu CPF" required>
                        </label>
                        
                        <label>
                            <span>NOME</span>
                            <input type="text" name="client" class="ajax-client js-require" placeholder="Seu Nome" required>
                        </label>

                        <label for="">
                            <span>WHATSAPP</span>
                            <input type="tel" class="mask-phone ajax-whatsapp js-require" name="whatsapp" placeholder="Seu WhatsApp" required>
                        </label>


                        <div class="client-title">
                            <header>
                                <h1 class="text-center text-dark">DADOS DE ENTREGA</h1>
                            </header>
                        </div>


                        <div class="form-group">
                            <label class="text-dark"> FORMA DE ENTREGA</label>
                            <select name="sendOrders" id="sendOrders" required="required" class="jsc-selected-send">
                                <option value="none" disabled="disabled" selected>Selecionem uma forma de entrega</option>
                                <option value="store">Retirar na loja</option>
                                <option value="home">Receber em casa</option>
                            </select>

                        </div>


                        <div class="form-group address ds-none ">
                            <div class="row">
                                <div class="col-1 autocomplete">
                                    <label>
                                        <span class="text-dark roboto">Endereço</span>
                                    </label>
                                    <input type="text" id="search" class="ajax-address required " name="address" placeholder="Informe o nome da rua e do bairro" required>
                                    <div id="autocomplete-result"></div>
                                </div>

                                <div class="col-2">
                                    <label>
                                        <span class="text-dark roboto">Número</span>
                                    </label>
                                    <input type="text" name="number" class="ajax-number required" placeholder="Informe o número da sua residência" required>
                                </div>

                                <div class="col-2">
                                    <label>
                                        <span class="text-dark roboto">Bairro</span>
                                    </label>
                                    <input type="text" name="square" required class="ajax-square required" placeholder="Informe o seu bairro">
                                </div>

                                <div class="col-2">
                                    <label>
                                        <span class="text-dark roboto">Complemento</span>
                                    </label>
                                    <input type="text" name="complement" class="ajax-complement required" placeholder="Informe o seu complemento" required>
                                </div>


                                <div class="col-2">
                                    <label>
                                        <span class="text-dark roboto">P. referência</span>
                                    </label>
                                    <input type="text" name="point" class="ajax-reference" placeholder="Informe um ponto de referência" required>
                                </div>


                                <div class="form-group">
                                    <div class="col-1">
                                        <label for="" class="text-dark"> TAXA DE ENTREGA: R$ <span class="ajax-get-rate" style="display: inline;"></span></label>
                                        <input type="hidden" data-value-view="<?= str_price($enterprise->delivery_fee); ?>" data-price="<?= $enterprise->delivery_fee; ?>" value="<?= $enterprise->delivery_fee; ?>" name="rate" id="rate">
                                    </div>
                                </div>

                            </div>
                        </div>


                        <div class="client-title">
                            <header>
                                <h1 class="text-center text-dark">FORMA DE PAGAMENTO</h1>
                            </header>
                        </div>

                        <div class="form-group">
                            <label class="text-dark">
                                FORMA DE PAGAMENTO
                            </label>
                            <select name="payment_method" required class="paymen-method">
                                <option disabled selected>Selecione um método de pagamento</option>
                                <?php
                                foreach (paymentFormat() as $key => $name) :
                                ?>
                                    <option value="<?= $key; ?>"><?= $name; ?></option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                        </div>


                        <div class="form-group diffenrence-money ds-none">
                            <label>
                                <span class="text-dark roboto">TROCO PARA</span>
                            </label>
                            <input type="number" name="change" class="mask-money">

                            <!-- <p>Seu troco será de: R$ 50,00</p> -->
                        </div>

                        <?php if (!empty($coupon)) : ?>
                            <div class="coupom jsc-coupom-open jsc-remove-cupom" data-coupon="<?= $coupon->id; ?>">
                                <div class="stamp-coupom">
                                    <img src="<?= theme("/assets/images/coupom.png", CONF_VIEW_THEME); ?>" alt="cupom de desconto">
                                </div>
                                <div class="coupom-code">
                                    <p>CUPOM DE DESCONTO</p>
                                    <span>Tenho um cupom de desconto</span>
                                </div>
                            </div>

                            <div class="ajax-apply-coupon">
                            </div>
                        <?php endif; ?>
                </form>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-1">
            <div class="orders-details">
                <h2 class="poppins text-dark">RESUMO DO PEDIDO</h2>
                <div class="order">
                    <ul>
                        <?php
                        $total = 0;
                        $totalAdditionals = 0;
                        $totalConta = 0;
                        $qntItens = 0;
                        // var_dump($_SESSION);
                        if (!empty($_SESSION["cart"])) :
                            foreach ($_SESSION["cart"] as $p) :
                                if (isset($p['productPrice'])) :
                                    $qntItens = $qntItens + $p["amountProduct"]; //quantidade de itens
                                    $total += ($p['productPrice'] * $p["amountProduct"]);
                        ?>
                                    <li>
                                        <div class="order-itens" style="display: block;">

                                            <span><strong><?= $p["amountProduct"]; ?></strong> x </span>
                                            <span><strong><?= $p["productName"]; ?></strong></span>

                                            <br>
                                            <div style="width:100%;display:block;">
                                                <?php
                                                if (isset($_SESSION['flavors'][$p["product_id"]])) {
                                                    $flavorsDescriptionItem = '<b>Sabor:</b> ';
                                                    foreach ($_SESSION['flavors'][$p["product_id"]] as $value) :
                                                        $dataflavors = explode('.¢§@.', $value);
                                                        $flavorsDescriptionItem = $flavorsDescriptionItem . ' ' . strtolower($dataflavors[0]) . ', ';
                                                    endforeach;
                                                    echo substr($flavorsDescriptionItem, 0, -2) . '<br>';
                                                }
                                                if (isset($_SESSION['optional'][$p["product_id"]])) {
                                                    $optionalDescriptionItem = '<b>Opcional:</b> ';
                                                    foreach ($_SESSION['optional'][$p["product_id"]] as $value) :
                                                        $optional = explode('.¢§@.', $value);
                                                        $optionalDescriptionItem = $optionalDescriptionItem . ' ' . strtolower($optional[0]) . ', ';
                                                    endforeach;
                                                    echo substr($optionalDescriptionItem, 0, -2) . '<br>';
                                                }
                                                if (isset($_SESSION['aditionals'][$p["product_id"]])) {
                                                    $add = '<b>Adicionais:</b> ';
                                                    foreach ($_SESSION['aditionals'][$p["product_id"]] as $value) :
                                                        $Additionais = explode('.¢§@.', $value);
                                                        $valorAdditionais = str_replace(",", ".", $Additionais[0]);
                                                        $qntAdditionais = $Additionais[1];
                                                        $descricaoAdditionais = strtolower($Additionais[2]);
                                                        $totalAdditionals += $p["amountProduct"] * ($qntAdditionais * $valorAdditionais);
                                                        $add = $add . '' . $qntAdditionais . ' ' . $descricaoAdditionais . ', ';
                                                    endforeach;
                                                    echo substr($add, 0, -2);
                                                }
                                                $totalConta = $totalConta + $total + $totalAdditionals
                                                ?>
                                            </div>
                                            <i><?php
                                                if (!empty($p["observations"])) {
                                                    echo 'Obs: ' . $p["observations"];
                                                }; ?></i>
                                            <div style="width: 100%;"></div>

                                            <h3><b>R$: </b> <?= str_price($total + $totalAdditionals); ?></h3>
                                        </div>
                                        <br>
                                    </li>

                        <?php
                                    $totalAdditionals = 0;
                                    $total = 0;
                                endif;
                            endforeach;
                        endif;
                        $_SESSION['total_conta'] = $totalConta;
                        ?>

                    </ul>
                    <div class="order-total">
                        <p><b>TOTAL ITENS</b>: <span class="total-product"><?= $qntItens; ?></span></p>

                        <div class="send get-send-product">
                            <p><b>FORMA DE ENTREGA</b></p>
                            <p>Retirar na loja <span>R$ 0,00</span></p>
                        </div>
                    </div>

                    <div class="ajax-discont"></div>
                    <input type="hidden" id="total_account" value="<?= $totalConta; ?>">
                    <div class="order-total-payment">
                        <p><b>TOTAL À PAGAR</b>: R$ <span class="price-total-pay"><?= str_price($totalConta); ?></span></p>
                        <div class="send">
                            <p>O seu pedido será enviado.</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-1">
            <div class="orders-action-send">
                <button type="button" id="finishedOrders" name="finishedOrders" class="btn-finished">Finalizar
                    compra
                </button>
            </div>
        </div>

    </div>
</div>


<?php $v->start("scripts"); ?>
<script>
    // BUSCA O ENDEREÇO
    var urlApi = "<?= url("/distance-api/places.php"); ?>";
    $('#search').on('input', function(e) {
        $.ajax({
            url: urlApi,
            method: 'GET',
            dataType: 'html',
            data: {
                input: $(this).val() + " <?= $_SESSION['enterprise_id']->city; ?> - <?= $_SESSION['enterprise_id']->state; ?>"
            },
            success: function(data) {
                $('#autocomplete-result').html(data);
            },
            error: function(err) {
                console.log(err);
            }
        });

    });

    //INSERE O ENDEREÇO NO CAMPO
    $('#autocomplete-result').on('click', '.place-item', function() {
        var origin = "<?= $_SESSION['enterprise_id']->address; ?>, <?= $_SESSION['enterprise_id']->number; ?> - <?= $_SESSION['enterprise_id']->district; ?>, <?= $_SESSION['enterprise_id']->city; ?> - <?= $_SESSION['enterprise_id']->state; ?>";
        var rate = parseFloat(<?= $enterprise->delivery_fee; ?>);
        var total_account = $('#total_account').val();
        var maxRate = parseFloat(<?= $enterprise->delivery_fee_max; ?>);
        var bitRate = parseFloat(<?= $enterprise->bit_rate; ?>);

        var authorize = "<?= $enterprise->free_delivery; ?>";
        var freeDelivery = parseFloat(<?= $enterprise->minimum_amount_free_delivery; ?>);



        $('#search').val($(this).attr('data-description'));
        $('#autocomplete-result').html('');
        var address = $(".ajax-address").val();
        address = address
        $.ajax({
            url: BASE + "/distance-api",
            method: "GET",
            dataType: 'json',
            data: {
                origin: origin,
                min_coast: rate,
                coast_per_km: bitRate,
                destination: address
            },
            success: function(response) {

                //PERMITE TAXA GRATIS PARA UM DETERMINADO VALOR
                if( total_account >= freeDelivery && authorize === 'active'){
                    taxa = 0;
                }else{
                    var taxa = parseFloat(response.coast);
                }

                //CALCULA A TAXA NATURAL
                if (taxa.toFixed(2) >= maxRate) {
                    taxa = maxRate;
                } else {
                    taxa = taxa.toFixed(2);
                }


                $("#rate").val(taxa);
                $("#rate").attr('data-value-view', taxa);
                $(".ajax-get-rate").text(parseFloat(taxa));

                $(".get-send-product").html(' <p><b>FORMA DE ENTREGA</b></p><p>Entrega à domicílio <span>R$ ' + taxa + '</span></p>');
                var calculate = parseFloat(total_account) + parseFloat(taxa);
                $(".order-total-payment span").text(calculate.toFixed(2));
            }
        });
    });
</script>
<?php $v->end("scripts"); ?>