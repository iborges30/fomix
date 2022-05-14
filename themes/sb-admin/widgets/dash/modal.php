<div class="modal " tabindex="-1" role="dialog" id="observations-orders" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border: none">
            <div class="modal-header bg-success">
                <h5 class="modal-title" style="color: #fff;"><i class="fas fa-search-plus"></i>
                   Inserir Observação no Pedido</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body ajax-modal">
                <form action="<?= url("/admin/dash/notes");?>" name="formNote" class="ajax_off" method="post">
                    <input type="hidden" name="observatio_order_id">
                    <div class="form-row">
                        <div class="form-group col-md-10">
                            <label for="inputAddress2">Informe uma nota sobre o pedido</label>
                            <div class="category-response"></div>
                            <input type="text" name="note" required="" value="" placeholder="Informe uma nota" autocomplete="off" aria-describedby="basic-addon2" class="form-control  small">
                        </div>
                        <div class="form-group col-md-2" style="margin-top: 32px;">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i>
                                Atualizar
                            </button>
                        </div>

                    </div>

                    <div class="jsc-response-client"></div>
                    <img class="csw-load" src="<?=theme("/assets/images/load.gif", CONF_VIEW_ADMIN);?>" alt="load" style="margin-left: 10px; display: none;">
                </form>
            </div>
        </div>
    </div>
</div>