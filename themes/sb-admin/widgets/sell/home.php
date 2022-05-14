<?php $v->layout("_admin"); ?>
<div class="container-fluid">
    <!-- Page Heading -->

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <form action="https://rolapapo.com.br/csw/admin/sell/home" class="d-none d-sm-inline-block ml-auto ml-md-12 my-2 my-md-0 mw-100">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="first_name" class="required">Informe uma data</label>
                    <input type="date" name="s" id="start_date" placeholder="informe uma data" class="form-control" required="" value="06/03/2021">
                </div>
                <div class="form-group col-md-3">
                    <button class="btn btn-info btn-icon-split" style="margin-top:30px; margin-right: 10px;">
                        <span class="icon text-white-50">
                            <i class="fas fa-check"></i>
                        </span>
                        <span class="text">Pesquisar</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

            <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Minhas vendas em: 06/03/2021</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Data</th>
                            <th>Número de Pedidos</th>
                            <th>Total de itens vendidos</th>
                            <th>Total</th>

                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Data</th>
                            <th>Número de Pedidos</th>
                            <th>Total de itens vendidos</th>
                            <th>Total</th>
                        </tr>
                        </tfoot>

                        <tbody>
                        <tr>
                            <td>06/03/2021</td>
                            <td>69</td>
                                                        <td>140</td>


                                                        <td>R$ 4.816,00</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--paginator-->
    
</div>