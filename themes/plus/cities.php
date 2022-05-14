<?php $v->layout("_theme"); ?>

<div class="container ds-flex" style="height: 100vh;">
    <div class="client-form">
        <div class="fomix-cities">
            <img src="<?= theme("/assets/images/fomix.png", CONF_VIEW_THEME); ?>" alt="">
        </div>
        <label class="text-dark">
            VOCÊ ESTÁ EM 
        </label>

        <div class="row">
            <?php
            foreach ($enterprises as $p) :
                ?>
                <div class="col-2">
                    <div class="buttom-cities">
                        <a href="#" class="jsc-slug-city" data-city="<?= $p->slug_city; ?>"><?= $p->city; ?></a>
                    </div>
                </div>
            <?php
            endforeach; ?>


        </div>
    </div>

</div>
<script>
    var BASE = "https://fomix.net.br/plus";
    var cidade = window.localStorage.getItem('cidade');
    console.log(cidade);
    if (cidade) {
        window.location.href = BASE + '/cidades/' + cidade;
    }
</script>