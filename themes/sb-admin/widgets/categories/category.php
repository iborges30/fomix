<?php $v->layout("_admin"); ?>
<div class="container-fluid">

    <!--- MODAL -->
    <div class="ajax-modal-options"></div>
    <div class="ajax-modal-flavors"></div>
    <div class="ajax-modal-additional"></div>
    <!--- MODAL -->

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-fw fa-address-book"></i>
            Novo produto
        </h1>
    </div>

    <div class="row">
        <div class="col-xl-12 col-lg-7">
            <!-- Area Chart -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="col-sm-12 ">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Categoria</a>
                            </li>
                            

                        </ul>
                    </div>

                    <div class="card-body bg-white radius shadow-sm">
                        <div class="tab-content " id="myTabContent">
                            <!-- PRODUCTS -->
                            <?= $v->insert("widgets/categories/tabs-category"); ?>
                            <!-- PRODUCTS -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bar Chart -->
    </div>
</div>

<?= $v->start("scripts"); ?>

<script>
    //INCLUI OS ITENS DOS ITENS OPCIONAIS NO EVENTO DO CLICK DO TABS

    //TRAZER VIA AJAX OS DADOS DOS OPTIONS
    $(".jsc-options-items").click(function() {
        var categoryId = $(this).attr("data-category-id");

        $.ajax({
            url: "<?= url("/admin/options/related"); ?>",
            data: {
                id: categoryId
            },
            dataType: 'html',
            method: 'post',
            beforeSend: function() {
                $(".ajax_load").css("display", "flex").fadeIn("slow");
            },
            success: function(response) {
                $(".ajax-together").empty().html(response);

            },
            complete: function() {
                $(".ajax_load").css("display", "none").fadeOut("slow");
            }
        });
    });

    //GERA A MODAL PARA CADASTRAR OS OPCIONAIS
    $(".ajax-together").on("click", ".jsc-add-options", function() {
        var categoryId = $(this).data("category-id");
        //ABRE A MODAL VIA AJAX
        $.ajax({
            url: "<?= url("/admin/options-items/modal"); ?>",
            data: {
                id: categoryId
            },
            dataType: 'html',
            method: 'post',
            beforeSend: function() {
                $(".ajax_load").css("display", "flex").fadeIn("slow");
            },
            success: function(response) {
                $(".ajax-modal-options").empty().html(response);
                $("#new-option-item").modal("show");
            },
            complete: function() {
                $(".ajax_load").css("display", "none").fadeOut("slow");
            }

        });

    });

    //CRIA O RELACIONAMENTO ENTRE O PRODUTO E O ITEM OPCIONAL
    $(".ajax-modal-options").on("submit", "form[name='formRelationship']", function() {
        var dados = $(this).serialize();
        var url = $(this).attr("action");

        $.ajax({
            url: url,
            data: dados,
            dataType: 'json',
            method: 'post',
            beforeSend: function() {
                $(".ajax_load").css("display", "flex").fadeIn("slow");
            },
            success: function(response) {

                if (response.duplicate) {
                    alert("Você já adicionou este item a esta categoria.");
                }

                if (response.success) {
                    $("#new-option-item").modal("hide");

                    $(".row-prepend-ajax").prepend('<tr role="row" id="' + response.item_id + '">' +
                        '<td>' + response.item_id + '</td>' +
                        '<td>' + response.item + '</td>' +
                        '<td>' +
                        ' <a href="#" data-option-item-id="' + response.item_id + '"  data-action="delete" data-toggle="tooltip"  ' +
                        ' data-action="delete"' +
                        'data-post="' + response.url + '"   ' +
                        ' data-confirm="ATENÇÃO: Tem certeza que deseja excluir este item os dados relacionados a ela? Essa ação não pode ser feita!"' +
                        ' class="btn btn-danger btn-circle btn-sm ajax-delete-item">' +
                        '<i class="fas fa-cog"></i>' +
                        '</a>' +
                        '</td>' +
                        '</tr>');
                }
            },
            complete: function() {
                $(".ajax_load").css("display", "none").fadeOut("slow");
            }

        });

        return false;
    });


    //DELETA O ITEM
    $("body").on("click", ".jsc-delete-item", function() {
        var deleteId = $(this).data("option-item-id");
        var informations = $(this).data("confirm");
        var r = confirm(informations);
        var url = $(this).data("post");
        var action = $(this).data("action");
        if (r == true) {
            $.ajax({
                url: url,
                data: {
                    id: deleteId,
                    action: action
                },
                dataType: 'json',
                method: 'post',
                beforeSend: function() {
                    $("#" + deleteId).css("background", "#e74a3b");
                },
                success: function(response) {
                    if (response.delete) {
                        $("#" + deleteId).fadeOut("fast");
                    }
                }
            });
        }
        return false;
    });


    //DELETA O ITEM CRIADO NO AJAX
    $("body").on("click", ".ajax-delete-item", function() {
        var deleteId = $(this).data("option-item-id");
        var informations = $(this).data("confirm");
        var r = confirm(informations);
        var action = $(this).data("action");
        var url = $(this).data("post");

        if (r == true) {
            $.ajax({
                url: url,
                data: {
                    id: deleteId,
                    action: action
                },
                dataType: 'json',
                method: 'post',
                beforeSend: function() {
                    $("#" + deleteId).css("background", "#e74a3b");
                },
                success: function(response) {
                    if (response.delete) {
                        $("#" + deleteId).fadeOut("fast");
                    }
                }
            });
        }
        return false;
    });

    /*
     *****************************************
     ************** OPTIONS END **************
     *****************************************
     */

    //TRAZ OS SABORES VIA AJAX
    $(".jsc-flavors-items").click(function() {
        var categoryId = $(this).attr("data-category-id");
        $.ajax({
            url: "<?= url("/admin/flavors/related"); ?>",
            data: {
                id: categoryId
            },
            dataType: 'html',
            method: 'post',
            beforeSend: function() {
                $(".ajax_load").css("display", "flex").fadeIn("slow");
            },
            success: function(response) {
                $(".ajax-flavors").empty().html(response);

            },
            complete: function() {
                $(".ajax_load").css("display", "none").fadeOut("slow");
            }
        });
    });

    //GERA A MODAL PARA CADASTRAR OS SABORES
    $(".ajax-flavors").on("click", ".jsc-add-flavors", function() {
        var categoryId = $(this).data("category-id");
        //ABRE A MODAL VIA AJAX
        $.ajax({
            url: "<?= url("/admin/flavors-items/modal"); ?>",
            data: {
                id: categoryId
            },
            dataType: 'html',
            method: 'post',
            beforeSend: function() {
                $(".ajax_load").css("display", "flex").fadeIn("slow");
            },
            success: function(response) {
                $(".ajax-modal-flavors").empty().html(response);
                $("#new-flavors-item").modal("show");
            },
            complete: function() {
                $(".ajax_load").css("display", "none").fadeOut("slow");
            }
        });

    });


    //CADASTRA OS SABORES DA MODAL GERANDO O RELACIONAMENTO
    $(".ajax-modal-flavors").on("submit", "form[name='formFlavorRelationship']", function() {
        var dados = $(this).serialize();
        var url = $(this).attr("action");

        $.ajax({
            url: url,
            data: dados,
            dataType: 'json',
            method: 'post',
            beforeSend: function() {
                $(".ajax_load").css("display", "flex").fadeIn("slow");
            },
            success: function(response) {

                if (response.duplicate) {
                    alert("Você já adicionou este sabor a esta categoria.");
                }

                if (response.success) {
                    $("#new-flavors-item").modal("hide");

                    $(".row-prepend-ajax").prepend('<tr role="row" id="' + response.flavor_id + '">' +
                        '<td>' + response.flavor_id + '</td>' +
                        '<td>' + response.flavor + '</td>' +
                        '<td>' +
                        ' <a href="#" data-flavors-item-id="' + response.flavor_id + '" data-toggle="tooltip"  ' +
                        ' data-action="delete"' +
                        'data-post="' + response.url + '"   ' +
                        ' data-confirm="ATENÇÃO: Tem certeza que deseja excluir este item os dados relacionados a ela? Essa ação não pode ser feita!"' +
                        ' class="btn btn-danger btn-circle btn-sm jsc-delete-flavors">' +
                        '<i class="fas fa-cog"></i>' +
                        '</a>' +
                        '</td>' +
                        '</tr>');
                }
            },
            complete: function() {
                $(".ajax_load").css("display", "none").fadeOut("slow");
            }

        });

        return false;
    });




    //DELETA O ITEM
    $("body").on("click", ".jsc-delete-flavors", function() {
    
        var deleteId = $(this).data("flavors-item-id");
        var informations = $(this).data("confirm");
        var r = confirm(informations);
        var url = $(this).data("post");
        var action = $(this).data("action");
        if (r == true) {
            $.ajax({
                url: url,
                data: {
                    id: deleteId,
                    action: action
                },
                dataType: 'json',
                method: 'post',
                beforeSend: function() {
                    $("#" + deleteId).css("background", "#e74a3b");
                },
                success: function(response) {
                    if (response.delete) {
                        $("#" + deleteId).fadeOut("fast");
                    }
                }
            });
        }
        return false;
    });
    /*
     *****************************************
     ************** FLAVORS END **************
     *****************************************
     */

    //TRAZ OS ADICIONAIS VIA AJAX
    $(".jsc-additional-items").click(function() {
        var categoryId = $(this).attr("data-category-id");
        $.ajax({
            url: "<?= url("/admin/additional/related"); ?>",
            data: {
                id: categoryId
            },
            dataType: 'html',
            method: 'post',
            beforeSend: function() {
                $(".ajax_load").css("display", "flex").fadeIn("slow");
            },
            success: function(response) {
                $(".ajax-additionals").empty().html(response);

            },
            complete: function() {
                $(".ajax_load").css("display", "none").fadeOut("slow");
            }
        });
    });


    //GERA A MODAL PARA CADASTRAR OS SABORES
    $(".ajax-additionals").on("click", ".jsc-add-additional", function() {
        var categoryId = $(this).data("category-id");
        //ABRE A MODAL VIA AJAX
        $.ajax({
            url: "<?= url("/admin/additional-items/modal"); ?>",
            data: {
                id: categoryId
            },
            dataType: 'html',
            method: 'post',
            beforeSend: function() {
                $(".ajax_load").css("display", "flex").fadeIn("slow");
            },
            success: function(response) {
                $(".ajax-modal-additional").empty().html(response);
                $("#new-additional-item").modal("show");
            },
            complete: function() {
                $(".ajax_load").css("display", "none").fadeOut("slow");
            }
        });

    });


    //CADASTRA OS SABORES DA MODAL GERANDO O RELACIONAMENTO
    $(".ajax-modal-additional").on("submit", "form[name='formAdditionalRelationship']", function() {
        var dados = $(this).serialize();
        var url = $(this).attr("action");

        $.ajax({
            url: url,
            data: dados,
            dataType: 'json',
            method: 'post',
            beforeSend: function() {
                $(".ajax_load").css("display", "flex").fadeIn("slow");
            },
            success: function(response) {

                if (response.duplicate) {
                    alert("Você já adicionou este item a esta categoria.");
                }

                if (response.success) {
                    $("#new-additional-item").modal("hide");

                    $(".row-prepend-ajax").prepend('<tr role="row" id="' + response.additional_id + '">' +
                        '<td>' + response.additional_id + '</td>' +
                        '<td>' + response.additional + '</td>' +
                        '<td>' + response.price + '</td>' +
                        '<td>' +
                        ' <a href="#" data-additional-item-id="' + response.additional_id + '" data-toggle="tooltip"  ' +
                        ' data-action="delete"' +
                        'data-post="' + response.url + '"   ' +
                        ' data-confirm="ATENÇÃO: Tem certeza que deseja excluir este item os dados relacionados a ela? Essa ação não pode ser feita!"' +
                        ' class="btn btn-danger btn-circle btn-sm jsc-delete-additional">' +
                        '<i class="fas fa-cog"></i>' +
                        '</a>' +
                        '</td>' +
                        '</tr>');
                }
            },
            complete: function() {
                $(".ajax_load").css("display", "none").fadeOut("slow");
            }

        });

        return false;
    });


    $("body").on("click", ".jsc-delete-additional", function() {
    
    var deleteId = $(this).data("additional-item-id");
    var informations = $(this).data("confirm");
    var r = confirm(informations);
    var url = $(this).data("post");
    var action = $(this).data("action");
    if (r == true) {
        $.ajax({
            url: url,
            data: {
                id: deleteId,
                action: action
            },
            dataType: 'json',
            method: 'post',
            beforeSend: function() {
                $("#" + deleteId).css("background", "#e74a3b");
            },
            success: function(response) {
                if (response.delete) {
                    $("#" + deleteId).fadeOut("fast");
                }
            }
        });
    }
    return false;
});
</script>
<?= $v->end("scripts"); ?>