<?php $v->layout("_admin"); ?>
<div class="container-fluid">
    <!--- MODAL  --->
    <?= $v->insert("widgets/products/modal"); ?>
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
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Produto</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="flavor-tab" data-toggle="tab" href="#flavor" role="tab" aria-controls="flavor" aria-selected="true">Sabores</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="options-tab" data-toggle="tab" href="#options" role="tab" aria-controls="options" aria-selected="true">Opicionais</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="additional-tab" data-toggle="tab" href="#additional" role="tab" aria-controls="additional" aria-selected="true">Adicionais</a>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body bg-white radius shadow-sm">
                        <?php if (!$product) : ?>
                            <form action="<?= url("/admin/products/manager"); ?>" method="post" name="formProduct" class="p-2">
                                <div class="tab-content " id="myTabContent">
                                    <!-- PRODUCTS -->
                                    <?= $v->insert("widgets/products/tabs-product"); ?>
                                    <!-- PRODUCTS -->
                                </div>
                            </form>
                        <?php else : ?>
                            <form action="<?= url("/admin/products/manager/{$product->id}"); ?>" method="post" name="formUpdateProduct" class="p-2" enctype="multipart/form-data">
                                <div class="tab-content " id="myTabContent">
                                    <!-- PRODUCTS -->
                                    <?= $v->insert("widgets/products/tabs-product"); ?>
                                    <!-- PRODUCTS -->
                                </div>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bar Chart -->
    </div>
</div>

<?= $v->start("scripts"); ?>

<script>
    //ABRE A MODAL PARA GERAR NOVA CATEGORIA
    $(".jsc-category").change(function() {
        var category = $(this).val();
        if (category === 'category') {
            $('#new-category').modal("show");
        }
    });
    // TAB ACTIVE BUTTON
    $('.tab-button').click(function() {
        var activeTab = $(this).attr('data-next');
        $('.nav-link').removeClass('active');
        $(activeTab).addClass('active');
        $("html, body").animate({
            scrollTop: 0
        }, 600);

    })
    //ABRE O CAMPO MAX OPTION
    $(".jsc-option").change(function() {
        var option = $(this).val();
        if (option === 'yes') {
            $('.jsc-max-option').fadeIn("fast", function() {
                $("input[name='max_option']").attr("required", true);
            });
        } else {
            $('.jsc-max-option').fadeOut("fast", function() {
                $("input[name='max_option']").removeAttr("required");
                $("input[name='max_option']").val('');

            });

        }
    });



    //ABRE O CAMPO MAX ADDITIONAL
    $(".jsc-additional").change(function() {
        var option = $(this).val();
        if (option === 'yes') {
            $('.jsc-max-additional').fadeIn("fast", function() {
                $("input[name='max_additional']").attr("required", true);
            });
        } else {
            $('.jsc-max-additional').fadeOut("fast", function() {
                $("input[name='max_additional']").removeAttr("required");
                $("input[name='max_additional']").val('');
            });

        }
    });

    //ABRE O CAMPO MAX ADDITIONAL
    $(".jsc-flavors").change(function() {
        var option = $(this).val();
        if (option === 'yes') {
            $('.jsc-max-flavors').fadeIn("fast", function() {
                $("input[name='max_flavors']").attr("required", true);
            });
           // $('.ds-none-tab-flavor').slideDown( "slow");
        } else {
            $('.jsc-max-flavors').fadeOut("fast", function() {
                $("input[name='max_flavors']").removeAttr("required");
                $("input[name='max_flavors']").val('');
            });
           // $('.ds-none-tab-flavor').fadeOut("fast");
        }
    });

    $('#modal-flavor-add').on('click','.js-flavor-add',function(){
        var span = $(this);
        var flavor = $(span).attr('data-name');
        var id = $(span).attr('data-id');
        setTimeout(function(){
            $(span).css('display','none');
            $('#modal-flavor-rm').append('<span id="'+id+'" data-name="'+flavor+'" data-id="'+id+'" class="btn btn-block btn-light js-flavor-rm"><i class="fas fa-angle-double-left"></i> &nbsp; '+flavor+'</span>')
        },200)
    })
    $('#modal-flavor-rm').on('click','.js-flavor-rm',function(){
        var span = $(this);
        var flavor = $(span).attr('data-name');
        var id = $(span).attr('data-id');
        setTimeout(function(){
            $(span).css('display','none');
            $('#modal-flavor-add').append('<span id="'+id+'" data-name="'+flavor+'" data-id="'+id+'" class="btn btn-block btn-light js-flavor-add">'+flavor+' &nbsp; <i class="fas fa-angle-double-right"></i></span>')
        },200)
    })
    //GERA A NOVA CATEGORIA
    $("form[name='formCategoryProducts']").submit(function() {
        var dados = $(this).serialize();
        var url = $(this).attr("action");

        $.ajax({
            url: url,
            method: 'post',
            dataType: 'json',
            data: dados,
            beforeSend: function() {
                $(".csw-load").fadeIn("fast");
            },
            success: function(response) {
                if (response.message == 'error') {
                    alert("Verifique o nome da categoria informada, possívelmente ela já existe no sistema.");
                } else {
                    $("#new-category").modal("hide");
                    $(".jsc-category").append("<option selected value='" + response.value + "'>" + response.name + "</option>");
                }
            },
            complete: function() {
                $(".csw-load").fadeOut("fast");
            }
        });

        return false;
    });
</script>
<?= $v->end("scripts"); ?>