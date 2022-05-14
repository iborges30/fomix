$(function () {
    const socket = io("wss://deliverybot.ml", {secure: true});

    var phoneBase = '6596622520';
    var phoneColaboratinon = '6596810406'

    function sendMessage(number, message) {
        socket.emit(
            "users",
            "sendMessage",
            {number: number, message: message},
            "fomix"
        );
    }


    //############## GET PROJECT
    BASE = $("link[rel='base']").attr("href");

    //BUSCA AS EMPRESAS POR CIDADES
    var inCity = null;
    /* $("form[name='formCitiesShops']").submit(function () {
         var dados = $(this).serialize();
         dados = dados.replace("cities=", "");
         window.location.href = BASE + '/cidades/' + dados;
         var cidade = localStorage.setItem("cidade", dados);
         return false;
     });*/

    $(".jsc-slug-city").click(function () {
        var dados = $(this).data("city");
        window.location.href = BASE + '/cidades/' + dados;
        var cidade = localStorage.setItem("cidade", dados);
        return false;
    });


    //APAGA A LOCALSTORANGE
    $(".jsc-set-cities").click(function () {
        window.localStorage.removeItem('cidade');
        window.location.href = BASE;
        return false;
    });
    //MENU
    $('.open-menu label').click(function () {
        $('.navegation-mobile-list').fadeToggle('fast');
    });

    //CADASTRO DO USUÁRIO

    /********************************/
    /******* OPEN COMPLEMENTO *******/
    /********************************/
    $(".new-account").click(function () {
        $(".navegation-mobile-list").hide("fast", function () {
            $(".dialog-account").fadeIn("fast");
        });
    });


    /********************************/
    /******* ATUALIZAR *******/
    /********************************/
    $(".jsc-update-window").click(function () {
        location.reload();
        return false;
    });

    /********************************/
    /******* VOLTAR *******/
    /********************************/
    $(".jsc-go-back").click(function () {
        window.history.back();
        return false;
    });
    /********************************/
    /******* OPEN COMPLEMENTO *******/
    /********************************/

    $('.jsc-account').click(function () {

        var name = $(".accountForm").find("input[name='first_name']").val();
        var lastName = $(".accountForm").find("input[name='last_name']").val();
        var email = $(".accountForm").find("input[name='email']").val();
        var document = $(".accountForm").find("input[name='document']").val();
        var password = $(".accountForm").find("input[name='password']").val();

        if (name === '' || lastName == '' || email === '' || password === '' || document === '') {
            alertMensage("Você deve ter deixado algum campo em branco", "red");
        } else {
            $(".initial").slideUp("fast", function () {
                $(".next-account").slideDown("fast");

            });
        }

    });

    /********************************/
    /******* ENVIA O FORMULÁRIO *******/
    /********************************/
    $("form[name='accountForm']").submit(function () {
        var url = BASE + '/account';
        var dados = $(this).serialize();

        $.ajax({
            url: url,
            method: 'post',
            data: dados,
            dataType: 'json',
            beforeSend: function () {
                $(".load-account").fadeIn("slow");
            },
            success: function (response) {
                if (response.message) {
                    alertMensage(response.message, "red");
                }

                //SE CADASTROU REDIRECIONA
                if (response.success) {
                    $(".box-icon").hide("fast", function () {
                        $(".now").css("display", "none");
                        $(".success-account").show("fast", function () {
                            setTimeout(function () {
                                    location.href = BASE + '/admin';
                                },
                                3000);
                        });
                    })
                }
            },
            complete: function () {
                $(".load-account").fadeOut("slow");
            }

        });

        return false;
    });


    $(".jsc-home-category").click(function () {
        var categoryId = $(this).attr("id");
        var url = BASE + '/category/slug';
        $.ajax({

            url: url,
            method: 'post',
            data: {categoryId: categoryId},
            dataType: 'html',
            beforeSend: function () {
                $(".dialog-home-products").fadeIn("fast").addClass("ds-flex");
            },
            success: function (response) {
                $(".producst-in-home").empty();
                $(".promotions-remove").remove();
                $(".producst-in-home").html(response);
            },
            complete: function () {
                $(".dialog-home-products").fadeOut("fast").removeClass("ds-flex ");
            }
        });
        return false;
    });


    //ABRE A PÁGINA DE LEITURA DOS PRODUTOS
    $(".producst-in-home").on("click", ".jsc-produt", function () {
        var url = $(this).find("a").attr("href");
        var productId = $(this).attr("data-product");

        $.ajax({
            url: url,
            dataType: 'html',
            method: 'post',
            beforeSend: function () {
                $(".dialog-home-products").fadeIn("fast").addClass("ds-flex");
            },
            success: function (response) {

                $(".ajax-modal").empty().html(response);
                $(".dialog").animate({bottom: "0", height: ["easeOutBounce"], opacity: 1}, "slow", function () {
                    $(this).css({"overflow": "auto", "overflow": "scroll"});
                });

            },
            complete: function () {
                $(".dialog-home-products").fadeOut("fast", function () {
                    $(this).removeClass("ds-flex ");
                });
            }
        })
        return false;
    });
    //ABRE A PÁGINA DE LEITURA DOS PRODUTOS PELA PESQUISA
    $(".products-ajax").on("click", ".jsc-produt", function () {
        var url = $(this).find("a").attr("href");
        var productId = $(this).attr("data-product");
        $('.jsc-search').val('');
        $(".products-ajax").css("display", "none");
        $.ajax({
            url: url,
            dataType: 'html',
            method: 'post',
            beforeSend: function () {
                $(".dialog-home-products").fadeIn("fast").addClass("ds-flex");
            },
            success: function (response) {

                $(".ajax-modal").empty().html(response);
                $(".dialog").animate({bottom: "0", height: ["easeOutBounce"], opacity: 1}, "slow", function () {
                    $(this).css({"overflow": "auto", "overflow": "scroll"});
                });

            },
            complete: function () {
                $(".dialog-home-products").fadeOut("fast", function () {
                    $(this).removeClass("ds-flex ");
                });
            }
        })
        return false;
    });
    //FECHA A MODAL DE PRODUTO
    $(".dialog").on("click", ".jsc-back", function () {
        var url = BASE + '/remove-session';
        var id = $(this).attr("data-product-id");

        $.ajax({
            url: url,
            method: 'post',
            dataType: 'json',
            data: {id: id}
        });

        $(".dialog").animate({bottom: "-999px", opacity: 0}, "slow", function () {
            $(".ajax-modal").empty();
        });

        return false;
    });


    /************************************************** */
    /******************START CONTROLLER FLAVOR ******** */
    /************************************************** */
    productId = 0;
    $(".ajax-modal").on("click", ".jsc-get-flavor", function () {
        var flavorIdItem = $(this).data("flavor-item");
        var uri = BASE + '/add-flavor';
        var productId = $(".page-item").find("a").attr("data-product-id");
        var flavorName = $(this).attr("flavor-name-item");


        $(this).addClass('clicked');
        $(this).removeClass('jsc-get-flavor');

        //CRIA O CHECK E REMOVE O CHECK 
        $(".jsc-select-flavor-" + flavorIdItem).fadeIn("fast");

        if ($(this).hasClass("clicked")) {
            //VERIFICA O MÁXIMO DE ITENS QUE PODEM SER ADICIONADO
            var maxItemSelected = $(".item-title-flavors").find("span").attr("data-max-flavors");
            $.ajax({
                url: uri,
                method: 'post',
                dataType: 'json',
                data: {
                    id: productId,
                    maxItemSelected: maxItemSelected,
                    flavorIdItem: flavorIdItem,
                    flavorname: flavorName
                },
                success: function (response) {
                    //console.log(response)
                    if (response.max) {
                        //alert('remove');
                        alertMensage("Você atingiu o limite de items permitido para este produto", "red");
                        $(".jsc-select-flavor-" + flavorIdItem).fadeOut("fast");
                    }

                }
            });
        }
        return;
    });


    /************************************************** */
    /****************** REMOVE FLAVOR ADD BEFORE ******** */
    /************************************************** */
    $(".ajax-modal").on("click", ".clicked", function () {
        var t = $(this);
        var uri = BASE + '/remove-flavor';
        var productId = $(".page-item").find("a").attr("data-product-id");
        var flavorIdItem = $(this).data("flavor-item");


        $(".jsc-select-flavor-" + flavorIdItem).fadeOut("fast");

        $.ajax({
            url: uri,
            method: 'post',
            dataType: 'json',
            data: {
                id: productId,
                flavorIdItem: flavorIdItem
            },
            success: function (response) {
                if (response.remove_flavor) {
                    t.removeClass('clicked');
                    t.addClass('jsc-get-flavor');

                }

            }
        });

    });

    /************************************************** */
    /****************** END CONTROLLER FLAVOR ********* */
    /************************************************** */

    /************************************************** */
    /*************** START CONTROLLER OPTIONS ********* */
    /************************************************** */
    $(".ajax-modal").on("click", ".items-options-checked", function () {
        var uri = BASE + '/options';
        var maxOptions = $(".page-item-options").find("span").attr("data-max-options");
        var id = $(this).attr("data-check-produt-id");
        var nameItem = $(this).attr("data-name-item");
        var checkId = $(this).val();
        var checked = $(this);
        console.log(maxOptions);
        if ($(this).prop("checked") == true) {
            $.ajax({
                url: uri,
                method: 'post',
                data: {maxOptions: maxOptions, id: id, option: checkId, nameitem: nameItem},
                dataType: 'json',
                success: function (response) {
                    if (response.max) {
                        alertMensage("Você atingiu o limite de items opicionais permitido para este produto", "red");
                        checked.prop("checked", false);
                    }
                }
            });
        }

    });


    var id = 0;
    //REMOVE O ITEM OPCIONAL
    $(".ajax-modal").on("click", ".items-options-checked", function () {
        var uri = BASE + '/remove-options';
        var id = $(this).attr("data-check-produt-id");
        var checkId = $(this).val();
        var checked = $(this);

        if ($(this).prop("checked") == false) {
            $.ajax({
                url: uri,
                method: 'post',
                data: {id: id, option: checkId},
                dataType: 'json'
            });
        }

    });

    /************************************************** */
    /****************** END CONTROLLER OPTIONS ******** */
    /************************************************** */

    /************************************************** */
    /****************** START ADDIOTIONAL ******** */
    /************************************************** */

    $(".ajax-modal").on("click", ".plus", function () {
        var maxItemAllow = $(this).data("max-allow");
        var additionalId = $(this).attr("id");
        var productId = $(".page-item").find("a").attr("data-product-id");
        var uri = BASE + '/add-additional';
        var amount = $(".set-amount-" + additionalId).val();
        var price = $(this).attr("data-price");
        var additionalName = $(this).attr("data-additional-name")


        //VERIFICA O MÁXIMO DE ITENS QUE PODEM SER ADICIONADO
        var maxItem = $(".page-item-add").find("span").attr("data-max-add");
        //console.log('amount '+ amount);
        $.ajax({
            url: uri,
            data: {
                maxItemAllow: maxItemAllow,
                additionalId: additionalId,
                id: productId,
                maxItem: maxItem,
                amount: amount,
                price: price,
                additionalName: additionalName
            },
            dataType: 'json',
            method: 'post',
            success: function (response) {

                if (response.error) {
                    alertMensage(response.error, "red");
                }


                $(".set-amount-" + additionalId).val(response.amount > 0 ? response.amount : $(".set-amount-" + additionalId).val());
            }
        });

    });


    //REMOVE ITENS ADICIONAIS
    $(".ajax-modal").on("click", ".down", function () {
        var maxItemAllow = $(this).data("max-allow");
        var additionalId = $(this).attr("id");
        var productId = $(".page-item").find("a").attr("data-product-id");
        var uri = BASE + '/remove-additional';
        var amount = $(".set-amount-" + additionalId).val();
        var price = $(this).attr("data-price");
        var additionalName = $(this).attr("data-additional-name")

        //VERIFICA O MÁXIMO DE ITENS QUE PODEM SER ADICIONADO
        var maxItem = $(".page-item-add").find("span").attr("data-max-add");

        $.ajax({
            url: uri,
            data: {
                maxItemAllow: maxItemAllow,
                additionalId: additionalId,
                id: productId,
                maxItem: maxItem,
                amount: amount,
                price: price,
                additionalName: additionalName
            },
            dataType: 'json',
            method: 'post',
            success: function (response) {
                $(".set-amount-" + additionalId).val(response.amount > 0 ? response.amount : 0);
            }
        });

    });

    /************************************************** */
    /****************** END ADDIOTIONAL ******** */
    /************************************************** */


    //ADICIONA PRODUTO
    $(".ajax-modal").on("click", ".item-buy-plus", function () {
        var newValue = $(".page-item-buy input[name='amount']");
        var amount = $(".page-item-buy input[name='amount']").val();
        var add = parseInt(amount) + 1;
        newValue = newValue.val(add);

    });

    //REMOVE PRODUTO
    $(".ajax-modal").on("click", ".item-buy-minus", function () {
        var newValue = $(".page-item-buy input[name='amount']");
        var amount = $(".page-item-buy input[name='amount']").val();
        var minus = parseInt(amount) - 1;
        if (minus == 0) {
            newValue = newValue.val(1);
        } else {
            newValue = newValue.val(minus);
        }
    });

    //ABRE A SACOLINHA DE PRODUTOS
    $(".ajax-modal").on("click", ".bt-add-buy", function () {
        var urlBag = window.location.href.toString();
        var url = BASE + '/bag';
        var flavors = $(this).data("flavor");
        var options = $(this).data("option");
        var id = $(this).attr("id");
        var validate_flavors = 1;
        var amountProduct = $(".page-item-buy input[name='amount']").val();
        var observations = $(".page-item-observations textarea[name='observation']").val();
        var productName = $(".page-item-buy input[name='productName']").val();
        var productPrice = $(".page-item-buy input[name='productPrice']").val();
        var qntFlavors = $('#qnt_max_flavors').val();

        //AJAX PARA GERAR A BAG
        if (validate_flavors == 1) {
            $.ajax({
                url: url,
                dataType: "html",
                method: "post",
                data: {
                    id: id,
                    productName: productName,
                    productPrice: productPrice,
                    flavors: flavors,
                    options: options,
                    amountProduct: amountProduct,
                    observations: observations,
                    url: urlBag,
                    qntflavors: qntFlavors
                },
                success: function (response) {

                    if (response == 'flavors' && $('#qnt_max_flavors').val() > 0) {
                        alertMensage('Você deve escolher pelo menos um sabor para este produto', "red");
                    } else if (response == 'options') {
                        alertMensage('Você deve escolher pelo menos um item opcional para este produto', "red");
                    }
                    //else if( response != flavors){
                    else {
                        $(".dialog").animate({bottom: "-999px", opacity: 0}, "fast", function () {
                            $(".ajax-bag").empty().html(response);
                            $(".add-checkout-items").slideDown("fast");

                        });
                    }

                }
            });
        }
        return false;
    })
    //GRAVA A SESSÃO DA OBSERVAÇÃO
    $('#request_observation').blur(function () {
        var url = BASE + '/request-observation';
        var observation = $(this).val();
        $.ajax({
            url: url,
            dataType: "html",
            method: "post",
            data: {observation: observation},
            success: function (response) {
            }
        });
    })
    $(".product-in-checkout").on('click', '.remove-item-sacolinha', function () {
        var product_id = $(this).attr("data-remove");
        var product_price = $(this).attr("data-price");
        var total_compra = $('#total-compra').attr('data-price');
        var itemRemove = '#' + product_id;
        var url = BASE + '/remove-item-checkout';
        var preco_atualizado = (total_compra - product_price);

        //AJAX REMOVER ITEM SACOLA
        $.ajax({
            url: url,
            dataType: "html",
            method: "post",
            data: {idSession: product_id},
            success: function (response) {

                if (response) {

                    $('#total-compra').attr('data-price', preco_atualizado);
                    alertMensage('Produto removido', "red");
                    $(itemRemove).css('display', 'none');
                    $('#total-compra').html('Valor: ' + preco_atualizado.toLocaleString("pt-BR", {
                        style: "currency",
                        currency: "BRL"
                    }));
                }


            }
        });

        return false;

    })
    //REINICIA A SESSÃO PARA UM NOVO PEDIDO
    $('#refazer-pedido').click(function () {
        var url = BASE + '/refazer-pedido';
        //AJAX REMOVER ITEM SACOLA
        $.ajax({
            url: url,
            dataType: "html",
            method: "post",
            data: {},
            success: function (response) {


            }
        });

        // return false;
    })
    /********************************/
    /******* ENVIA O FORMULÁRIO *****/
    /********************************/

    //ALTERA O CAMPO PARA INFORMAR O ENDEREÇO
    $("select[name='sendOrders']").change(function () {
        var address = $(this).val();
        var total_account = $('#total_account').val();

        if (address === 'home') {
            $(".address").show("slow", function () {
                $(".required").addClass("js-require");
            });

        } else {
            var calculate = parseFloat(total_account) + parseFloat(0);
            $(".order-total-payment span").text(calculate.toFixed(2));
            $("#rate").attr('data-value-view', 0);
            $(".address").hide("slow", function () {
                $("input[name='address']").val('');
                $(".required").removeClass("js-require");
                $(".get-send-product").html('<p><b>FORMA DE ENTREGA</b></p><p>Retirar na loja <span>R$ 0,00</span></p>');

            });
        }
    });


    /*
      ********************************
      *******  PARTE DA ENTREGA  *****
      ********************************
      *
       */
    $("select[name='payment_method']").change(function () {
        var method = $(this).val();

        if (method === 'money') {
            $(".diffenrence-money").show("slow");
        } else if (method != 'money') {
            $(".diffenrence-money").fadeOut();
        }

    });

    //############## GET CEP
    $('.wc_getCep').change(function () {
        var cep = $(this).val().replace('-', '').replace('.', '');
        if (cep.length === 8) {
            $.get("https://viacep.com.br/ws/" + cep + "/json", function (data) {
                if (!data.erro) {
                    $('.wc_bairro').val(data.bairro);
                    $('.wc_complemento').val(data.complemento);
                    $('.wc_localidade').val(data.localidade);
                    $('.wc_logradouro').val(data.logradouro);
                    $('.wc_uf').val(data.uf);
                }
            }, 'json');
        }
    });


    /************************************************** */
    /**************** RETORNA DADOS DO CLIENTE ******** */
    /************************************************** */
    $(".jsc-document-client").focusout(function () {
        var document = $(this).val();
        var uri = BASE + '/address';

        $.ajax({
            url: uri,
            dataType: 'json',
            data: {document: document},
            method: 'post',
            success: function (response) {
                if (!response.clear) {

                }

                $(".ajax-client").val(response.client[0].client);
                $(".ajax-whatsapp").val(response.client[0].whatsapp);
                //  $(".ajax-address").val(response.client[0].address);
                $(".ajax-number").val(response.client[0].number);
                $(".ajax-square").val(response.client[0].square);
                $(".ajax-complement").val(response.client[0].complement);
                $(".ajax-reference").val(response.client[0].reference);

            }
        });

    });


    //AUTOCOMPLETE
    $('.jsc-search').on('keyup', function () {
        var form = $(this).val();
        var url = $(".formProductSearch").attr("action");
        var enterpriseId = $(".enterprise_id").val();
        // console.log(enterpriseId);
        if (form.length >= 3) {
            $.ajax({
                url: url,
                data: {product: form, enterpriseId: enterpriseId},
                type: "POST",
                dataType: "json",
                success: function (response) {
                    if (response.product) {
                        if (!$(".jsc-response").find('.list-numbers').length) {
                            $(".jsc-response").append("<ul class='list-numbers'></ul>");

                        }
                        $('.list-numbers').empty();
                        $(".products-ajax").css("display", "block");
                        $.each(response.product, function (key, value) {
                            $('.list-numbers').append("    <li class='jsc-produt' data-product='" + value.id + "'><div class='image-filter'>" +
                                "                                <img src='" + BASE + "/storage/" + value.image + "'/>" +
                                "                            </div>" +
                                "                            <div class='product-filter'>" +
                                "                                <p class='text-default roboto'>" +
                                "   <a href='" + BASE + "/product/" + value.id + " ' class='text-default roboto' >" + value.name + "</a></p>" +
                                "                                <p><a href='" + BASE + "/product/" + value.id + "' class='text-default roboto '>R$ " + value.price + "</a></p>" +
                                "                            </div>" +
                                "                    </li>");
                        });

                    }

                    if (response.clear) {
                        $(".products-ajax").css("display", "none");
                        if ($('.list-numbers').length) {
                            $('li').remove();
                        }
                    }
                }
            });
        } else {
            $(".products-ajax").css("display", "none");
        }
    });


    //EFETUA O PEDIDO
    $('#finishedOrders').click(function (e) {
        e.preventDefault();
        var requireInput = true;
        var requirePayment = true;
        var dataForm = $('#formClient').serialize();
        var url = BASE + '/send-order';
        var sendMethod = true;



        if ($('.paymen-method option:selected').val() == 'Selecione um método de pagamento') {
            alertMensage("Selecione uma forma de pagamento", "red");
            requirePayment = false;
        }

        if ($('#sendOrders option:selected').val() == 'none') {
            alertMensage("Selecione uma forma de entrega", "yellow");
            sendMethod = false;
            return ;
            console.log(sendMethod);
        }


        $('.js-require').each(function () {
            if ($(this).val() == '') {
                requireInput = false;
                $(this).css({'background': '#FFF5EE', 'border': 'solid 1px red'});
                return ;
            } else {
                $(this).css({'background': '#FFFFFF', 'border': 'none'});
            }
        })


        if (!requireInput && requirePayment) {
            $("html, body").animate({
                scrollTop: 0
            }, 800);
            alertMensage("Preencha os campos obrigatórios.", "red");
            return ;
        }



        if (requireInput && requirePayment && sendMethod) {
            $.ajax({
                url: url,
                data: dataForm,
                type: "POST",
                dataType: "json",
                beforeSend:function (){
                    $("#finishedOrders").attr("disabled", true);
                },
                success: function (response) {
                    var uri = BASE + '/meus-pedidos/' + response.client_id;
                    var historic = localStorage.setItem('uri', uri);
                    confirm(response.transaction_key, response.slug, response.client_id);
                    sendMessage(response.phone, 'Ebaaa!!!. Você tem mais um pedido no *Fomix*.\r\n Acesse o painel para acompanhar seus pedidos. Ou click no link : ' + BASE + '/enterprise/' + response.slug + '/' + response.enterprise_id);
                    sendMessage(response.client, 'A Fomix informa: Você realizou um pedido na empresa ' + response.slug + '. Clique no link para acompanhar o andamento do seu pedido.\r\n \r\n Link: ' + BASE + '/' + response.slug + '/my-request/' + response.transaction_key + ' \r\n \r\n*###Mensagem enviada eletronicamente, favor não responde-la ###.*');
                    sendMessage(phoneBase, 'Um novo pedido no Fomix em: ' + response.slug);
                    sendMessage(phoneColaboratinon, 'Ebaa... um pedido no Fomix em: ' + response.slug);

                },
                complete:function (){
                    $("#finishedOrders").removeAttr("disabled");
                }

            });
        }
        return false;
    })

    function confirm(token, slug, client_id) {
        $.confirm({
            title: 'Sucesso!',
            titleClass: 'roboto',
            theme: 'light',
            draggable: true,
            animation: 'zoom',
            boxWidth: '90%',
            useBootstrap: false,
            type: 'green',
            scrollToPreviousElement: false,
            content: 'Seu pedido foi enviado com sucesso, clique em acompanhar seu pedido, para ter as informações do seu pedido.',
            buttons: {
                copy: {
                    text: 'Acompanhar Pedido',
                    action: function () {
                        var uri = BASE + '/meus-pedidos/' + client_id;
                        var historic = localStorage.setItem('uri', uri);
                        location.href = BASE + '/' + slug + '/my-request/' + token;

                    }
                },

            }
        });
    }


    //CUPONS DE DESCONTO - ABRE A MODAL
    $(".jsc-coupom-open").click(function () {
        var couponId = $(this).attr("data-coupon");
        $(".dialog-coupon ").slideDown("slow").css("display", "flex");
    });

    //FECHA A MODAL DE DESCONTO
    $(".jsc-close-coupon").click(function () {
        $(".dialog-coupon").slideUp("fast");
        return false;
    });

    //ENVIA O VALOR DO CUPOM PARA FAZER O DESCONTO
    $(".jsc-apply-coupon").click(function () {
        var couponId = $(this).attr("data-coupon-id");
        var enterpriseId = $(this).attr("data-enterprise-id");
        var uri = BASE + "/apply-coupom";
        var total = $(".price-total-pay").text();
        total = parseFloat(total);

        $.ajax({
            url: uri,
            data: {couponId, enterpriseId: enterpriseId, total: total},
            dataType: "json",
            method: "post",
            beforeSend: function () {
                $(".voucher-load").fadeIn("fast");
            },
            success: function (response) {
                if (response.message) {
                    $(".message-alert").fadeIn("fast").empty().text(response.message);
                }

                if (response.discount) {
                    $(".message-apply").show("fast", function () {
                        var calcule = response.price;
                        calcule = calcule.toFixed(2);

                        setTimeout(function () {
                            $(".order-total-payment span").text(calcule);
                            $(".ajax-discont").html("<b>DESCNTO</b> :R$ " + response.discount);

                            $("#coupomId").val(response.couponId);
                            $("#discount").val(response.discount);
                            $("#coupon").val(response.coupon);

                            $(".jsc-remove-cupom").remove(".coupom");
                            $(".ajax-apply-coupon").html("<div class='coupom-code'><p>CUPOM DE DESCONTO APLICADO COM SUCESSO.</p><span>Você ganhou:R$ " + response.discount + " de desconto.</span></div>");

                            $(".dialog-coupon").slideUp("fast", function () {
                                $(".message-alert").empty().css("display", "none");
                                $(".message-apply").empty().css("display", "none");

                            });
                        }, 3000);
                    }).html("Obaa! Você ganhou R$ <b>" + response.discount + "</b> de desconto. Aguarde.");

                }
            },
            complete: function () {
                $(".voucher-load").fadeOut("fast");
            }


        })
        return false;
    });


    //AVALIAÇÃO - MODAL
    $(".jsc-evaluate-order").click(function () {
        var orderId = $(this).attr("id");
        var enterprise = $(this).data("enterprise");
        var clientId = $(this).data("client-id");
        var phone = $(this).data("enterprise-phone");
        var uri = BASE + "/verifica/pedido/modal"
        $.ajax({
            url: uri,
            data: {orderId: orderId},
            dataType: "html",
            method: "post",
            success: function (response) {
                $(".jsc-dialog-evaluate").slideDown("fast").css("display", "flex").html(response);
                $(".jsc-order-id").val(orderId);
                $(".jsc-client-evaluation-id").val(clientId);
                $(".jsc-enterprise-phone").val(phone);
                $(".jsc-enterprise-evaluation").val(enterprise);
                $(".jsc-numer-order").text("").text(orderId + " - na loja " + enterprise);
            }
        });


        return false;
    });

    //AVALIAÇÃO - MODAL
    $("body").on("click", ".jsc-modal-close-evaluation", function () {
        $(".jsc-dialog-evaluate").slideUp("fast");
        return false;
    });


    //CRIA A AVALIAÇÃO
    $(".jsc-dialog-evaluate").on("submit", "form[name='formEvaluation']", function () {
        var dados = $(this).serialize();
        var uri = BASE + "/avalia/pedido/client";
        $.ajax({
            url: uri,
            data: dados,
            dataType: "json",
            method: 'post',
            beforeSend: function () {
                $(".load").fadeIn("fast");
            },
            success: function (response) {
                if (response.message) {
                    alertMensage(response.message, "red");
                }
                if (response.success) {
                    alertMensage(response.success, "green");
                    $("body").on("click", ".jconfirm-buttons button", function () {
                        location.reload();
                    });
                    sendMessage(phoneBase, 'Uma nova avaliação na loja: ' + response.slug);
                    sendMessage(response.phone, response.client +' avaliou sua loja como:'+ response.answer+'. \r\n Avaliação referente ao pedido:' + response.numberOrder + ' Realizado no Fomix');

                }
            },
            complete: function () {
                $(".load").fadeOut("fast");
            }
        });
        return false;
    });


    //CUPON INFOR
    $(".js-coupon-info").click(function () {
        var info = $(this).find("img").attr("alt");
        alertMensage(info, '#FF9400');
    });

    //CUPOM SHOP MODAL
    $(".jsc-close-coupon-home").click(function () {
        $(".dialog-coupon-home").remove(".dialog-coupon-home");
        return false;
    });

    $(".jsc-like").click(function (){
       var likeId = $(this).data("like-id");
       var enterpriseSlug = $(this).data("enterprise-slug");


       $("#"+likeId).attr("src", BASE+"/themes/plus/assets/images/icon-like-active.png");
        var uri = BASE+"/feed/like";
       $.ajax({
           url:uri,
           dataType:'json',
           data:{likeId:likeId, client:clientLike, enterpriseSlug:enterpriseSlug},
           method:'post',
           success:function (response){
               sendMessage(response.phone, '😍🥰 Ebaa. '+response.enterprise+' . A Fomix informa: Uma postagem sua recebeu uma curtida❤️de ' +response.client);
               sendMessage(phoneBase, '😍🥰 Ebaa. '+response.enterprise+' . A Fomix informa: Uma postagem sua recebeu uma curtida❤️de ' +response.client);
           }
       });

        return false;
    });


    //FUNÇÃO PARA EXECUTAR O ALERTA
    function alertMensage(message, color) {
        $.alert({
            title: "Atenção",
            titleClass: 'roboto',
            content: message,
            theme: 'light',
            icon: 'icon-warning',
            draggable: true,
            animation: 'zoom',
            boxWidth: '90%',
            useBootstrap: false,
            type: color,
            scrollToPreviousElement: false
        });
    }

    //MASCARAS
    $(".mask-document").mask('000.000.000-00', {reverse: true});
    $(".mask-document-enterprise").mask('00.000.000/0000-00', {reverse: true});
    $(".mask-phone").mask('(99)9 99999999');
    $(".mask-zip-code").mask("99999-999");


});