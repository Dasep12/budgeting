<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.html">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        Master
                    </li>
                    <li class="breadcrumb-item active ">
                        Jenis Budget
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

<a href="<?= base_url('Admin/Pengguna/form_add_user') ?>" class="btn btn-primary btn-sm mb-2"><i class="fa fa-plus"></i> Tambah Data</a>
<div class="card-box mb-30">
    <div class="pd-20">
        <!-- <h4 class="text-blue h4">Data Table Simple</h4> -->
    </div>
    <div class="pb-20">
        <table class="data-table table hover nowrap">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Departement</th>
                    <th>Level</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($dataUser->result() as $dpt) : ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= strtoupper($dpt->nama_lengkap) ?></td>
                        <td><?php
                            if ($dpt->dept == 'DEPT HEAD' || $dpt->dept == 'dept head' || $dpt->dept == 'DEPT HEAD 2' || $dpt->dept == 'dept head 2') {
                                $depar = $this->db->query("SELECT md.nama_departement  FROM master_bawahan_depthead mh inner join master_departement md on md.id = mh.master_departement_id WHERE mh.master_akun_nik='" . $dpt->nik . "' ")->result();
                                foreach ($depar as $drp) {
                                    echo "<li>" . $drp->nama_departement . '</li>';
                                }
                            } else {
                                echo strtoupper($dpt->nama_departement);
                            }
                            ?>
                        </td>
                        <td><?= strtoupper($dpt->level) ?></td>
                        <td>
                            <a href="<?= base_url('Admin/Pengguna/form_edit_user/' . $dpt->nik) ?>" class="badge badge-info"><i class="fa fa-edit"></i></a>

                            <a href="#" data-toggle="modal" data-target="#edit-data" data-backdrop="static" data-keyboard="false" class="badge badge-success" data-id="<?= strtoupper($dpt->nik) ?>"><i class="fa fa-lock"></i></a>

                            <a onclick="return confirm('Yakin Hapus Data ?')" href="<?= base_url('Admin/Pengguna/delete?id=' . $dpt->nik) ?>" class="badge badge-danger"><i class="fa fa-close"></i></a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>


<!-- modal edit data plant -->
<div class="modal fade" id="edit-data" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Data</h5>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> -->
            </div>
            <div class="modal-body">
                <form action="<?= base_url("Admin/Pengguna/resetPassword") ?>" method="post">
                    <div class="card-body">
                        <label for="">NEW PASSWORD</label>
                        <input type="hidden" name="id" id="id">
                        <input required type="password" class="form-control" id="password" name="password">
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-sm btn-success btn-sm">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- edit data plant -->

<script>
    $("#edit-data").on("show.bs.modal", function(event) {
        var div = $(event.relatedTarget); // Tombol dimana modal di tampilkan
        var modal = $(this);
        // Isi nilai pada field
        modal.find("#id").attr("value", div.data("id"));
    });
</script>