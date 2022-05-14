<?php $v->layout("_theme"); ?>

<div class="container">
    <div class="page-item ">
        <div class="go-back">
            <a href="<?= url("/cidades/{$city}"); ?>">
                <img src="<?= theme("/assets/images/go-back.png", CONF_VIEW_THEME); ?>" alt="go-back">
            </a>
        </div>
        <div class="page-item-title">
            <h1 class="poppins text-dark">FEED</h1>
        </div>
    </div>

    <div class="line-feed"></div>
</div>

<div class="all">
    <?php
    foreach ($feed as $f):
        ?>
        <div class="section-profile" id="<?= $f->slug;?>">

            <div class="feed-read flex p-20-l">
                <div class="profile-feed-read">
                    <img   src="<?= photo_scr($f->profile,  40, 40); ?>">
                </div>
                <div class="enterprise-feed-read text-dark poppins"><b><?= $f->enterprise;?></b></div>
            </div>

            <div class="items-feed-enterprise mt-20">
                <a href="<?= url("/{$f->slug}");?>">
                    <img src="<?= photo_scr($f->image,  1080, 1080); ?>">
                </a>
            </div>

            <div class="actions-feed-user flex">

                <div class="like">
                    <a class="jsc-like" href="#" data-like-id="<?= $f->id;?>" data-enterprise-slug="<?=$f->slug;?>">
                        <img id="<?= $f->id;?>" src="<?= theme("/assets/images/icon-like.png"); ?>" alt="Curtir">
                        <span class="roboto">Curtir</span>
                    </a>
                </div>
                <div class="share-feed">
                    <a href='whatsapp://send?text=<?= url("/{$f->slug}");?>'>
                        <img src="<?= theme("/assets/images/share-feed.png"); ?>" alt=""> <span class="roboto ">Compartilhar</span>
                    </a>
                </div>

                <div class="share-feed">
                    <?php
                    $link = $city=='tangara-da-serra' ? 'https://chat.whatsapp.com/I7WaaPWC1eSLGG2rjXgKTw' :'https://chat.whatsapp.com/D8hcqPIapKQI73zjN8m7Kj';
                    ?>
                    <a href="<?=$link;?>" target="_blank">
                        <img src="<?= theme("/assets/images/icon-list.png"); ?>" alt=""> <span class="roboto">Promoções</span>
                    </a>
                </div>

            </div>
            <div class="feed-text mtb-10"><?= $f->description;?></div>
        </div>
    <?php
    endforeach;
    ?>
</div>