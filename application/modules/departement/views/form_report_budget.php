<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="">Report</a>
                    </li>
                    <li class="breadcrumb-item active ">
                        Plant Budget
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="pd-20 card-box mb-30">
    <div class="clearfix">

    </div>

    <form target="_blank" id="form" action="#" method="post">
        <div class="row">

            <div class="col-lg-3">
                <div class="form-group">
                    <label>Departement</label>
                    <select required id="departement" name="departement" class="form-control">
                        <option value="">Pilih Departement</option>
                        <?php foreach ($departement->result() as $dpt) : ?>
                            <option value="<?= $dpt->id ?>"><?= $dpt->nama_departement ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="form-group">
                    <label>Jenis Transaksi</label>
                    <select required id="jenis_trans" name="jenis_trans" class="form-control">
                        <option value="">Pilih Jenis Transaksi</option>
                        <?php foreach ($jenis->result() as $jns) : ?>
                            <option value="<?= $jns->id ?>"><?= $jns->jenis_budget ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label>Tipe</label>
                    <select required name="tipe" id="tipe" class="form-control">
                        <option value="0">Tahunan</option>
                        <option value="1">Bulanan</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label>Tahun</label>
                    <select required name="tahun" id="tahun" class="form-control">
                        <?php for ($i = 22; $i <= 70; $i++) : ?>
                            <option><?= 20 . $i ?></option>
                        <?php endfor ?>
                    </select>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label>Jenis</label>
                    <select required name="jenis" id="jenis" class="form-control">
                        <option value="0">Excel</option>
                        <option value="1">Pdf</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-3">
                <label for=""></label>
                <button id="filter" type="button" class="text-white btn btn-success">download</button>
            </div>
        </div>
    </form>
</div>

<script>
    $(function() {
        $("#filter").on('click', function(e) {
            // e.preventDefault();
            var tipe = $("#tipe").val(); // 1 bulanan 0 tahunan
            var jenis = $("#jenis").val(); // 1 PDF 0 EXCEL 
            var trans = $("#jenis_trans").val();
            var depart = $("#departement").val();

            if (depart == "" || trans == "") {
                alert("isi parameter");
            } else {
                if (tipe == 1 || tipe == "1") {
                    $("#form").attr("action", "<?= base_url('departement/ReportBudget/planBulananPDF?transaksi=') ?>" + $("select[name=jenis_trans] option:selected").text());
                    $("#form").submit();
                } else {
                    $("#form").attr("action", "<?= base_url('departement/ReportBudget/planTahunanPDF') ?>");
                    $("#form").submit();
                }
            }

        })
    })
</script>