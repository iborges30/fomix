<table class="table tables table-bordered " width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;" data-student="1">
    <thead>
        <tr role="row">
            <th>#</th>
            <th>Item</th>
            <th>Valor</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody class="row-prepend-ajax">
        <?php
        if (!empty($items)) :
            foreach ($items as $p) : ?>
                <tr role="row" id="<?= $p->id; ?>">
                    <td><?= $p->id; ?></td>
                    <td><?= $p->additional->additional; ?></td>
                    <td><?= str_price($p->additional->price); ?></td>
                    <td>
                        <a href="#" data-additional-item-id="<?= $p->id; ?>" title="Deletar item" 
                        data-toggle="tooltip" class="btn btn-danger btn-circle btn-sm jsc-delete-additional"
                         data-post="<?= url("/admin/additional-items/delete/{$p->id}"); ?>" 
                         data-action="delete"
                          data-confirm="ATENÇÃO: Tem certeza que deseja excluir este item os dados relacionados a ela? Essa ação não pode ser feita!">
                            <i class="fas  fa-trash"></i>
                        </a>
                    </td>
                </tr>

        <?php
            endforeach;
        endif;; ?>

        <tr role="row" class="odd jsc-add-additional" data-category-id="<?= $categoryId; ?>">
            <td>#</td>
            <td>Novo item</td>
            <td>Valor</td>
            <td>Clique para adicionar um novo item</td>
        </tr>
    </tbody>
</table>