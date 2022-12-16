<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="">Report</a>
                    </li>
                    <li class="breadcrumb-item active ">
                        Panjer
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="pd-20 card-box mb-30">
    <div class="clearfix">

    </div>

    <form action="<?= base_url('finance/Laporan/getPanjer') ?>" method="post" onsubmit="return cek()">
        <div class="row">

            <div class="col-lg-3">
                <div class="form-group">
                    <label>Jenis Transaksi</label>
                    <select id="jenis_trans" name="jenis_trans" class="form-control">
                        <option value="">Pilih Jenis Transaksi</option>
                        <?php foreach ($jenis->result() as $jns) : ?>
                            <option value="<?= $jns->id ?>"><?= $jns->jenis_budget ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label>Tahun</label>
                    <select name="tahun" id="tahun" class="form-control">
                        <?php for ($i = 22; $i <= 70; $i++) : ?>
                            <option><?= 20 . $i ?></option>
                        <?php endfor ?>
                    </select>
                </div>
            </div>
            <div class="col-lg-3 mt-4 ">
                <label for=""></label>
                <a id="filter" class="text-white btn btn-success mt-2">download</a>
            </div>
        </div>
    </form>
</div>