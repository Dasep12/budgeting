<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.html">Transactiond</a>
                    </li>
                    <li class="breadcrumb-item">
                        Retur Panjar
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
                    <!-- <th>Tanggal</th> -->
                    <th class="table-sm small table-plus datatable-nosort">Kode Budget</th>
                    <th>Nilai Transaksi</th>
                    <th>Nilai Retur</th>
                    <!-- <th>Status</th> -->
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($retur->result() as $pl) : ?>
                    <tr>
                        <td><?= $pl->request_code ?></td>
                        <td><?= 'Rp. ' . number_format($pl->nilai_awal, 0, ",", ".")  ?></td>
                        <td><?= 'Rp. ' . number_format($pl->nilai_retur, 0, ",", ".")   ?></td>
                        <!-- <td><?= $pl->status_retur == 1 ? '<span class="bg-success d-block text-center text-white">CLOSE</span>' : '<span class="bg-danger d-block text-center text-white">OPEN</span>' ?></td> -->
                        <td><?= ucwords($pl->keterangan) ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>