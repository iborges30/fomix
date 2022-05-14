<div class="dialog-coupon">
    <div class="modal-coupon">
        <div class="message-alert"></div>
        <div class="title-cupom-box">
            <div class="image-coupon">
                <img src="<?= theme("/assets/images/selo.JPG"); ?>" alt="Cupom">
            </div>


            <div class="title-cupom">
                <h2>Cupom: <?= $coupon->name; ?></h2>
                <p>Garanta antes que acabe. Aproveite!</p>
            </div>

            <div class="close-coupon">
                <a href="#" class="jsc-close-coupon">X</a>
            </div>
        </div>

        <div class="message-apply"></div>

        <div class="voucher">
            <div class="voucher-load">
                <img src="<?= theme('assets/images/load.gif', CONF_VIEW_THEME);?>" alt="Load">
            </div>
            <a href="#" class="poppins jsc-apply-coupon"
               data-coupon-id="<?= $coupon->id; ?>"
               data-enterprise-id="<?= $enterprise->id; ?>">APLICAR CUPOM</a>
        </div>

        <div class="voucher-card--terms">
            <a href="#"> Ver regras</a>
            <p>Válido até <?= date("d/m/Y", strtotime($coupon->end_date)); ?></p>
        </div>

    </div>
</div>