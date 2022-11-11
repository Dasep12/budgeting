<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.html">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active ">
                        Approved
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
<div class="card-box mb-30">
    <div class="pd-20">
        <!-- <h4 class="text-blue h4">Data Table Simple</h4> -->
    </div>
    <div class="pb-20">

        <table class="data-table table stripe hover nowrap table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Budget</th>
                    <th>Departement</th>
                    <th>Tahun</th>
                    <th>Total Budget</th>
                    <th>Jenis Budget</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($daftar->result() as $df) : ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $df->kode_budget ?></td>
                        <td><?= $df->nama_departement ?></td>
                        <td><?= $df->tahun ?></td>
                        <td><?= 'Rp. ' . number_format($df->budget, 0, ",", ".")  ?></td>
                        <td><?= $df->jenis_budget ?></td>
                        <td>
                            <a href="#" class="badge badge-primary">Checked</a>
                            <a href="<?= base_url('manager/Approved/approve?id_budget=' . $df->id_budget . '&kode=1') ?>" onclick="return confirm('Yakin approve ?')" class="badge badge-success">Approved</a>
                            <a href="" class="badge badge-danger">Reject</a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>