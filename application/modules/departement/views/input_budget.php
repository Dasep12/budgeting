<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">Plant Budget</a>
                    </li>
                    <li class="breadcrumb-item active ">
                        Input Plant Budget
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<?php if ($this->session->flashdata("fail")) { ?>
    <div class="alert alert-danger">
        <span><?= $this->session->flashdata("fail") ?></span>
        <?= $this->session->unset_userdata('fail') ?>
    </div>
<?php } else if ($this->session->flashdata("ok")) { ?>
    <div class="alert alert-success">
        <span><?= $this->session->flashdata("ok") ?></span>
        <?= $this->session->unset_userdata('ok') ?>
    </div>
<?php } ?>
<div class="pd-20 card-box mb-30">
    <div class="clearfix">
        <div class="pull-left">
            <h4 class="text-blue h4 mb-2">PLANT BUDGET</h4>
        </div>
    </div>
    <form id="regForm" method="post" action="<?= base_url('departement/Input_Budget/input') ?>">
        <!-- One "tab" for each step in the form: -->
        <div class="tab">
            <!-- budget -->
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
                        <label>KODE BUDGET</label>
                        <input required value="<?= $code_dept ?>" class="form-control" id="kode_budget" name="kode_budget" type="text" placeholder="">
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
                        <label>SUB JENIS BUDGET</label>
                        <select id="sub_jenis_budget" name="sub_jenis_budget" class="form-control">
                            <option value="">Pilih Sub Jenis Budget</option>
                            <?php foreach ($sub_jenis as $jn) : ?>
                                <option value="<?= $jn->id ?>"><?= $jn->sub_jenis_budget ?></option>
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
                        <label>DUE DATE</label>
                        <input type="date" id="due_date" value="<?= date('Y-m-d') ?>" name="due_date" class="form-control" placeholder="">
                    </div>
                    <div class="form-group">
                        <label>IMPROVMENT</label>
                        <textarea id="improvement" name="improvement" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label>ACCOUNT NAME</label>
                        <input id="account_bame" name="account_bame" class="form-control" placeholder="">
                    </div>
                    <div class="form-group">
                        <label>DESCRIPTION</label>
                        <input id="description" name="description" class="form-control" placeholder="">
                    </div>

                    <div class="form-group">
                        <div class="form-group">
                            <label>ACTIVITY</label>
                            <textarea id="activity" name="activity" class="form-control" placeholder=""></textarea>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="tab">
            <div class="row">

                <div class="col-lg-4">
                    <div class="form-group">
                        <label>JANUARI</label>
                        <input type="hidden" value="0" name="bulan[]" id="januari_real">
                        <input id="januari" value="Rp. 0" class="form-control" name="input[]" type="text" placeholder="">
                    </div>
                    <div class="form-group">
                        <label>FEBRUARI</label>
                        <input type="hidden" value="0" name="bulan[]" id="februari_real">
                        <input id="februari" value="Rp. 0" class="form-control" name="input[]" type="text" placeholder="">
                    </div>
                    <div class="form-group">
                        <label>MARET</label>
                        <input type="hidden" value="0" name="bulan[]" id="maret_real">
                        <input id="maret" value="Rp. 0" class="form-control" name="input[]" type="text" placeholder="">
                    </div>
                    <div class="form-group">
                        <label>APRIL</label>
                        <input type="hidden" value="0" name="bulan[]" id="april_real">
                        <input id="april" value="Rp. 0" class="form-control" name="input[]" type="text" placeholder="">
                    </div>
                    <div class="form-group">
                        <label>MEI</label>
                        <input type="hidden" value="0" name="bulan[]" id="mei_real">
                        <input id="mei" value="Rp. 0" class="form-control" name="input[]" type="text" placeholder="">
                    </div>
                    <div class="form-group">
                        <label>JUNI</label>
                        <input type="hidden" value="0" name="bulan[]" id="juni_real">
                        <input id="juni" value="Rp. 0" class="form-control" name="input[]" type="text" placeholder="">
                    </div>
                </div>
                <div class="col-lg-4">

                    <div class="form-group">
                        <label>JULI</label>
                        <input type="hidden" value="0" name="bulan[]" id="juli_real">
                        <input id="juli" value="Rp. 0" class="form-control" name="input[]" type="text" placeholder="">
                    </div>
                    <div class="form-group">
                        <label>AGUSTUS</label>
                        <input type="hidden" value="0" name="bulan[]" id="agustus_real">
                        <input id="agustus" value="Rp. 0" class="form-control" name="input[]" type="text" placeholder="">
                    </div>
                    <div class="form-group">
                        <label>SEPTEMBER</label>
                        <input type="hidden" value="0" name="bulan[]" id="september_real">
                        <input id="september" value="Rp. 0" class="form-control" name="input[]" type="text" placeholder="">
                    </div>
                    <div class="form-group">
                        <label>OKTOBER</label>
                        <input type="hidden" value="0" name="bulan[]" id="oktober_real">
                        <input id="oktober" value="Rp. 0" class="form-control" name="input[]" type="text" placeholder="">
                    </div>
                    <div class="form-group">
                        <label>NOVEMBER</label>
                        <input type="hidden" value="0" name="bulan[]" id="november_real">
                        <input id="november" value="Rp. 0" class="form-control" name="input[]" type="text" placeholder="">
                    </div>
                    <div class="form-group">
                        <label>DESEMBER</label>
                        <input type="hidden" value="0" name="bulan[]" id="desember_real">
                        <input id="desember" value="Rp. 0" class="form-control" name="input[]" type="text" placeholder="">
                    </div>

                </div>

                <div class="col-lg-4">
                    <label>TOTAL BUDGET</label>
                    <input required readonly id="budget_display" class="form-control" type="text" placeholder="">
                    <input id="budget" name="budget" class="form-control" type="hidden" placeholder="">
                </div>
            </div>
        </div>


        <div style="overflow:auto;">
            <div style="float:right;">
                <button type="button" class="btn btn-sm btn-success" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                <button type="button" class="btn btn-sm btn-primary" id="nextBtn" onclick="nextPrev(1)">Next</button>
            </div>
        </div>

        <!-- Circles which indicates the steps of the form: -->
        <div style="text-align:center;margin-top:40px;">
            <span class="step"></span>
            <span class="step"></span>
        </div>

</div>
</div>

</div>

<script>
    $('select[name=jenis_budget').on('change', function() {
        var jenis_budget = $("select[name=jenis_budget] option:selected").text();
        console.log(jenis_budget);
        if (jenis_budget == 'REGULER' || jenis_budget == 'reguler') {
            $("#pic").prop("disabled", true);
            $("#kpi").prop("disabled", true);
            $("#target_kpi").prop("disabled", true);
            $("#improvement").prop("disabled", true);
            $("#due_date").prop("disabled", true);
            $("#account_bame").prop("disabled", false);
            $("#description").prop("disabled", false);
            $("#sub_jenis_budget").prop("disabled", true);
        } else if (jenis_budget == 'PERSPECTIVE' || jenis_budget == 'perspective') {
            $("#account_bame").prop("disabled", true);
            $("#description").prop("disabled", true);
            $("#pic").prop("disabled", false);
            $("#kpi").prop("disabled", false);
            $("#target_kpi").prop("disabled", false);
            $("#improvement").prop("disabled", false);
            $("#due_date").prop("disabled", false);
            $("#sub_jenis_budget").prop("disabled", false);
        } else {
            $("#pic").prop("disabled", false);
            $("#kpi").prop("disabled", false);
            $("#due_date").prop("disabled", false);
            $("#sub_jenis_budget").prop("disabled", false);
            $("#target_kpi").prop("disabled", false);
            $("#improvement").prop("disabled", false);
            $("#account_bame").prop("disabled", false);
            $("#description").prop("disabled", false);
        }
    })

    function counting() {
        var jan = document.getElementById("januari_real").value;
        var feb = document.getElementById("februari_real").value;
        var mar = document.getElementById("maret_real").value;
        var apr = document.getElementById("april_real").value;
        var mei = document.getElementById("mei_real").value;
        var jun = document.getElementById("juni_real").value;
        var jul = document.getElementById("juli_real").value;
        var agu = document.getElementById("agustus_real").value;
        var sep = document.getElementById("september_real").value;
        var okt = document.getElementById("oktober_real").value;
        var nov = document.getElementById("november_real").value;
        var des = document.getElementById("desember_real").value;
        let total = parseInt(jan) + parseInt(feb) + parseInt(mar) +
            parseInt(apr) + parseInt(mei) + parseInt(jun) + parseInt(jul) + parseInt(agu) +
            parseInt(sep) + parseInt(okt) + parseInt(nov) + parseInt(des);
        document.getElementById("budget").value = total;
        document.getElementById("budget_display").value = formatRupiah(total.toString(), 'Rp.');
    }

    counting();

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
            const convert_2 = convert_1.replace('Rp ', '');
            document.getElementById(bulan2).value = convert_2;
            
            // total budget 
            var jan = document.getElementById("januari_real").value;
            var feb = document.getElementById("februari_real").value;
            var mar = document.getElementById("maret_real").value;
            var apr = document.getElementById("april_real").value;
            var mei = document.getElementById("mei_real").value;
            var jun = document.getElementById("juni_real").value;
            var jul = document.getElementById("juli_real").value;
            var agu = document.getElementById("agustus_real").value;
            var sep = document.getElementById("september_real").value;
            var okt = document.getElementById("oktober_real").value;
            var nov = document.getElementById("november_real").value;
            var des = document.getElementById("desember_real").value;
            let total = parseInt(jan) + parseInt(feb) + parseInt(mar) +
                parseInt(apr) + parseInt(mei) + parseInt(jun) + parseInt(jul) + parseInt(agu) +
                parseInt(sep) + parseInt(okt) + parseInt(nov) + parseInt(des);
            document.getElementById("budget").value = total;
            document.getElementById("budget_display").value = formatRupiah(total.toString(), 'Rp.');

        });
    }
    convert("budget_display", "budget");
    convert("januari", "januari_real");
    convert("februari", "februari_real");
    convert("maret", "maret_real");
    convert("april", "april_real");
    convert("mei", "mei_real");
    convert("juni", "juni_real");
    convert("juli", "juli_real");
    convert("agustus", "agustus_real");
    convert("september", "september_real");
    convert("oktober", "oktober_real");
    convert("november", "november_real");
    convert("desember", "desember_real");
</script>