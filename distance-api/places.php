<?php

use App\Places;

header('Content-Type: application/json');

require './vendor/autoload.php';

$input = filter_input(INPUT_GET, 'input', FILTER_SANITIZE_STRING);

$places = new Places();

$result = $places->getPlaces($input);
?>
<ul>
    <?php foreach ($result->predictions as $prediction) : ?>
        <!--Busquei os dados de "structured_formatting" e envolvi em um Span-->
        <li class="place-item" data-description="<?= $prediction->description; ?>">
            <span><?= $prediction->structured_formatting->main_text; ?></span>
            <?= $prediction->structured_formatting->secondary_text; ?>
        </li>
    <?php endforeach; ?>
</ul>