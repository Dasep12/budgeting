<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.html">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active ">
                        Daftar Budget
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
        <table class="data-table table stripe hover nowrap">
            <thead>
                <tr>
                    <th class="table-plus datatable-nosort">Kode Budget</th>
                    <th>Departement</th>
                    <th>Tahun Budget</th>
                    <th>Jenis</th>
                    <th>Budget</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($budget as $bd) : ?>
                    <tr>
                        <td class="table-plus"><?= $bd->kode_budget ?></td>
                        <td><?= $bd->departement ?></td>
                        <td><?= $bd->tahun ?></td>
                        <td><?= $bd->jenis_budget ?></td>
                        <td><?= 'Rp. ' . number_format($bd->budget, 0, ",", ".")  ?></td>
                        <td>
                            <?php if ($bd->status == 0) { ?>
                                <span class="badge badge-danger">menunggu approved</span>
                            <?php } else if ($bd->status == 1) { ?>
                                <span class="badge badge-success">approved manager</span>
                            <?php } else if ($bd->status == 2) { ?>
                                <span class="badge badge-success">approved finance</span>
                            <?php } else if ($bd->status == 3) { ?>
                                <span class="badge badge-success">approved accounting</span>
                            <?php } else if ($bd->status == 4) { ?>
                                <span class="badge badge-success">approved gm</span>
                            <?php } else if ($bd->status == 6) { ?>
                                <span class="badge badge-danger"><?= $bd->ket ?></span>
                            <?php } ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>