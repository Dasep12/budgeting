<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">E-Budget</a>
                    </li>
                    <li class="breadcrumb-item active ">
                        Approved Tambah Budget
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<?php if ($this->session->flashdata("ok")) { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Berhasil !</strong> <?= $this->session->flashdata("ok") ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php $this->session->unset_userdata("ok") ?>
<?php } else if ($this->session->flashdata("nok")) { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Gagal !</strong> <?= $this->session->flashdata("nok") ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php $this->session->unset_userdata("nok") ?>
<?php } ?>

<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="home-tab" data-toggle="tab" data-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">MENUNGGU </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="profile-tab" data-toggle="tab" data-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">SUDAH TERPROSES</button>
    </li>
</ul>

<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <div class="card-box mb-30">
            <div class="pd-20">
                <!-- <h4 class="text-blue h4">Data Table Simple</h4> -->
            </div>
            <div class="pb-20">
                <table class="data-table table stripe hover nowrap table-bordered">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Bulan Budget</th>
                            <th>Budget Sisa</th>
                            <th>Penambahan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($menunggu->result() as $mg) : ?>
                            <tr>
                                <td><?= $mg->tanggal ?></td>
                                <td><?= $mg->bulan . ' ' . $mg->tahun ?></td>
                                <td><?= 'Rp. ' . number_format($mg->budget_sebelumnya, 0, ",", ".") ?></td>
                                <td><?= 'Rp. ' . number_format($mg->budget_request, 0, ",", ".") ?></td>
                                <td><a href="<?= base_url('finance/ApproveRequestTambah/approve?id=' . $mg->id . '&kode=1'  . '&plant_id=' . $mg->id_plant . '&budget_id=' . $mg->id_budget . '&n=' . $mg->budget_request) ?>" onclick="return confirm('Yakin approve ?')" class="badge badge-success">Approved</a>
                                    <a onclick="return confirm('Yakin reject ?')" href="<?= base_url('finance/ApproveRequestTambah/approve?id=' . $mg->id . '&kode=2') ?>" class="badge badge-danger">Reject</a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="tab-pane fade show" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <div class="card-box mb-30">
            <div class="pd-20">
                <!-- <h4 class="text-blue h4">Data Table Simple</h4> -->
            </div>
            <div class="pb-20">
                <table class="data-table table stripe hover nowrap table-bordered">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Bulan Budget</th>
                            <th>Budget Sisa</th>
                            <th>Penambahan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($selesai->result() as $mg) : ?>
                            <tr>
                                <td><?= $mg->tanggal ?></td>
                                <td><?= $mg->bulan . ' ' . $mg->tahun ?></td>
                                <td><?= 'Rp. ' . number_format($mg->budget_sebelumnya, 0, ",", ".") ?></td>
                                <td><?= 'Rp. ' . number_format($mg->budget_request, 0, ",", ".") ?></td>
                                <td><?= $mg->ket ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>