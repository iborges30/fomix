<?php $v->layout("_theme"); ?>
<div class="dialog ds-none">
    <div class="load">
        <img src="<?= theme("assets/images/load.gif", CONF_VIEW_DELIVERY); ?>" alt="load">
    </div>
</div>


<?= $v->insert("profile"); ?>

<div class="ajax-delivery"></div>

<div class="div" style="margin: 130px 0;">
    <div class="menu-footer all bg-orange">
        <div class="container">
            <ul>
                <li>
                    <a href="" class="text-white jsc-user"><i class="fas fa-home"></i></a>
                </li>

                <li>
                    <a href="week.php" class="text-white jsc-week"><i class="fas fa-biking"></i></a>
                </li>

                <li>
                    <a href="<?= url("delivery/user/historic/" . base64_encode($delivery->id)); ?>"
                       class="text-white"><i class="fas fa-receipt"></i></a>
                </li>

                <li>
                    <a href="#" class="text-white jsc-turn-off" data-user="<?= base64_encode($delivery->id) ?>"><i
                                class="fas fa-times-circle"></i></a>
                </li>
            </ul>
        </div>
    </div>
</div>

