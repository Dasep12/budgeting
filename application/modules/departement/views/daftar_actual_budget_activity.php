<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.html">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        Actual Budget
                    </li>
                    <li class="breadcrumb-item active ">
                        Daftar Actual Activity Budget
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
                    <th>Departement</th>
                    <th>Tanggal</th>
                    <th>Kode Request</th>
                    <th>Jenis Transaksi</th>
                    <th>Remarks</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($daftar->result() as $df) : ?>
                    <tr>
                        <td><?= $df->nama_departement ?></td>
                        <td><?= $df->tanggal_request ?></td>
                        <td><?= $df->request_code ?></td>
                        <td><?= $df->jenis_transaksi ?></td>
                        <td><?= $df->remarks  ?></td>
                        <td>
                            <label for="" class="badge badge-primary"><?= $df->ket ?></label>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>