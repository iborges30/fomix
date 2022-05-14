<?php
if (empty($evaluation)):
    ?>
    <div class="ds-flex all">
        <div class="modal-evaluate">
            <div class="modal-close-evaluation jsc-modal-close-evaluation">X</div>
            <div class="evaluation">
                <form action="" name="formEvaluation" method="post">
                    <?= csrf_input(); ?>
                    <input type="hidden" name="client_id" class="jsc-client-evaluation-id">
                    <input type="hidden" name="order_id" class="jsc-order-id">
                    <input type="hidden" name="enterprise_phone" class="jsc-enterprise-phone">
                    <input type="hidden" name="enterprise" class="jsc-enterprise-evaluation">

                    <label style="margin-top: 55px; display: block" ><p class="poppins">Avaliação pedido: #<span class="jsc-numer-order"> - </span></p></label>
                    <textarea name="evaluation" id="" cols="30" rows="8" maxlength="255" required></textarea>
                    <input type="submit" name="sendEvaluation" value="Avaliar" class="btn-evaluation">
                    <div class="load ds-none">
                        <img src="<?= theme("/assets/images/load.gif", CONF_VIEW_THEME); ?>" alt="Load">
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php
else:
    ?>
    <div class="ds-flex all">
        <div class="modal-evaluate">
            <div class="modal-close-evaluation jsc-modal-close-evaluation">X</div>
            <div class="evaluation">
                <p class="poppins"><b>Você avaliou o pedido ##<span class="jsc-numer-order"> - </span></b></p>
                <p class="mtb-30"><?= $evaluation->evaluation;?></p>
            </div>
        </div>
    </div>
<?php
endif;
?>