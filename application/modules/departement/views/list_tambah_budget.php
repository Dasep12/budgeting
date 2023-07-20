<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        Plant Budget
                    </li>
                    <li class="breadcrumb-item active ">
                        <a href="">List Request Tambah Budget </a>
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
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Gagal !</strong> <?= $this->session->flashdata("nok") ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php $this->session->unset_userdata("nok") ?>
<?php } ?>

<a href="<?= base_url('departement/TambahBudget/form_request') ?>" class="btn btn-success btn-sm mb-2"><span class="micon bi bi-plus"></span> Tambah Request Budget</a>

<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="home-tab2" data-toggle="tab" data-target="#home2" type="button" role="tab" aria-controls="home2" aria-selected="true">Approval Supervisor</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link " id="home-tab" data-toggle="tab" data-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Approval Dept Head</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="profile-tab" data-toggle="tab" data-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Approval Budget Controller</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="contact-tab" data-toggle="tab" data-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Approval General Manager</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="contact-tab2" data-toggle="tab" data-target="#contact2" type="button" role="tab" aria-controls="contact" aria-selected="false">Approval Finance</button>
    </li>
</ul>

<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="home2" role="tabpanel" aria-labelledby="home-tab2">
        <div class="card-box mb-30" style="margin-top:-1px">
            <div class="pd-20">
                <!-- <h4 class="text-blue h4">Data Table Simple</h4> -->
            </div>
            <div class="pb-20">
                <table class="data-table table hover nowrap">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Bulan Budget</th>
                            <th>Budget Sisa</th>
                            <th>Penambahan</th>
                            <th>Keterangan</th>
                            <th>Lampiran</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($approve_spv->result() as $mg) : ?>
                            <tr>
                                <td><?= $mg->tanggal ?></td>
                                <td><?= $mg->bulan . ' ' . $mg->tahun ?></td>
                                <td><?= 'Rp. ' . number_format($mg->budget_sebelumnya, 0, ",", ".") ?></td>
                                <td><?= 'Rp. ' . number_format($mg->budget_request, 0, ",", ".") ?></td>
                                <td><?= $mg->keperluan ?></td>
                                <td>
                                    <a href="<?= base_url('assets/lampiran/' . $mg->lampiran_1) ?>" target="_blank">
                                        <i class="fa fa-file"></i>
                                    </a>
                                    <a href="<?= base_url('assets/lampiran/' . $mg->lampiran_2) ?>" target="_blank">
                                        <i class="fa fa-file"></i>
                                    </a>
                                </td>
                                <td><?= $mg->ket ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="tab-pane fade " id="home" role="tabpanel" aria-labelledby="home-tab">
        <div class="card-box mb-30" style="margin-top:-1px">
            <div class="pd-20">
                <!-- <h4 class="text-blue h4">Data Table Simple</h4> -->
            </div>
            <div class="pb-20">
                <table class="data-table table hover nowrap">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Bulan Budget</th>
                            <th>Budget Sisa</th>
                            <th>Penambahan</th>
                            <th>Keterangan</th>
                            <th>Lampiran</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($approve_mgr->result() as $mg) : ?>
                            <tr>
                                <td><?= $mg->tanggal ?></td>
                                <td><?= $mg->bulan . ' ' . $mg->tahun ?></td>
                                <td><?= 'Rp. ' . number_format($mg->budget_sebelumnya, 0, ",", ".") ?></td>
                                <td><?= 'Rp. ' . number_format($mg->budget_request, 0, ",", ".") ?></td>
                                <td><?= $mg->keperluan ?></td>
                                <td>
                                    <a href="<?= base_url('assets/lampiran/' . $mg->lampiran_1) ?>" target="_blank">
                                        <i class="fa fa-file"></i>
                                    </a>
                                    <a href="<?= base_url('assets/lampiran/' . $mg->lampiran_2) ?>" target="_blank">
                                        <i class="fa fa-file"></i>
                                    </a>
                                </td>
                                <td><?= $mg->ket ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="tab-pane fade show" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <div class="card-box mb-30" style="margin-top:-1px">
            <div class="pd-20">
                <!-- <h4 class="text-blue h4">Data Table Simple</h4> -->
            </div>
            <div class="pb-20">
                <table class="data-table table hover nowrap">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Bulan Budget</th>
                            <th>Budget Sisa</th>
                            <th>Penambahan</th>
                            <th>Keterangan</th>
                            <th>Lampiran</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($approve_bc->result() as $mg) : ?>
                            <tr>
                                <td><?= $mg->tanggal ?></td>
                                <td><?= $mg->bulan . ' ' . $mg->tahun ?></td>
                                <td><?= 'Rp. ' . number_format($mg->budget_sebelumnya, 0, ",", ".") ?></td>
                                <td><?= 'Rp. ' . number_format($mg->budget_request, 0, ",", ".") ?></td>
                                <td><?= $mg->keperluan ?></td>
                                <td>
                                    <a href="<?= base_url('assets/lampiran/' . $mg->lampiran_1) ?>" target="_blank">
                                        <i class="fa fa-file"></i>
                                    </a>
                                    <a href="<?= base_url('assets/lampiran/' . $mg->lampiran_2) ?>" target="_blank">
                                        <i class="fa fa-file"></i>
                                    </a>
                                </td>
                                <td><?= $mg->ket ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="tab-pane fade show" id="contact" role="tabpanel" aria-labelledby="contact-tab">
        <div class="card-box mb-30" style="margin-top:-1px">
            <div class="pd-20">
                <!-- <h4 class="text-blue h4">Data Table Simple</h4> -->
            </div>
            <div class="pb-20">
                <table class="data-table table hover nowrap">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Bulan Budget</th>
                            <th>Budget Sisa</th>
                            <th>Penambahan</th>
                            <th>Keterangan</th>
                            <th>Lampiran</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($approve_gm->result() as $mg) : ?>
                            <tr>
                                <td><?= $mg->tanggal ?></td>
                                <td><?= $mg->bulan . ' ' . $mg->tahun ?></td>
                                <td><?= 'Rp. ' . number_format($mg->budget_sebelumnya, 0, ",", ".") ?></td>
                                <td><?= 'Rp. ' . number_format($mg->budget_request, 0, ",", ".") ?></td>
                                <td><?= $mg->keperluan ?></td>
                                <td>
                                    <a href="<?= base_url('assets/lampiran/' . $mg->lampiran_1) ?>" target="_blank">
                                        <i class="fa fa-file"></i>
                                    </a>
                                    <a href="<?= base_url('assets/lampiran/' . $mg->lampiran_2) ?>" target="_blank">
                                        <i class="fa fa-file"></i>
                                    </a>
                                </td>
                                <td><?= $mg->ket ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="tab-pane fade show" id="contact2" role="tabpanel" aria-labelledby="contact-tab2">
        <div class="card-box mb-30" style="margin-top:-1px">
            <div class="pd-20">
                <!-- <h4 class="text-blue h4">Data Table Simple</h4> -->
            </div>
            <div class="pb-20">
                <table class="data-table table hover nowrap">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Bulan Budget</th>
                            <th>Budget Sisa</th>
                            <th>Penambahan</th>
                            <th>Keterangan</th>
                            <th>Lampiran</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($approve_fin->result() as $mg) : ?>
                            <tr>
                                <td><?= $mg->tanggal ?></td>
                                <td><?= $mg->bulan . ' ' . $mg->tahun ?></td>
                                <td><?= 'Rp. ' . number_format($mg->budget_sebelumnya, 0, ",", ".") ?></td>
                                <td><?= 'Rp. ' . number_format($mg->budget_request, 0, ",", ".") ?></td>
                                <td><?= $mg->keperluan ?></td>
                                <td>
                                    <a href="<?= base_url('assets/lampiran/' . $mg->lampiran_1) ?>" target="_blank">
                                        <i class="fa fa-file"></i>
                                    </a>
                                    <a href="<?= base_url('assets/lampiran/' . $mg->lampiran_2) ?>" target="_blank">
                                        <i class="fa fa-file"></i>
                                    </a>
                                </td>
                                <td><?= $mg->ket ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>