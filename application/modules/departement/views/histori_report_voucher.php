<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">Transaksi Ap Voucher</a>
                    </li>
                    <li class="breadcrumb-item">
                        Lapor Voucher
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="card-box mb-30">
    <div class="pd-20">
        <!-- <h4 class="text-blue h4">Data Table Simple</h4> -->
    </div>
    <div class="pb-20">
        <table class="data-table table hover nowrap">
            <thead>
                <tr>
                    <th class="table-sm small table-plus datatable-nosort">Kode Plant</th>
                    <th>Particullar</th>
                    <th>Voucher Plant</th>
                    <th>Voucher Actual</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($retur->result() as $pl) : ?>
                    <tr>
                        <td><?= $pl->request_code ?></td>
                        <td>
                            <?php
                            $parti = $this->model->ambilData("transaksi_detail_voucher", ['transaksi_plant_voucher_id' => $pl->id])->result();
                            foreach ($parti as $pr) {
                                echo "<li>" . $pr->particullar . "</li>";
                            }
                            ?>
                        </td>
                        <td><?= 'Rp. ' . number_format($pl->plant_sebelumnya, 0, ",", ".")  ?></td>
                        <td><?= 'Rp. ' . number_format($pl->total_voucher, 0, ",", ".")  ?></td>

                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>