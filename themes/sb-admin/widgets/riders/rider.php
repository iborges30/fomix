<?php $v->layout("_admin"); ?>

<div class="ajax-modal-response"></div>
<?php if(empty($race)):?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-fw fa-pen-alt"></i>
            Nova Entrega
        </h1>
    </div>

    <form name="formRider" action="<?= url("/admin/ride/create"); ?>" method="post" class="ajax_off">
        <!--ACTION SPOOFING-->
        <input type="hidden" name="action" value="create">
        <div class="form-row">
            <div class="form-group col-md-3">
                <label for="first_name" class="required">Entre. App. Fomix</label>
                <select name="race_origin" class="form-control jsc-race-origin">
                    <option disabled>Escolha a origem da entega</option>
                    <?php
                    foreach (raceOrigin() as $key => $p):?>
                        <option value="<?= $key; ?>"><?= $p; ?></option>
                    <?php endforeach; ?>

                </select>
            </div>

            <div class="form-group col-md-9">
                <label for="first_name" class="required">Destino</label>
                <input type="text" name="arrival" class="form-control">
            </div>

            <div class="form-group col-md-3">
                <label for="first_name" class="required">Valor da entrega</label>
                <input type="text" name="race_price" class="form-control mask-money jsc-price-init">
            </div>


            <div class="form-group col-md-3">
                <label for="last_name" class="required">Veículo</label>
                <select name="vehicle" id="genre" class="form-control">
                    <?php
                    foreach (vehicleType() as $key => $p):?>
                        <option value="<?= $key; ?>"><?= $p; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group col-md-3">
                <label for="last_name" class="required">Compartimento</label>
                <select name="type_box" id="genre" class="form-control">
                    <?php
                    foreach (boxType() as $key => $p):?>
                        <option value="<?= $key; ?>"><?= $p; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group col-md-3">
                <label for="last_name" class="required">Retorna</label>
                <select name="back" id="genre" class="form-control jsc-get-back-rider">
                    <?php
                    foreach (gobackRider() as $key => $p):?>
                        <option value="<?= $key; ?>" <?= $key == 'no' ? 'selected ' : ''; ?>><?= $p; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="genre">Observações (opcional)</label>
            <textarea name="observations" id="" cols="0" rows="5" class="form-control"></textarea>
        </div>

        <div class="form-group text-right">
            <button class="btn btn-success btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-check"></i>
                    </span>
                <span class="text">Cadastrar</span>
            </button>
        </div>
    </form>

</div>
<?php
else:

    ?>
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-fw fa-pen-alt"></i>
                Editar Entrega
            </h1>
        </div>

        <form name="formRiderUpdate" action="<?= url("/admin/ride/update/{$race->id}"); ?>"
              method="post">
            <!--ACTION SPOOFING-->
            <input type="hidden" name="action" value="update">
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="first_name" class="required">Entre. App. Fomix</label>
                    <select name="race_origin" class="form-control jsc-race-origin">
                        <option disabled selected>Escolha a origem da entega</option>
                        <?php
                        foreach (raceOrigin() as $key => $p): ?>
                            <option value="<?= $key; ?>" <?= $key == $race->race_origin ? ' selected' :'';?>><?= $p; ?></option>
                        <?php endforeach; ?>

                    </select>
                </div>

                <div class="form-group col-md-9">
                    <label for="first_name" class="required">Destino</label>
                    <input type="text" value="<?= $race->arrival;?>" name="arrival" class="form-control">
                </div>

                <div class="form-group col-md-3">
                    <label for="first_name" class="required">Valor da entrega</label>
                    <input type="text" value="<?= str_price($race->race_price + $race->commission);?>" name="race_price"
                           class="form-control mask-money jsc-price-init">
                </div>


                <div class="form-group col-md-3">
                    <label for="last_name" class="required">Veículo</label>
                    <select name="vehicle" id="genre" class="form-control">
                        <?php
                        foreach (vehicleType() as $key => $p):?>
                            <option value="<?= $key; ?>" <?= $key == $race->vehicle ? ' selected' :'';?>><?= $p; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label for="last_name" class="required">Compartimento</label>
                    <select name="type_box" id="genre" class="form-control">
                        <?php
                        foreach (boxType() as $key => $p):?>
                            <option value="<?= $key; ?>" <?= $key == $race->type_box ? ' selected' :'';?>><?= $p; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label for="last_name" class="required">Retorna</label>
                    <select name="back" id="genre" class="form-control jsc-get-back-rider">
                        <?php
                        foreach (gobackRider() as $key => $p):?>
                            <option value="<?= $key; ?>" <?= $key == $race->back ? ' selected' :'';?>><?= $p; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="genre">Observações (opcional)</label>
                <textarea name="observations" id="" cols="0" rows="5" class="form-control"></textarea>
            </div>

            <div class="form-group text-right">
                <button class="btn btn-success btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-check"></i>
                    </span>
                    <span class="text">Atualizar</span>
                </button>
            </div>
        </form>

    </div>
<?php
endif;
?>


<?php $v->start("scripts"); ?>
<script src="https://cdn.socket.io/4.1.2/socket.io.min.js"
        integrity="sha384-toS6mmwu70G0fw54EGlWWeA4z3dyJ+dlXBtSURSKN4vyRFOcxd3Bzjj/AoOwY+Rg"
        crossorigin="anonymous"></script>
<script>
    const socket = io("wss://deliverybot.ml", {
        secure: true
    });

    function sendMessage(number, message) {
        socket.emit(
            "users",
            "sendMessage", {
                number: number,
                message: message
            },
            "fomix"
        );
    }

    $('.jsc-race-origin').change(function () {
        var dados = $(this).val();
        if (dados === 'fomix') {
            $.ajax({
                url: '<?=url("/admin/modal/race");?>',
                data: {
                    dados: dados
                },
                dataType: 'html',
                method: 'post',
                type: 'post',
                success: function (response) {
                    $(".ajax-modal-response").html(response);
                    $("#riderss").modal();
                }
            });

        }
    });


    $(".jsc-get-back-rider").change(function () {
        var dados = $(this).val();
        var price = $("input[name='race_price']").val().replace(".", "").replace(",", ".");
        price = parseFloat(price);
        var calcule = price + 0.7;
        calcule = String(calcule).replace(".", ",");
        var rate = calcule;

        if (dados == 'yes') {
            $("input[name='race_price']").val(rate).attr("readonly", true);
        } else {
            var removeRate = price - 0.7;
            removeRate = String(removeRate).replace(".", ",");
            $("input[name='race_price']").val(removeRate).attr("readonly", false);
        }
    });

    $("body").on("submit", "form[name='formSearchOrder']", function () {
        var dados = $(this).serialize();
        var uri = $(this).attr("action");
        $.ajax({
            url: uri,
            data: dados,
            type: "POST",
            dataType: "json",
            beforeSend: function () {
                $(".csw-load").fadeIn();
            },
            success: function (response) {
                if (response.client) {
                    $("input[name='race_price']").val(response.price);
                    $("input[name='arrival']").val(response.arrival);
                    $("#riderss").modal('hide');
                }
            },
            complete: function () {
                $(".csw-load").fadeOut();
            }
        });
        return false;
    });

    $("form[name='formRider']").submit(function () {
        var dados = $(this).serialize();
        var uri = $(this).attr("action");
        $.ajax({
            url: uri,
            data: dados,
            dataType: 'json',
            method: 'post',
            beforeSend: function () {
                $(".ajax_load").fadeIn().css("display", "flex");

            },
            success: function (response) {
                console.log(response);

                if (response.race) {
                    alert(response.race);
                }

                if (response.message) {
                    alert("Verifique se você deixou algum campo em branco");
                }
                if (response.success) {
                    sendMessage("6596487097", "Atenção: *Uma nova entrega foi criada no Fomix*.");
                    sendMessage("65996622520", "Nova entrega no Fomix.");
                    sendMessage("6599642673", "Atenção: *Uma nova entrega foi criada no Fomix*.");

                    alert("Entrega criada com sucesso");

                    setTimeout(function () {
                        location.reload();
                    }, 2000);

                }
            },
            complete: function () {
                $(".ajax_load").fadeOut().css("display", "none");
            }
        });

        return false;
    });


</script>
<?php $v->end("scripts"); ?>
