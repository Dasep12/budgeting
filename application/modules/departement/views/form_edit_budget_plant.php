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
            <h4 class="text-blue h4 mb-2">EDIT PLANT BUDGET</h4>
        </div>
    </div>
    <form id="regForm" method="post" action="<?= base_url('departement/Plant_budget/updatePlant') ?>">

        <div class="row">

            <div class="col-lg-4">
                <div class="form-group">
                    <label>JANUARI</label>
                    <input type="hidden" name="id_budget" value="<?= $id ?>">
                    <input type="hidden" value="<?= $plant[0]['nilai_budget'] ?>" name="bulan[]" id="januari_real">
                    <input id="januari" value="<?= 'Rp. ' . number_format($plant[0]['nilai_budget'], 0, ",", ".") ?>" class="form-control" name="input[]" type="text" placeholder="">
                </div>
                <div class="form-group">
                    <label>FEBRUARI</label>
                    <input type="hidden" value="<?= $plant[1]['nilai_budget'] ?>" name="bulan[]" id="februari_real">
                    <input id="februari" value="<?= 'Rp. ' . number_format($plant[1]['nilai_budget'], 0, ",", ".") ?>" class="form-control" name="input[]" type="text" placeholder="">
                </div>
                <div class="form-group">
                    <label>MARET</label>
                    <input type="hidden" value="<?= $plant[2]['nilai_budget'] ?>" name="bulan[]" id="maret_real">
                    <input id="maret" value="<?= 'Rp. ' . number_format($plant[2]['nilai_budget'], 0, ",", ".") ?>" class="form-control" name="input[]" type="text" placeholder="">
                </div>
                <div class="form-group">
                    <label>APRIL</label>
                    <input type="hidden" value="<?= $plant[3]['nilai_budget'] ?>" name="bulan[]" id="april_real">
                    <input id="april" value="<?= 'Rp. ' . number_format($plant[3]['nilai_budget'], 0, ",", ".") ?>" class="form-control" name="input[]" type="text" placeholder="">
                </div>
                <div class="form-group">
                    <label>MEI</label>
                    <input type="hidden" value="<?= $plant[4]['nilai_budget'] ?>" name="bulan[]" id="mei_real">
                    <input id="mei" value="<?= 'Rp. ' . number_format($plant[4]['nilai_budget'], 0, ",", ".") ?>" class="form-control" name="input[]" type="text" placeholder="">
                </div>
                <div class="form-group">
                    <label>JUNI</label>
                    <input type="hidden" value="<?= $plant[5]['nilai_budget'] ?>" name="bulan[]" id="juni_real">
                    <input id="juni" value="<?= 'Rp. ' . number_format($plant[5]['nilai_budget'], 0, ",", ".") ?>" class="form-control" name="input[]" type="text" placeholder="">
                </div>
            </div>
            <div class="col-lg-4">

                <div class="form-group">
                    <label>JULI</label>
                    <input type="hidden" value="<?= $plant[6]['nilai_budget'] ?>" name="bulan[]" id="juli_real">
                    <input id="juli" value="<?= 'Rp. ' . number_format($plant[6]['nilai_budget'], 0, ",", ".") ?>" class="form-control" name="input[]" type="text" placeholder="">
                </div>
                <div class="form-group">
                    <label>AGUSTUS</label>
                    <input type="hidden" value="<?= $plant[7]['nilai_budget'] ?>" name="bulan[]" id="agustus_real">
                    <input id="agustus" value="<?= 'Rp. ' . number_format($plant[7]['nilai_budget'], 0, ",", ".") ?>" class="form-control" name="input[]" type="text" placeholder="">
                </div>
                <div class="form-group">
                    <label>SEPTEMBER</label>
                    <input type="hidden" value="<?= $plant[8]['nilai_budget'] ?>" name="bulan[]" id="september_real">
                    <input id="september" value="<?= 'Rp. ' . number_format($plant[8]['nilai_budget'], 0, ",", ".") ?>" class="form-control" name="input[]" type="text" placeholder="">
                </div>
                <div class="form-group">
                    <label>OKTOBER</label>
                    <input type="hidden" value="<?= $plant[9]['nilai_budget'] ?>" name="bulan[]" id="oktober_real">
                    <input id="oktober" value="<?= 'Rp. ' . number_format($plant[9]['nilai_budget'], 0, ",", ".") ?>" class="form-control" name="input[]" type="text" placeholder="">
                </div>
                <div class="form-group">
                    <label>NOVEMBER</label>
                    <input type="hidden" value="<?= $plant[10]['nilai_budget'] ?>" name="bulan[]" id="november_real">
                    <input id="november" value="<?= 'Rp. ' . number_format($plant[10]['nilai_budget'], 0, ",", ".") ?>" class="form-control" name="input[]" type="text" placeholder="">
                </div>
                <div class="form-group">
                    <label>DESEMBER</label>
                    <input type="hidden" value="<?= $plant[11]['nilai_budget'] ?>" name="bulan[]" id="desember_real">
                    <input id="desember" value="<?= 'Rp. ' . number_format($plant[11]['nilai_budget'], 0, ",", ".") ?>" class="form-control" name="input[]" type="text" placeholder="">
                </div>

            </div>

            <div class="col-lg-4">
                <div class="form-group">
                    <label>TOTAL BUDGET</label>
                    <input required readonly id="budget_display" class="form-control" type="text" placeholder="">
                    <input id="budget" name="budget" class="form-control" type="hidden" placeholder="">
                </div>
                <div class="form-group">
                    <label>JENIS BUDGET</label>
                    <select id="jenis_budget" name="jenis_budget" class="form-control">
                        <option value="">Pilih Jenis Budget</option>
                        <?php foreach ($jenis as $jn) :
                            if ($plant[0]['jenis'] == $jn->id) { ?>
                                <option selected value="<?= $jn->id ?>"><?= $jn->jenis_budget ?></option>
                            <?php } else { ?>
                                <option value="<?= $jn->id ?>"><?= $jn->jenis_budget ?></option>
                        <?php  }
                        endforeach ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>ACTIVITY</label>
                    <textarea id="activity" name="activity" class="form-control" placeholder=""><?= $plant[0]['activity'] ?></textarea>
                </div>
                <div class="form-group">
                    <a href="<?= base_url('departement/Plant_budget/list_budget') ?>" class="btn btn-sm btn-success">Kembali</a>
                    <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
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