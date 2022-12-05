<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active ">
                        Tambah Budget
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
<div class="pd-20 card-box mb-30">
    <div class="clearfix">
        <div class="pull-left">
            <h4 class="text-blue h4 mb-2">REQUEST TAMBAH BUDGET</h4>
        </div>
    </div>

    <form enctype="multipart/form-data" action="<?= base_url('departement/TambahBudget/input') ?>" method="post" onsubmit="return cek()">
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label>TAHUN BUDGET</label>
                    <select class="form-control" name="tahun_budget" id="tahun_budget">
                        <option value="">Pilih Tahun</option>
                        <?php for ($i = 21; $i < 60; $i++) { ?>
                            <option><?= 20 . $i ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>JENIS BUDGET</label>
                    <select id="jenis_budget" name="jenis_budget" class="form-control">
                        <option value="">Pilih Jenis Budget</option>
                        <?php foreach ($jenis as $jn) : ?>
                            <option value="<?= $jn->id ?>"><?= $jn->jenis_budget ?></option>
                        <?php endforeach ?>
                    </select>
                    <div id="load_kode" style="display:none ;">
                        <span class="text-danger font-italic small">mengambil kode budget . . .</span>
                    </div>
                </div>
                <div class="form-group">
                    <label>KODE BUDGET</label>
                    <select name="kode_budget" id="kode_budget" class="form-control">
                        <option value="">Pilih Kode Budget</option>
                    </select>
                    <div id="load_budget_nilai" style="display:none ;">
                        <span class="text-danger font-italic small">mengambil nilai budget . . .</span>
                    </div>
                </div>



            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label>BULAN</label>
                    <select id="bulan_budget" name="bulan_budget" class="form-control">
                        <option value="">Pilih Bulan</option>
                        <option>JANUARI</option>
                        <option>FEBRUARI</option>
                        <option>MARET</option>
                        <option>APRIL</option>
                        <option>MEI</option>
                        <option>JUNI</option>
                        <option>JULI</option>
                        <option>AGUSTUS</option>
                        <option>SEPTEMBER</option>
                        <option>OKTOBER</option>
                        <option>NOVEMBER</option>
                        <option>DESEMBER</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>BUDGET TERSEDIA</label>
                    <input readonly class="form-control" id="budget" name="budget" type="text" placeholder="">
                </div>

                <div class="form-group">
                    <label>REQUEST NILAI BUDGET</label>
                    <input class="form-control" id="budget" name="budget" type="text" placeholder="">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-sm">Save</button>
                    <button type="reset" class="btn btn-danger btn-sm">Reset</button>
                </div>
            </div>
        </div>
    </form>
</div>


<!-- Modal -->
<div class="modal fade" id="empModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--  -->
<script>

</script>