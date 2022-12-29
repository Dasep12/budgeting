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
                        Sub Jenis Budget
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
                    <th>Sub Jenis Budget</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($data->result() as $dpt) : ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= strtoupper($dpt->sub_jenis_budget) ?></td>
                        <td>
                            <a href="#" data-toggle="modal" data-target="#edit-data" data-backdrop="static" data-id="<?= $dpt->id ?>" data-keyboard="false" class="badge badge-success" data-sub_jenis_budget="<?= strtoupper($dpt->sub_jenis_budget) ?>"><i class="fa fa-eye"></i></a>

                            <a href="<?= base_url('Admin/SubJenisBudget/delete?id=' . $dpt->id) ?>" onclick="return confirm('Yakin Hapus ?')" class="badge badge-danger"><i class="fa fa-close"></i></a>
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
            <form method="post" action="<?= base_url('Admin/SubJenisBudget/input') ?>">
                <div class="modal-body">
                    <div class="card-body">
                        <label for="">SUB JENIS BUDGET</label>
                        <input type="text" autocomplete="off" name="jenis_budget2" id="jenis_budget2" class="form-control">
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
            <form method="post" action="<?= base_url('Admin/SubJenisBudget/update') ?>">
                <div class="modal-body">

                    <div class="card-body">
                        <label for="">JENIS BUDGET</label>
                        <input type="hidden" id="id" name="id">
                        <input type="text" autocomplete="off " name="sub_jenis_budget" id="sub_jenis_budget" class="form-control">
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
<!-- edit data plant -->

<script>
    $("#edit-data").on("show.bs.modal", function(event) {
        var div = $(event.relatedTarget); // Tombol dimana modal di tampilkan
        var modal = $(this);
        // Isi nilai pada field
        modal.find("#sub_jenis_budget").attr("value", div.data("sub_jenis_budget"));
        modal.find("#id").attr("value", div.data("id"));
    });
</script>