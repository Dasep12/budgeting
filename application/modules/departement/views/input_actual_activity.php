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
                        <option value="">Pilih Tahun</option>
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
                <div class="form-group">
                    <label>BUDGET</label>
                    <input type="text" name="budget_real" id="budget_real">
                    <input readonly class="form-control" id="budget" name="budget" type="text" placeholder="">
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
                    <label>ACTIVITY</label>
                    <select name="tipe_trans" class="form-control" id="tipe_trans">
                        <option value="">Pilih Activity</option>
                        <option value="01">RAIMBUSMENT</option>
                        <option value="02">PAYMENT VOUCHER</option>
                        <option value="03">PATTY CASH</option>
                    </select>
                    <div id="load_code_request" style="display:none ;">
                        <span class="text-danger font-italic small">mengambil kode request. . .</span>
                    </div>
                </div>

                <div class="form-group">
                    <label>KODE REQUEST</label>
                    <select name="code_request" class="form-control" id="code_request">
                        <option value="">Pilih Code Request</option>
                    </select>
                    <div id="load_nil" style="display:none ;">
                        <span class="text-danger font-italic small">mengambil nilai. . .</span>
                    </div>
                    <input type="text" placeholder="id raimbusment" name="id_raimbus" id="id_raimbus">
                    <input type="text" placeholder="total raimbusment" name="n_raimbus" id="n_raimbus">
                </div>

                <div class="form-group">
                    <label>NILAI</label>
                    <input readonly class="form-control" id="nilai_raimbusment" name="nilai_raimbusment" type="text" placeholder="">
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
        $.ajax({
            url: "<?= base_url('departement/Actual_budget/getKodeBudget') ?>",
            method: "GET",
            data: "tahun=" + tahun + "&jenis=" + jenis,
            cache: false,
            beforeSend: function() {
                document.getElementById("load_kode").style.display = 'block';
            },
            complete: function() {
                document.getElementById("load_kode").style.display = 'none';
            },
            success: function(e) {
                var select1 = $('#kode_budget');
                select1.empty();
                var added2 = document.createElement('option');
                added2.value = "";
                added2.innerHTML = "Pilih Kode Budget";
                select1.append(added2);
                var result = JSON.parse(e);
                for (var i = 0; i < result.length; i++) {
                    var added = document.createElement('option');
                    added.value = result[i].kode_budget;
                    added.innerHTML = result[i].kode_budget;
                    select1.append(added);
                }
            }
        })
    });

    $('select[name=kode_budget').on('change', function() {
        var kode = $("select[name=kode_budget] option:selected").val();
        var tahun = $("select[name=tahun_budget] option:selected").val();
        var bulan = $("select[name=bulan_budget] option:selected").val();
        $.ajax({
            url: "<?= base_url('departement/Actual_budget/getBudget') ?>",
            method: "GET",
            data: "tahun=" + tahun + "&kode=" + kode + "&bulan=" + bulan,
            cache: false,
            beforeSend: function() {
                document.getElementById("load_budget_nilai").style.display = 'block';
            },
            complete: function() {
                document.getElementById("load_budget_nilai").style.display = 'none';
            },
            success: function(e) {
                // console.log(e)
                if (e == 0 || e === '0') {
                    alert('err');
                } else {
                    const data = JSON.parse(e);
                    var budget = formatRupiah(data.budget_actual, 'Rp. ');
                    document.getElementById("budget_real").value = budget;
                    document.getElementById("budget").value = budget;
                }
            }
        })
    });

    $('select[name=tipe_trans').on('change', function() {
        var type = $("select[name=tipe_trans] option:selected").val();
        $.ajax({
            url: "<?= base_url('departement/Actual_budget/getCodeRequest') ?>",
            method: "GET",
            data: "type=" + type,
            cache: false,
            beforeSend: function() {
                document.getElementById("load_code_request").style.display = 'block';
            },
            complete: function() {
                document.getElementById("load_code_request").style.display = 'none';
            },
            success: function(e) {
                var select1 = $('#code_request');
                select1.empty();
                var added2 = document.createElement('option');
                added2.value = "";
                added2.innerHTML = "Pilih Kode Request";
                select1.append(added2);
                var result = JSON.parse(e);
                for (var i = 0; i < result.length; i++) {
                    var added = document.createElement('option');
                    added.value = result[i].request_code;
                    added.innerHTML = result[i].request_code;
                    select1.append(added);
                }
            }
        })
    });

    $('select[name=code_request').on('change', function() {
        var code = $("select[name=code_request] option:selected").val();
        $.ajax({
            url: "<?= base_url('departement/Actual_budget/getNilaiTransaksi') ?>",
            method: "GET",
            data: "code=" + code,
            cache: false,
            beforeSend: function() {
                document.getElementById("load_nil").style.display = 'block';
            },
            complete: function() {
                document.getElementById("load_nil").style.display = 'none';
            },
            success: function(e) {
                const data = JSON.parse(e);
                document.getElementById("id_raimbus").value = data.id;
                document.getElementById("n_raimbus").value = data.total;
                document.getElementById("nilai_raimbusment").value = formatRupiah(data.total, "Rp. ");
            }
        })
    });

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