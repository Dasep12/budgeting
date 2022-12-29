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
                        Jenis Account
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
                    <th>Acc No</th>
                    <th>Acc Name</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($data->result() as $dpt) : ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $dpt->acc_no ?></td>
                        <td><?= strtoupper($dpt->acc_name)  ?></td>
                        <td><?= strtoupper($dpt->ket)  ?></td>
                        <td>

                            <a href="#" data-toggle="modal" data-target="#edit-data" data-backdrop="static" data-id="<?= $dpt->id ?>" data-keyboard="false" class="badge badge-success" data-acc_no="<?= strtoupper($dpt->acc_no) ?>" data-acc_name="<?= strtoupper($dpt->acc_name) ?>" data-ket="<?= strtoupper($dpt->ket) ?>"><i class="fa fa-eye"></i></a>

                            <a href="<?= base_url('Admin/AccountName/delete?id=' . $dpt->id) ?>" onclick="return confirm('Yakin Hapus ?')" class="badge badge-danger"><i class="fa fa-close"></i></a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>


<!-- modal add  -->
<div class="modal fade" id="add-data" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Data</h5>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> -->
            </div>
            <form method="post" action="<?= base_url('Admin/AccountName/input') ?>">
                <div class="modal-body">
                    <div class="card-body">
                        <label for="">ACC NO</label>
                        <input type="text" autocomplete="off" name="acc_no" id="acc_no" class="form-control">

                        <label for="">ACC NAME</label>
                        <input type="text" autocomplete="off" name="acc_name" id="acc_name" class="form-control">

                        <label for="">KETERANGAN</label>
                        <textarea name="keterangan" id="keterangan" class="form-control"></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
                    <button class="btn btn-sm btn-primary btn-sm">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- add-->

<!-- modal edit  -->
<div class="modal fade" id="edit-data" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Data</h5>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> -->
            </div>
            <form method="post" action="<?= base_url('Admin/AccountName/update') ?>">
                <div class="modal-body">
                    <div class="card-body">
                        <label for="">ACC NAME</label>
                        <input type="hidden" name="id" id="id">
                        <input type="text" autocomplete="off" name="acc_no_2" id="acc_no_2" class="form-control">

                        <label for="">ACC NAME</label>
                        <input type="text" autocomplete="off" name="acc_name_2" id="acc_name_2" class="form-control">

                        <label for="">KETERANGAN</label>
                        <textarea name="keterangan_2" id="keterangan_2" class="form-control"></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
                    <button class="btn btn-sm btn-primary btn-sm">Update</button>
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
        modal.find("#id").attr("value", div.data("id"));
        modal.find("#acc_no_2").attr("value", div.data("acc_no"));
        modal.find("#acc_name_2").attr("value", div.data("acc_name"));
        document.getElementById("keterangan_2").value = div.data("ket");
    });
</script>