<ul>
    <?php
    if (!empty($products)) :
        foreach ($products as $p) : ?>
            <li class="jsc-produt" data-product="<?= $p->id; ?>">
                <div class="description-item">
                    <a href="<?= url("/product/{$p->id}"); ?>"
                       class="name-item roboto text-dark"><b><?= $p->name; ?></b></a>
                    <a href="<?= url("/product/{$p->id}"); ?>" class="roboto">
                        <p class="roboto description-text-item"><?= str_limit_chars($p->description, 50); ?></p>
                    </a>
                    <p class="roboto item-product-price">R$ <?= str_price($p->price); ?></p>
                </div>

                <div class="image-item">
                    <a title="<?= $p->name; ?>" href="<?= url("/product/{$p->id}"); ?>">
                        <img name="<?= $p->name; ?>" alt="<?= $p->name; ?>" src="<?= image($p->image, 600); ?>"/>
                    </a>
                </div>
            </li>

        <?php endforeach;
    endif; ?>
</ul>