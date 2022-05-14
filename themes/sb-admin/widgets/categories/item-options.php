<table class="table tables table-bordered " width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;" data-student="1">
    <thead>
        <tr role="row">
            <th>#</th>
            <th>Item</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody class="row-prepend-ajax">
        <?php
        if (!empty($items)) :
            foreach ($items as $p) : ?>
                <tr role="row" id="<?= $p->id; ?>">
                    <td><?= $p->id; ?></td>
                    <td><?= $p->options->item; ?></td>
                    <td>
                        <a href="#" data-option-item-id="<?= $p->id; ?>" title="Deletar Item" 
                        data-toggle="tooltip" class="btn btn-danger btn-circle btn-sm jsc-delete-item"
                         data-post="<?= url("/admin/options-items/delete/{$p->id}"); ?>" 
                         data-action="delete"
                          data-confirm="ATENÇÃO: Tem certeza que deseja excluir este item os dados relacionados a ela? Essa ação não pode ser feita!">
                            <i class="fas  fa-trash"></i>
                        </a>
                    </td>
                </tr>

        <?php
            endforeach;
        endif;; ?>

        <tr role="row" class="odd jsc-add-options" data-category-id="<?= $categoryId; ?>">
            <td>#</td>
            <td>Novo Item</td>
            <td>Clique para adicionar novo item</td>
        </tr>
    </tbody>
</table>