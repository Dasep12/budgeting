<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.html">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active ">
                        Input Budget
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<?php if ($this->session->flashdata("fail")) { ?>
    <div class="alert alert-danger">
        <span><?= $this->session->flashdata("fail") ?></span>
    </div>
<?php } else if ($this->session->flashdata("ok")) { ?>
    <div class="alert alert-success">
        <span><?= $this->session->flashdata("ok") ?></span>
    </div>
<?php } ?>
<div class="pd-20 card-box mb-30">
    <div class="clearfix">
        <div class="pull-left">
            <h4 class="text-blue h4 mb-2">PLANT BUDGET</h4>
        </div>
    </div>

    <form method="post" action="<?= base_url('departement/Input_Budget/input') ?>">
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label>TAHUN BUDGET</label>
                    <input required class="form-control" id="tahun_budget" name="tahun_budget" type="text" placeholder="">
                </div>
                <div class="form-group">
                    <label>KODE BUDGET</label>
                    <input required class="form-control" id="kode_budget" name="kode_budget" type="text" placeholder="">
                </div>
                <div class="form-group">
                    <label>JENIS BUDGET</label>
                    <select id="jenis_budget" name="jenis_budget" class="form-control">
                        <option value="">Pilih Jenis Budget</option>
                        <?php foreach ($jenis as $jn) : ?>
                            <option value="<?= $jn->id ?>"><?= $jn->jenis_budget ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>KPI</label>
                    <input id="kpi" name="kpi" class="form-control" type="text" placeholder="">
                </div>
                <div class="form-group">
                    <label>TARGET KPI</label>
                    <input id="target_kpi" name="target_kpi" class="form-control" type="text" placeholder="">
                </div>
                <div class="form-group">
                    <label>PIC</label>
                    <input id="pic" name="pic" class="form-control" type="text" placeholder="">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label>IMPROVEMENT</label>
                    <textarea id="improvement" name="improvement" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label>ACCOUNT BAME</label>
                    <input id="account_bame" name="account_bame" class="form-control" placeholder="">
                </div>
                <div class="form-group">
                    <label>DESCRIPTION</label>
                    <input id="description" name="description" class="form-control" placeholder="">
                </div>

                <div class="form-group">
                    <label>BUDGET</label>
                    <input required id="budget_display" class="form-control" type="text" placeholder="">
                    <input id="budget" name="budget" class="form-control" type="hidden" placeholder="">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-sm">Save</button>
                    <button type="reset" class="btn btn-danger btn-sm">Reset</button>
                </div>
            </div>
        </div>


    </form>

</div>

<script>
    $('select[name=jenis_budget').on('change', function() {
        var jenis_budget = $("select[name=jenis_budget] option:selected").text();
        console.log(jenis_budget);
        if (jenis_budget == 'Reguler Cost' || jenis_budget == 'reguler cost') {
            $("#pic").prop("disabled", true);
            $("#kpi").prop("disabled", true);
            $("#target_kpi").prop("disabled", true);
            $("#improvement").prop("disabled", true);
            $("#account_bame").prop("disabled", false);
            $("#description").prop("disabled", false);
        } else if (jenis_budget == 'Perspective Cost' || jenis_budget == 'perspective cost') {
            $("#account_bame").prop("disabled", true);
            $("#description").prop("disabled", true);
        } else {
            $("#pic").prop("disabled", false);
            $("#kpi").prop("disabled", false);
            $("#target_kpi").prop("disabled", false);
            $("#improvement").prop("disabled", false);
            $("#account_bame").prop("disabled", false);
            $("#description").prop("disabled", false);
        }
    })

    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }

    function convert(bulan, bulan2) {
        var parsing = document.getElementById(bulan);
        parsing.addEventListener('keyup', function(e) {
            // tambahkan 'Rp.' pada saat form di ketik
            // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
            parsing.value = formatRupiah(this.value, 'Rp. ');
            const convert_1 = this.value.replace(/[^\w\s]/gi, '');
            const convert_2 = convert_1.replace('Rp', '');
            document.getElementById(bulan2).value = convert_2;
        });
    }
    convert("budget_display", "budget");
</script>