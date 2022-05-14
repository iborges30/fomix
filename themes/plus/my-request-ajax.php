<?php
if ($order) :
    foreach ($order as $v) :
?>
        <div class="row">
            <div class="col-1">

                <div class="client-title">
                    <header>
                        <h1 class="text-center text-dark">STATUS DO PEDIDO #<?= $v->id; ?></h1>
                    </header>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-8 text-status status-tex-complete">
                PEDIDO ENVIADO
            </div>
            <div class="col-4">
                <svg aria-hidden="true" height="70" width="70" focusable="false" data-prefix="fas" data-icon="paper-plane" class="svg-status svg-inline--fa fa-paper-plane fa-w-16 status-complete" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path fill="currentColor" d="M476 3.2L12.5 270.6c-18.1 10.4-15.8 35.6 2.2 43.2L121 358.4l287.3-253.2c5.5-4.9 13.3 2.6 8.6 8.3L176 407v80.5c0 23.6 28.5 32.9 42.5 15.8L282 426l124.6 52.2c14.2 6 30.4-2.9 33-18.2l72-432C515 7.8 493.3-6.8 476 3.2z"></path>
                </svg>
            </div>
        </div>
        <div class="row">
            <div class="col-8 text-status  <?= $v->status >= '2' ? 'status-tex-complete' : ''; ?>">
                EM PRODUÇÃO
            </div>
            <div class="col-4">

                <svg aria-hidden="true" height="70" width="70" focusable="false" data-prefix="fas" data-icon="utensils" class="svg-status svg-inline--fa fa-utensils fa-w-13 <?= $v->status >= '2' ? 'status-complete' : ''; ?>" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 416 512">
                    <path fill="currentColor" d="M207.9 15.2c.8 4.7 16.1 94.5 16.1 128.8 0 52.3-27.8 89.6-68.9 104.6L168 486.7c.7 13.7-10.2 25.3-24 25.3H80c-13.7 0-24.7-11.5-24-25.3l12.9-238.1C27.7 233.6 0 196.2 0 144 0 109.6 15.3 19.9 16.1 15.2 19.3-5.1 61.4-5.4 64 16.3v141.2c1.3 3.4 15.1 3.2 16 0 1.4-25.3 7.9-139.2 8-141.8 3.3-20.8 44.7-20.8 47.9 0 .2 2.7 6.6 116.5 8 141.8.9 3.2 14.8 3.4 16 0V16.3c2.6-21.6 44.8-21.4 48-1.1zm119.2 285.7l-15 185.1c-1.2 14 9.9 26 23.9 26h56c13.3 0 24-10.7 24-24V24c0-13.2-10.7-24-24-24-82.5 0-221.4 178.5-64.9 300.9z"></path>
                </svg>
            </div>
        </div>
        <?php if ($v->send == 'store') : ?>
            <div class="row">
                <div class="col-8 text-status  <?= $v->status == '6' ? 'status-tex-complete' : ''; ?>">
                    PRONTO PARA RETIRAR
                </div>
                <div class="col-4">

                    <svg aria-hidden="true" height="70" width="70" focusable="false" data-prefix="fas" data-icon="check-circle" class="svg-status svg-inline--fa fa-check-circle fa-w-16 <?= $v->status == '6' ? 'status-complete' : ''; ?>" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path fill="currentColor" d="M504 256c0 136.967-111.033 248-248 248S8 392.967 8 256 119.033 8 256 8s248 111.033 248 248zM227.314 387.314l184-184c6.248-6.248 6.248-16.379 0-22.627l-22.627-22.627c-6.248-6.249-16.379-6.249-22.628 0L216 308.118l-70.059-70.059c-6.248-6.248-16.379-6.248-22.628 0l-22.627 22.627c-6.248 6.248-6.248 16.379 0 22.627l104 104c6.249 6.249 16.379 6.249 22.628.001z"></path>
                    </svg>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($v->send != 'store') : ?>
            <div class="row">
                <div class="col-8  text-status  <?= $v->status >= '3' ? 'status-tex-complete' : ''; ?>">
                    SAIU PARA ENTREGA
                </div>
                <div class="col-4">

                    <svg aria-hidden="true" height="70" width="70" focusable="false" data-prefix="fas" data-icon="motorcycle" class="svg-status svg-inline--fa fa-motorcycle fa-w-20 <?= $v->status >= '3' ? 'status-complete' : ''; ?>" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                        <path fill="currentColor" d="M512.9 192c-14.9-.1-29.1 2.3-42.4 6.9L437.6 144H520c13.3 0 24-10.7 24-24V88c0-13.3-10.7-24-24-24h-45.3c-6.8 0-13.3 2.9-17.8 7.9l-37.5 41.7-22.8-38C392.2 68.4 384.4 64 376 64h-80c-8.8 0-16 7.2-16 16v16c0 8.8 7.2 16 16 16h66.4l19.2 32H227.9c-17.7-23.1-44.9-40-99.9-40H72.5C59 104 47.7 115 48 128.5c.2 13 10.9 23.5 24 23.5h56c24.5 0 38.7 10.9 47.8 24.8l-11.3 20.5c-13-3.9-26.9-5.7-41.3-5.2C55.9 194.5 1.6 249.6 0 317c-1.6 72.1 56.3 131 128 131 59.6 0 109.7-40.8 124-96h84.2c13.7 0 24.6-11.4 24-25.1-2.1-47.1 17.5-93.7 56.2-125l12.5 20.8c-27.6 23.7-45.1 58.9-44.8 98.2.5 69.6 57.2 126.5 126.8 127.1 71.6.7 129.8-57.5 129.2-129.1-.7-69.6-57.6-126.4-127.2-126.9zM128 400c-44.1 0-80-35.9-80-80s35.9-80 80-80c4.2 0 8.4.3 12.5 1L99 316.4c-8.8 16 2.8 35.6 21 35.6h81.3c-12.4 28.2-40.6 48-73.3 48zm463.9-75.6c-2.2 40.6-35 73.4-75.5 75.5-46.1 2.5-84.4-34.3-84.4-79.9 0-21.4 8.4-40.8 22.1-55.1l49.4 82.4c4.5 7.6 14.4 10 22 5.5l13.7-8.2c7.6-4.5 10-14.4 5.5-22l-48.6-80.9c5.2-1.1 10.5-1.6 15.9-1.6 45.6-.1 82.3 38.2 79.9 84.3z"></path>
                    </svg>
                </div>
            </div>
        <?php endif; ?>
<?php endforeach;
endif;
?>