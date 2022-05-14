<?php

date_default_timezone_set('America/Cuiaba');
/**
 * DATABASE
 */
define("CONF_DB_HOST", "localhost");
define("CONF_DB_USER", "root");
define("CONF_DB_PASS", "");
define("CONF_DB_NAME", "fomix");

/**
 * PROJECT URLs
 */
define("CONF_URL_BASE", "https://localhost/fomix");
define("CONF_URL_TEST", "https://localhost/fomix");
/**
 * SITE
 */
define("CONF_SITE_NAME", "Fomix - O melhor Aplicativo de delivery e Mercado ");
define("CONF_SITE_TITLE", "Faça seu pedido de maneira rápida e divertida.");
define(
    "CONF_SITE_DESC",
    "O fomix é a maneira mais rápida e divertida de matar a fome. Deu fome ? Fomix ."
);
define("CONF_SITE_LANG", "pt_BR");
define("CONF_SITE_DOMAIN", "fomix.net.br");
define("CONF_SITE_ADDR_STREET", "Rua J 1855N Tarumã");
define("CONF_SITE_ADDR_NUMBER", "1855");
define("CONF_SITE_ADDR_COMPLEMENT", "Perto do campinho da Cohab");
define("CONF_SITE_ADDR_CITY", "Tangará da Serra");
define("CONF_SITE_ADDR_STATE", "MT");
define("CONF_SITE_ADDR_ZIPCODE", "78300-000");

/**
 * SOCIAL
 */
define("CONF_SOCIAL_TWITTER_CREATOR", "@creator");
define("CONF_SOCIAL_TWITTER_PUBLISHER", "@creator");
define("CONF_SOCIAL_FACEBOOK_APP", "5555555555");
define("CONF_SOCIAL_FACEBOOK_PAGE", "fomix360");
define("CONF_SOCIAL_FACEBOOK_AUTHOR", "author");
define("CONF_SOCIAL_GOOGLE_PAGE", "5555555555");
define("CONF_SOCIAL_GOOGLE_AUTHOR", "5555555555");
define("CONF_SOCIAL_INSTAGRAM_PAGE", "insta");
define("CONF_SOCIAL_YOUTUBE_PAGE", "youtube");

/**
 * DATES
 */
define("CONF_DATE_BR", "d/m/Y H:i:s");
define("CONF_DATE_APP", "Y-m-d H:i:s");

/**
 * PASSWORD
 */
define("CONF_PASSWD_MIN_LEN", 6);
define("CONF_PASSWD_MAX_LEN", 40);
define("CONF_PASSWD_ALGO", PASSWORD_DEFAULT);
define("CONF_PASSWD_OPTION", ["cost" => 10]);

/**
 * VIEW
 */
define("CONF_VIEW_PATH", __DIR__ . "/../../shared/views");
define("CONF_VIEW_EXT", "php");
define("CONF_VIEW_THEME", "plus");
define("CONF_VIEW_APP", "cafeapp");
define("CONF_VIEW_ADMIN", "sb-admin");
define("CONF_VIEW_DELIVERY", "delivery");

/**
 * UPLOAD
 */
define("CONF_UPLOAD_DIR", "storage");
define("CONF_UPLOAD_IMAGE_DIR", "images");
define("CONF_UPLOAD_FILE_DIR", "files");
define("CONF_UPLOAD_MEDIA_DIR", "medias");

/**
 * IMAGES
 */
define("CONF_IMAGE_CACHE", CONF_UPLOAD_DIR . "/" . CONF_UPLOAD_IMAGE_DIR . "/cache");
define("CONF_IMAGE_SIZE", 2000);
define("CONF_IMAGE_QUALITY", ["jpg" => 75, "png" => 5]);

/**
 * MAIL
 */
define("CONF_MAIL_HOST", "smtp.sendgrid.net");
define("CONF_MAIL_PORT", "587");
define("CONF_MAIL_USER", "apikey");
define("CONF_MAIL_PASS", "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");
define("CONF_MAIL_SENDER", ["name" => "Robson V. Leite", "address" => "sender@email.com"]);
define("CONF_MAIL_SUPPORT", "sender@support.com");
define("CONF_MAIL_OPTION_LANG", "br");
define("CONF_MAIL_OPTION_HTML", true);
define("CONF_MAIL_OPTION_AUTH", true);
define("CONF_MAIL_OPTION_SECURE", "tls");
define("CONF_MAIL_OPTION_CHARSET", "utf-8");

/**
 * PAGAR.ME
 */
define("CONF_PAGARME_MODE", "test");
define("CONF_PAGARME_LIVE", "ak_live_*****");
define("CONF_PAGARME_TEST", "ak_test_*****");
define("CONF_PAGARME_BACK", CONF_URL_BASE . "/pay/callback");

/**
 * ALERTS
 */
define("CONF_ALERT_MESSAGE", "alert");
define("CONF_ALERT_SUCCESS", ["class" => "alert-success", "icon" => "fas fa-fw fa-check-circle"]);
define("CONF_ALERT_DANGER", ["class" => "alert-danger", "icon" => "fas fa-fw fa-times-circle"]);
define("CONF_ALERT_WARNING", ["class" => "alert-warning", "icon" => "fas fa-fw fa-exclamation-circle"]);
define("CONF_ALERT_INFO", ["class" => "alert-info", "icon" => "fas fa-fw fa-info-circle"]);

/**
 * IMAGES
 */
define("CONF_IMAGE_DEFAULT_AVATAR", "/assets/images/webp/default-avatar.webp");
define("CONF_IMAGE_NO_AVAILABLE_1BY1", "/assets/images/webp/no-image-available-1by1.webp");
define("CONF_IMAGE_NO_AVAILABLE_16BY9", "/assets/images/webp/no-image-available-16by9.webp");
