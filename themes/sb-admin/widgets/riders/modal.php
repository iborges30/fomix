<div class="modal " tabindex="-1" role="dialog" id="riderss" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border: none">
            <div class="modal-header bg-success">
                <h5 class="modal-title" style="color: #fff;"><i class="fas fa-search-plus"></i>
                    Selecione o código do pedido para realizar a entrega
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body ajax-modal">
                <form action="<?= url("/admin/riders/modal/client");?>" name="formSearchOrder" class="ajax_off" method="post">
                    <div class="form-row">
                        <div class="form-group col-md-10">
                            <div class="category-response"></div>
                            <select name="order_id" class="form-control" id="">
                                <?php
                                foreach ($orders as $p):
                                ?>
                                <option value="<?= $p->id;?>"><?= $p->id;?> - <?= $p->client;?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <div class="form-group col-md-2" >
                            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i>
                                Enviar
                            </button>
                        </div>

                    </div>

                    <div class="jsc-response-clients"></div>
                    <img class="csw-load" src="<?=theme("/assets/images/load.gif", CONF_VIEW_ADMIN);?>" alt="load" style="margin-left: 10px; display: none;">
                </form>
            </div>
        </div>
    </div>
</div>