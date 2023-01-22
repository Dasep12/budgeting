<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">Master</a>
                    </li>
                    <li class="breadcrumb-item ">
                        <a href="<?= base_url("admin/Pengguna/") ?>">User</a>
                    </li>
                    <li class="breadcrumb-item active ">
                        Tambah User
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
        <div class="card-body">

            <form action="<?= base_url('Admin/Pengguna/add') ?>" method="post">
                <div class="row md-2">

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">Nama Lengkap</label>
                            <input type="text" required autocomplete="off" class="form-control" name="nama_lengkap" id="nama_lengkap">
                        </div>
                        <div class="form-group">
                            <label for="">Nik</label>
                            <input type="text" class="form-control" required autocomplete="off" name="nik" id="nik">
                        </div>
                        <div class="form-group">
                            <label for="">Username</label>
                            <input type="text" class="form-control" required autocomplete="off" name="username" id="username">
                        </div>
                        <div class="form-group">
                            <label for="">Password</label>
                            <input type="password" required autocomplete="off" class="form-control" name="password" id="password">
                        </div>


                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">JENIS PEMBAYARAN</label>
                            <select class="form-control" required name="jenis_pembayaran" id="jenis_pembayaran">
                                <option value="">PILIH JENIS PEMBAYARAN</option>
                                <?php foreach ($jenis_bayar as $jn) : ?>
                                    <option value="<?= $jn->id ?>"><?= $jn->jenis_bayar ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Level</label>
                            <select name="level" required id="level" class="form-control">
                                <option value="">Pilih Level</option>
                                <?php foreach ($level->result() as $lv) : ?>
                                    <option value="<?= $lv->id ?>"><?= $lv->level ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Departement</label>
                            <select name="departement[]" required id="departement" class="form-control js-select2" multiple="multiple" style="height: 40px;">
                                <?php foreach ($departement->result() as $lv) : ?>
                                    <option value="<?= $lv->id ?>"><?= $lv->nama_departement     ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <button type="reset" class="btn btn-danger btn-sm">Reset</button>
                        <button type="submit" class="btn btn-primary btn-sm">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>



<script>
    $("#edit-data").on("show.bs.modal", function(event) {
        var div = $(event.relatedTarget); // Tombol dimana modal di tampilkan
        var modal = $(this);
        // Isi nilai pada field
        modal.find("#jenis_budget").attr("value", div.data("jenis_budget"));
    });

    $(".js-select2").select2({
        closeOnSelect: false,
        placeholder: "Placeholder",
        allowHtml: true,
        allowClear: true,
        tags: true // создает новые опции на лету
    });
</script>