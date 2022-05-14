<?php $v->layout("_admin"); ?>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-credit-card"></i>
            Histórico de faturas
        </h1>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col-md-4">
                    <p><b>Nome:</b><?= $profile->fullName(); ?></p>
                </div>

                <div class="col-md-4">
                    <p><b>Chave Pix:</b> <?= $profile->key_pix; ?></p>
                </div>

                <div class="col-md-4 text-right">
                    <a href="<?= url("/admin/deliveries/wallet/$profile->id");?>"
                       class="btn btn-warning">
                        Voltar
                    </a>
                </div>


            </div>
        </div>
        <?php if ($invoices) : ?>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Empresa</th>
                                        <th>data</th>
                                        <th>valor</th>
                                        <th>status</th>
                                    </tr>
                                    </thead>
                                    <?php
                                    if ($invoices) :
                                        foreach ($invoices as $p) :
                                            ?>
                                            <tr role="row">
                                                <td><?= $p->id; ?></td>
                                                <td><?= $p->enterprises->enterprise; ?></td>
                                                <td><?= date_fmt_br($p->created); ?></td>
                                                <td>R$ <?= str_price($p->price); ?></td>
                                                <td>
                                                    <span class="badge <?= setBgstatusPayment($p->status); ?> "><?= balanceStatusDelivery($p->status); ?></span>
                                                </td>
                                            </tr>
                                        <?php
                                        endforeach;
                                    endif;
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: echo alert_info("Não há nenhum repasse a ser feito no momento");
        endif;
        ?>
    </div>
</div>

<?php $v->start("scripts"); ?>
<script>
    $(function () {
        $(".jsc-payment-delivery").click(function () {
            var id = $(this).attr("id");
            var r = confirm("Você deseja marcar estas faturas como pagas ?");
            if (r == true) {
                $.ajax({
                    url: '<?= url("/admin/deliveries/payment/delivery");?>',
                    data: {id: id},
                    dataType: 'json',
                    method: 'post',
                    success: function (response) {
                        if (response.success) {
                            location.reload();
                        }
                    }
                });
            }
            return false;
        });
    });
</script>
<?php $v->end("scripts"); ?>
