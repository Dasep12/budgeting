<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.html">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        Actual Budget
                    </li>
                    <li class="breadcrumb-item active ">
                        Input Actual Activity Budget
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
            <h4 class="text-blue h4 mb-2">ACTUAL BUDGET</h4>
        </div>
    </div>

    <form action="<?= base_url('departement/Actual_budget/input') ?>" method="post" onsubmit="return cek()">
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label>TAHUN BUDGET</label>
                    <input type="hidden" id="id_planning_budget" name="id_planning">
                    <select id="tahun_budget" name="tahun_budget" class="form-control">
                        <option>2022</option>
                        <option>2023</option>
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
                </div>
                <div class="form-group">
                    <label>KODE BUDGET</label>
                    <input readonly class="form-control" id="kode_budget" name="kode_budget" type="text" placeholder="">
                </div>
                <div class="form-group">
                    <label>BUDGET</label>
                    <input type="hidden" name="budget_real" id="budget_real">
                    <input readonly class="form-control" id="budget" name="budget" type="text" placeholder="">
                </div>


            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label>BULAN</label>
                    <select id="bulan_budget" name="bulan_budget" class="form-control">
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
                    <label>PENGGUNAAN BUDGET</label>
                    <input id="use_budget_real" name="use_budget" type="hidden" placeholder="">
                    <input class="form-control" id="use_budget" type="text" placeholder="">
                </div>

                <div class="form-group">
                    <label>ACTIVITY</label>
                    <textarea id="activity" name="activity" class="form-control" placeholder=""></textarea>
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

    $('select[name=bulan_budget').on('change', function() {
        $('#jenis_budget').prop('selectedIndex', 0);
    })

    $('select[name=jenis_budget').on('change', function() {
        var jenis = $("select[name=jenis_budget] option:selected").val();
        var tahun = $("select[name=tahun_budget] option:selected").val();
        var bulan = $("select[name=bulan_budget] option:selected").val();
        $.ajax({
            url: "<?= base_url('departement/Actual_budget/getBudget') ?>",
            method: "GET",
            data: "tahun=" + tahun + "&jenis=" + jenis + "&bulan=" + bulan,
            cache: false,
            success: function(e) {
                if (e == 0 || e === '0') {
                    alert('err');
                } else {
                    const data = JSON.parse(e);
                    var budget = formatRupiah(data.budget_actual, 'Rp. ');
                    document.getElementById("budget").value = budget;
                    document.getElementById("budget_real").value = data.budget_actual;
                    document.getElementById("kode_budget").value = data.kode_budget;
                    document.getElementById("id_planning_budget").value = data.id_planing;
                }
            }
        })
    });

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
    convert("use_budget", "use_budget_real");

    function cek() {
        var budget_plant = document.getElementById("budget_real").value;
        var budget_input = document.getElementById("use_budget_real").value;

        if (parseInt(budget_input) > parseInt(budget_plant)) {
            alert("budget melebih kapasitas");
            return false;
        }
        return;
    }
</script>