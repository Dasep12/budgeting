<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.html">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        Plant Budget
                    </li>
                    <li class="breadcrumb-item active ">
                        Daftar Plant Activity Budget
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
                    <th class="table-plus datatable-nosort">Kode Budget</th>
                    <th>Departement</th>
                    <th>Tahun Budget</th>
                    <th>Bulan</th>
                    <th>Budget</th>
                    <th>Activity</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($plant->result() as $pl) : ?>
                    <tr>
                        <td><?= $pl->kode_budget ?></td>
                        <td><?= $pl->nama_departement ?></td>
                        <td><?= $pl->tahun ?></td>
                        <td><?= $pl->bulan ?></td>
                        <td><?= 'Rp. ' . number_format($pl->nilai_budget, 0, ",", ".") ?></td>
                        <td><?= $pl->activity ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>