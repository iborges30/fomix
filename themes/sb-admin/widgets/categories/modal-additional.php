        <!--- MODAL  --->
        <div class="modal fade " tabindex="-1" role="dialog" id="new-additional-item">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" style="border: none">
                    <div class="modal-header bg-info">
                        <h5 class="modal-title" style="color: #fff;"><i class="fas fa-plus"></i> Novo item adicional </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="<?= url("/admin/additional-items/relationship"); ?>" name="formAdditionalRelationship" class="ajax_off" method="post">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <input type="hidden" name="action" value="relationship">
                                    <input type="hidden" name="category_id" value="<?= $categoryId; ?>">
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="inputEmail4">Item adicional</label>
                                    <select name="additional_id" class="form-control">
                                        <?php
                                        
                                        foreach ($additionals as $p) :
                                        ?>
                                            <option value="<?= $p->id; ?>"><?= $p->additional; ?></option>
                                        <?php
                                        endforeach;
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i>
                                Novo item
                            </button>
                            <img class="csw-load ml-4 ds-none" src="<?= theme("/assets/images/load.gif", CONF_VIEW_ADMIN); ?>" alt="load">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--- MODAL -->