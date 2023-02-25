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
<a href="" data-toggle="modal" data-target="#add-data" data-backdrop="static" data-keyboard="false" class="btn btn-primary btn-sm mb-2"><i class="fa fa-plus"></i> Tambah Data</a>
<div class="card-box mb-30">
    <div class="pd-20">
        <!-- <h4 class="text-blue h4">Data Table Simple</h4> -->
    </div>
    <div class="pb-20">
        <table class="data-table table hover nowrap">
            <thead>
                <tr>
                    <th>Nik</th>
                    <th>Nama</th>
                    <th>Level</th>
                    <th>Jenis</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($ttd->result() as $dpt) : ?>
                    <tr>
                        <td><?= $dpt->nik ?></td>
                        <td><?= strtoupper($dpt->nama_lengkap) ?></td>
                        <td><?= $dpt->level ?></td>
                        <td><?= $dpt->tipe == 1 ? 'PATTY CASH' : 'CASH BANK' ?></td>
                        <td>
                            <a href="" data-nik="<?= $dpt->nik ?>" data-id="<?= $dpt->id ?>" data-nama="<?= $dpt->nama_lengkap ?>" data-departement="<?= $dpt->level ?>" data-toggle="modal" data-target="#edit-data" data-backdrop="static" data-keyboard="false" class="badge badge-success"><i class="fa fa-eye"></i></a>

                            <a href="<?= base_url('Admin/Tertanda/delete?id=' . $dpt->id) ?>" onclick="return confirm('Yakin Hapus ?')" class="badge badge-danger"><i class="fa fa-close"></i></a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<!-- modal add -->
<div class="modal fade" id="add-data" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
            </div>
            <form method="post" enctype="multipart/form-data" action="<?= base_url('admin/Tertanda/input') ?>">
                <div class="modal-body">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">NAMA USER</label>
                            <select class="form-control" name="user" id="user">
                                <?php foreach ($akun->result() as $us) : ?>
                                    <option value="<?= $us->nik ?>"><?= strtoupper($us->nama_lengkap . ' - ' . $us->level) ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">FILE TTD</label>
                            <input type="file" name="lampiran" id="lampiran" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">JENIS PEMBAYARAN</label>
                            <select class="form-control" required name="jenis_pembayaran" id="jenis_pembayaran">
                                <option value="">PILIH JENIS PEMBAYARAN</option>
                                <option value="1">CASH BANK</option>
                                <option value="2">PETTY CASH</option>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-sm btn-primary btn-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- add  -->


<!-- modal add -->
<div class="modal fade" id="edit-data" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
            </div>
            <form method="post" enctype="multipart/form-data" action="<?= base_url('admin/Tertanda/update') ?>">
                <div class="modal-body">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">NAMA USER</label>
                            <input type="hidden" id="nik_2" name="nik_2">
                            <input type="hidden" id="id_2" name="id_2">
                            <input type="text" readonly class="form-control" id="nama_user_1">
                        </div>
                        <div class="form-group">
                            <label for="">LEVEL</label>
                            <input type="text" readonly class="form-control" id="dept_1">
                        </div>

                        <div class="form-group">
                            <label for="">FILE TTD</label>
                            <input type="file" required name="lampiran_1" id="lampiran" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="">JENIS PEMBAYARAN</label>
                            <select class="form-control" required name="jenis_pembayaran2" id="jenis_pembayaran">
                                <option value="">PILIH JENIS PEMBAYARAN</option>
                                <option value="1">CASH BANK</option>
                                <option value="2">PETTY CASH</option>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-sm btn-primary btn-sm">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- add  -->

<script>
    $("#edit-data").on("show.bs.modal", function(event) {
        var div = $(event.relatedTarget); // Tombol dimana modal di tampilkan
        var modal = $(this);
        // Isi nilai pada field
        modal.find("#nik_2").attr("value", div.data("nik"));
        modal.find("#id_2").attr("value", div.data("id"));
        modal.find("#nama_user_1").attr("value", div.data("nama"));
        modal.find("#dept_1").attr("value", div.data("departement"));
    });
</script>