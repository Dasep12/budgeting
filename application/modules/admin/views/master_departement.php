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
                        Departement
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
                    <th>No</th>
                    <th>Departement</th>
                    <th>Kode Dept</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($data->result() as $dpt) : ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= strtoupper($dpt->nama_departement) ?></td>
                        <td><?= strtoupper($dpt->kode_departement) ?></td>
                        <td>
                            <a href="#" data-toggle="modal" data-target="#update-data" data-backdrop="static" data-keyboard="false" data-dept_code2="<?= strtoupper($dpt->kode_departement) ?>" data-dept_name2="<?= strtoupper($dpt->nama_departement) ?>" data-id="<?= $dpt->id ?>" class="badge badge-info"><i class="fa fa-edit"></i></a>

                            <a href="#" data-toggle="modal" data-target="#edit-data" data-backdrop="static" data-keyboard="false" class="badge badge-success" data-dept_code="<?= strtoupper($dpt->kode_departement) ?>" data-dept_name="<?= strtoupper($dpt->nama_departement) ?>"><i class="fa fa-eye"></i></a>

                            <a href="#" class="badge badge-danger"><i class="fa fa-close"></i></a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<!-- modal edit -->
<div class="modal fade" id="add-data" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Data</h5>
            </div>
            <form method="post" action="<?= base_url('admin/Departement/input') ?>">
                <div class="modal-body">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">NAMA DEPARTEMENT </label>
                            <input type="text" name="nama_departement" autocomplete="off" id="dept_name2" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">KODE DEPARTEMENT</label>
                            <input type="text" name="kode_departement" autocomplete="off" id="dept_code2" class="form-control">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary btn-sm">Simpan</button>
                    <button type="button" class="btn btn-sm btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- edit  -->

<!-- modal edit -->
<div class="modal fade" id="edit-data" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Data</h5>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <label for="">NAMA DEPARTEMENT </label>
                    <input type="text" readonly autocomplete="off" id="dept_name" class="form-control">
                    <label for="">KODE DEPARTEMENT</label>
                    <input type="text" readonly autocomplete="off" id="dept_code" class="form-control">
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- edit  -->


<!-- modal update -->
<div class="modal fade" id="update-data" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Data</h5>
            </div>
            <form method="post" action="<?= base_url('admin/Departement/edit') ?>">
                <div class="modal-body">
                    <div class="card-body">
                        <label for="">NAMA DEPARTEMENT </label>
                        <input type="hidden" name="id" id="id">
                        <input type="text" name="nama_departement_3" autocomplete="off" id="dept_name3" class="form-control">
                        <label for="">KODE DEPARTEMENT</label>
                        <input type="text" name="kode_departement_3" autocomplete="off" id="dept_code3" class="form-control">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary btn-sm">Simpan</button>
                    <button type="button" class="btn btn-sm btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- edit  -->

<script>
    $("#edit-data").on("show.bs.modal", function(event) {
        var div = $(event.relatedTarget); // Tombol dimana modal di tampilkan
        var modal = $(this);
        // Isi nilai pada field
        modal.find("#dept_name").attr("value", div.data("dept_name"));
        modal.find("#dept_code").attr("value", div.data("dept_code"));
    });

    $("#update-data").on("show.bs.modal", function(event) {
        var div = $(event.relatedTarget); // Tombol dimana modal di tampilkan
        var modal = $(this);
        // Isi nilai pada field
        modal.find("#dept_name3").attr("value", div.data("dept_name2"));
        modal.find("#dept_code3").attr("value", div.data("dept_code2"));
        modal.find("#id").attr("value", div.data("id"));
    });
</script>