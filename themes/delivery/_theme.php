<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0,user-scalable=0">
    <?= $head; ?>
    <link rel="base" href="<?= url(); ?>"/>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= theme("/assets/css/boot.css", CONF_VIEW_DELIVERY); ?>"/>
    <link rel="stylesheet" href="<?= theme("/assets/css/style.css", CONF_VIEW_DELIVERY); ?>"/>
    <link rel="stylesheet" href="<?= theme("/assets/css/fontawesome-free-5.15.4-web/css/all.css", CONF_VIEW_DELIVERY); ?>"/>
</head>
<body>
<?= $v->section("content"); ?>

<script src="<?= theme("/assets/js/jquery.js", CONF_VIEW_DELIVERY);?>"></script>
<script src="<?= theme("/assets/js/functions.js", CONF_VIEW_DELIVERY);?>?id=<?=time();?>"></script>


</body>
</html>