<?php require("inc/header.php"); ?>

<div class="container">
    <div class="row">
        <div class="col-1">

            <div class="client-title">
                <header>
                    <h1 class="text-center text-dark">DADOS DO CLIENTE</h1>
                </header>
            </div>


            <div class="client-form">
                <form action="" method="post" name="formClient">

                    <label for="">
                        <span>NOME</span>
                        <input type="text" name="client" placeholder="Seu Nome">
                    </label>

                    <label for="">
                        <span>WHATSAPP</span>
                        <input type="text" name="whatsapp" placeholder="Seu WhatsApp">
                    </label>


                    <label for="">
                        <span>CPF</span>
                        <input type="text" name="document" placeholder="Seu CPF">
                    </label>


                    <div class="client-title">
                        <header>
                            <h1 class="text-center text-dark">DADOS DE ENTREGA</h1>
                        </header>
                    </div>


                    <div class="form-group">
                        <label class="text-dark"> FORMA DE ENTREGA</label>
                        <select name="sendOrders" required="">
                            <option disabled="">Selecionem uma forma de entrega</option>
                            <option value="store">Retirar na loja</option>
                            <option value="home">Entrega para Tangará da Serra -
                                R$ 5,00</option>
                        </select>
                    </div>


                    <div class="form-group address ds-none">
                        <div class="row">
                            <div class="col-1">
                                <label>
                                    <span class="text-dark roboto">Endereço</span>
                                </label>
                                <input type="text" class="ajax-address" name="address" placeholder="Informe o nome da rua">
                            </div>

                            <div class="col-2">
                                <label>
                                    <span class="text-dark roboto">Número</span>
                                </label>
                                <input type="text" name="number" class="ajax-number" placeholder="Informe o número da sua residência">
                            </div>

                            <div class="col-2">
                                <label>
                                    <span class="text-dark roboto">Bairro</span>
                                </label>
                                <input type="text" name="square" class="ajax-square" placeholder="Informe o seu bairro">
                            </div>

                            <div class="col-2">
                                <label>
                                    <span class="text-dark roboto">Complemento</span>
                                </label>
                                <input type="text" name="complement" class="ajax-complement" placeholder="Informe o seu complemento">
                            </div>

                            <div class="col-2">
                                <label>
                                    <span class="text-dark roboto">Ponto de referência</span>
                                </label>
                                <input type="text" name="point" class="ajax-reference" placeholder="Informe um ponto de referência">
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
                        <select name="payment_method" required="" class="paymen-method">
                            <option disabled="" selected="">Selecione um método de pagamento</option>
                            <option value="credit">Cartão de Crédito</option>
                            <option value="debit">Cartão de Débito</option>
                            <option value="money">Dinheiro</option>
                        </select>
                    </div>

                    <div class="form-group diffenrence-money ds-none">
                        <label>
                            <span class="text-dark roboto">TROCO PARA</span>
                        </label>
                        <input type="number" name="change" class="mask-money">
                    </div>
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
                        <li>
                            <div class="order-itens">
                                <span>1x</span>
                                <span>Perfumar Pitanga </span>
                                <span>Código: 0141</span>
                            </div>
                        </li>

                    </ul>
                    <div class="order-total">
                        <p><b>TOTAL ITENS</b>: R$ <span class="total-product">135,75</span></p>

                        <div class="send get-send-product">
                            <p><b>FORMA DE ENTREGA</b></p>
                            <p>Entrega à domicílio <span>R$ 5.00</span></p>
                        </div>
                    </div>

                    <div class="order-total-payment">
                        <p><b>TOTAL À PAGAR</b>: R$ <span>140.75</span></p>
                        <div class="send">
                            <p>O seu pedido será enviado para o
                                nosso Whatsapp. A Darluck agradece pela preferência.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-1">
            <div class="orders-action-send">
                <input type="submit" name="finishedOrders" value="Finalizar compra" class="btn-finished">
            </div>
        </div>

    </div>
</div>

<?php require("inc/footer.php"); ?>