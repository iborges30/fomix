<?php $v->layout("_theme"); ?>
<?php
/*
if (!empty($coupons)):?>
    <!-- MODAL CUPOM -->
    <div class="dialog-coupon-home ds-flex">
        <div class="position">
            <div class="coupom-home">
                <img src="<?= theme("/assets/images/cupom.jpg"); ?>" alt="Cupom de desconto"
                     class="jsc-close-coupon-home">
            </div>

            <div class="close-coupon-home">
                <a href="#" class="jsc-close-coupon-home">X</a>
            </div>
        </div>

    </div>
    <!-- MODAL CUPOM -->
<?php endif;*/ ?>

<!--- Aqui vai o cabeçalho-->
<div class="all fomix" style="height: 0">
    <div class="position">
        <div class="menu-mobile open-menu">
            <input type="checkbox" id="check">
            <label for="check"></label>
            <span></span>
        </div>
    </div>
</div>


<nav class="navegation-mobile-list ds-none">
    <p class="roboto text-dark title-menu icon-link">TERMOS DE USO</p>
    <ul>
        <li><a href="<?= url("/documents/termos-de-uso-usuario.pdf"); ?>" class="roboto text-dark">TERMOS DE USO</a>
        </li>
        <li><a href="<?= url("/documents/politica-de-privacidade.pdf"); ?>" class="roboto text-dark">Política de
                Privacidade</a>
        </li>

        <li><a href="<?= url("/documents/politica-de-cookies.pdf"); ?>" class="roboto text-dark">Política de Cookies</a>
        </li>

        </li>
    </ul>

    <div class="social-media">
        <p class="roboto text-dark title-menu icon-link">CANAIS DE ATENDIMENTO</p>
        <a href="https://www.facebook.com/fomix360" class="roboto text-dark icon-facebook"></a>
        <a href="#" class="roboto text-dark icon-instagram"></a>
        <a href="https://wa.me/65996622520" class="roboto text-dark icon-whatsapp"></a>
    </div>
</nav>


<?php
if (!empty($feed)):
    ?>
    <div class="feed-enterprise">
        <div class="feed-enterprise all">
            <div class="container">
                <div class="row">
                    <div class="col-1">
                        <div class="feed-title">
                            <p class="poppins text-dark">Feed</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <nav class="profile-enterprise">
            <ul>

                <?php
                foreach ($feed as $f):
                    ?>

                    <li>
                        <div class="profile-enterprise-content flex">
                            <div class="profile-enterprise-image">
                                <img   src="<?= photo_scr($f->profile,  40, 40); ?>">
                            </div>
                            <div class="profile-enterprise-name">
                                <span class="poppins text-dark"><?= str_limit_words($f->enterprise, 1); ?></span>
                            </div>
                        </div>
                        <div class="list-itens-feed mt-20">
                            <a href="<?=url("/feed/{$city}#{$f->slug}");?>"><img src="<?= photo_scr($f->image,  400, 400); ?>"></a>
                        </div>
                    </li>
                <?php
                endforeach;
                ?>
            </ul>
        </nav>
    </div>
<?php
endif;
?>


<!-- LISTA RESTAURANTES -->
<div class="all menu-shops">
    <div class="container">
        <header>
            <h1 class="roboto text-dark">
                Nossas Lojas
            </h1>
        </header>

    </div>
</div>

<!--
<div class="all">
  <nav class="menu bg-menu">
      <ul>
          <li><a href="https://fomix.net.br/plus/dods-fast-food" class="roboto">Lanches e Fast Food</a></li>
          <li><a href="https://darlu.darluck.com.br/" class="roboto ">Sabontes e cosméticos</a></li>
           <li><a href="refrigerantes" class="roboto ">Refrigerantes</a></li>
          <li><a href="acai" class="roboto " id="15">Açaí</a></li>
          <li><a href="batata-frita" class="roboto ">Batata frita</a></li>
          <li><a href="suco-natural" class="roboto ">Suco natural</a></li>

          <li><a href="acai" class="roboto " id="15">Açaí</a></li>
          <li><a href="batata-frita" class="roboto ">Batata frita</a></li>
          <li><a href="suco-natural" class="roboto ">Suco natural</a></li>

        </ul>
    </nav>

   <div class="search all">
        <form action="" method="POST" name="formSearch">
            <input type="text" name="s" placeholder="O que você gostaria de comer?">
            <button class="btn btn-search"></button>
        </form>
    </div> 
</div>
-->


<div class="all">
    <div class="container">
        <div class="items producst-in-home bottom-adjustment">
            <!-- <div class="title-menu">
                <h2 class="roboto text-dark">Burguers</h2>
            </div>-->

            <!-- PRODUCTS -->
            <ul>
                <?php
                foreach ($data as $v) :

                    ?>
                    <li>
                        <div class="description-item" data-product="2">
                            <a href="<?= url("/" . $v->slug); ?>"
                               class="name-item roboto text-dark"><b><?= $v->enterprise; ?></b></a>
                            <a href="<?= url("/" . $v->slug); ?>" class="roboto">
                                <p class="roboto description-text-item">
                                    Tempo de entrega: <b><?= $v->time_delivery; ?></b>
                                </p>
                                <?php
                                if ($v->delivery_fee <= 0) : ?>
                                    <p class="roboto description-text-item free">
                                        <b> ENTREGA GRÁTIS</b>
                                    </p>
                                <?php
                                else :
                                    ?>
                                    <p class="roboto description-text-item">
                                        Taxa de entrega: <b> R$ <?= str_price($v->delivery_fee); ?></b>
                                    </p>
                                <?php
                                endif; ?>

                                <!-- <p class="roboto description-text-item">
                                    Contato: ....
                                </p>-->

                                <p class="roboto description-text-item">
                                    Cidade: <b><?= ($v->city); ?></b>
                                </p>

                                <?php
                                if (!empty($coupons)):
                                    foreach ($coupons as $c):
                                        if ($v->id == $c->enterprise_id):
                                            ?>
                                            <div class="mix-coupon">
                                                <span>Cupon de <?= round($disconunt->disconunt); ?>% disponível</span>
                                            </div>
                                        <?php
                                        endif;
                                    endforeach;
                                endif;
                                ?>
                            </a>
                        </div>

                        <div class="image-item image-item-round">
                            <a title="<?= $v->enterprise; ?>" href="<?= url("/" . $v->slug); ?>">
                                <img name="<?= $v->enterprise; ?>" alt="<?= $v->enterprise; ?>"
                                     src="<?= photo_shops($v->image); ?>" alt="<?= $v->enterprise; ?>"
                                     class="<?= $v->status == 'close' ? ' shop-close-home' : ' shop-open-home'; ?> ">
                            </a>
                        </div>
                    </li>
                <?php
                endforeach;
                ?>

            </ul>
        </div>
    </div>
</div>