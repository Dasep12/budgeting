<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.html">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        Plant Budget
                    </li>
                    <li class="breadcrumb-item active ">
                        Input Plant Activity Budget
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
            <h4 class="text-blue h4 mb-2">PLANT BUDGET</h4>
        </div>
    </div>
    <form method="post" action="<?= base_url('departement/Plant_budget/input') ?>" onsubmit="return cek()">
        <div class="row">
            <div class="col-lg-4">
                <div class="form-group">
                    <label>TAHUN BUDGET</label>
                    <select id="tahun_budget" name="tahun_budget" class="form-control">
                        <option value="">Pilih Tahun Budget</option>
                        <option>2022</option>
                        <option>2023</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>JENIS BUDGET</label>
                    <input type="hidden" name="id_budget" id="id_budget">
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
                    <select class="form-control" name="kode_budget" id="kode_budget">
                        <option>Pilih Kode Budget</option>
                    </select>
                    <div id="load_budget_nilai" style="display:none ;">
                        <span class="text-danger font-italic small">mengambil nilai budget . . .</span>
                    </div>

                </div>
                <div class="form-group">
                    <label>BUDGET</label>
                    <input type="hidden" name="budget_real" id="budget_real">
                    <input readonly class="form-control" id="budget" name="budget" type="text" placeholder="">
                </div>

                <div class="form-group">
                    <label>ACTIVITY</label>
                    <textarea id="activity" name="activity" class="form-control" placeholder=""></textarea>
                </div>

            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label>JANUARI</label>
                    <input type="hidden" name="bulan[]" id="januari_real">
                    <input required id="januari" class="form-control" type="text" placeholder="">
                </div>
                <div class="form-group">
                    <label>FEBRUARI</label>
                    <input type="hidden" name="bulan[]" id="februari_real">
                    <input required id="februari" class="form-control" type="text" placeholder="">
                </div>
                <div class="form-group">
                    <label>MARET</label>
                    <input type="hidden" name="bulan[]" id="maret_real">
                    <input required id="maret" class="form-control" type="text" placeholder="">
                </div>
                <div class="form-group">
                    <label>APRIL</label>
                    <input type="hidden" name="bulan[]" id="april_real">
                    <input required id="april" class="form-control" type="text" placeholder="">
                </div>
                <div class="form-group">
                    <label>MEI</label>
                    <input type="hidden" name="bulan[]" id="mei_real">
                    <input required id="mei" class="form-control" type="text" placeholder="">
                </div>
                <div class="form-group">
                    <label>JUNI</label>
                    <input required type="hidden" name="bulan[]" id="juni_real">
                    <input required id="juni" class="form-control" type="text" placeholder="">
                </div>
            </div>
            <div class="col-lg-4">

                <div class="form-group">
                    <label>JULI</label>
                    <input type="hidden" name="bulan[]" id="juli_real">
                    <input required id="juli" class="form-control" type="text" placeholder="">
                </div>
                <div class="form-group">
                    <label>AGUSTUS</label>
                    <input type="hidden" name="bulan[]" id="agustus_real">
                    <input required id="agustus" class="form-control" type="text" placeholder="">
                </div>
                <div class="form-group">
                    <label>SEPTEMBER</label>
                    <input type="hidden" name="bulan[]" id="september_real">
                    <input required id="september" class="form-control" type="text" placeholder="">
                </div>
                <div class="form-group">
                    <label>OKTOBER</label>
                    <input type="hidden" name="bulan[]" id="oktober_real">
                    <input required id="oktober" class="form-control" type="text" placeholder="">
                </div>
                <div class="form-group">
                    <label>NOVEMBER</label>
                    <input type="hidden" name="bulan[]" id="november_real">
                    <input required id="november" class="form-control" type="text" placeholder="">
                </div>
                <div class="form-group">
                    <label>DESEMBER</label>
                    <input type="hidden" name="bulan[]" id="desember_real">
                    <input required id="desember" class="form-control" type="text" placeholder="">
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
    $('select[name=jenis_budget').on('change', function() {
        var jenis = $("select[name=jenis_budget] option:selected").val();
        var tahun = $("select[name=tahun_budget] option:selected").val();
        $.ajax({
            url: "<?= base_url('departement/Plant_budget/getKodeBudget') ?>",
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
        var jenis = $("select[name=kode_budget] option:selected").val();
        $.ajax({
            url: "<?= base_url('departement/Plant_budget/getSisaBudget') ?>",
            method: "GET",
            data: "kode_budget=" + jenis,
            cache: false,
            beforeSend: function() {
                document.getElementById("load_budget_nilai").style.display = 'block';

            },
            complete: function() {
                document.getElementById("load_budget_nilai").style.display = 'none';
            },
            success: function(e) {
                if (e == 0) {
                    alert('tidak ada budget');
                    document.getElementById("budget").value = "";
                    document.getElementById("id_budget").value = "";
                    document.getElementById("budget_real").value = "";
                } else {
                    var data = JSON.parse(e)
                    document.getElementById("id_budget").value = data.id_budget;
                    document.getElementById("budget").value = formatRupiah(data.budget, "Rp. ");
                    document.getElementById("budget_real").value = data.budget;
                }
            }
        })
    });


    $('select[name=tahun_budget').on('change', function() {
        $('#jenis_budget').prop('selectedIndex', 0);
    })


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

    function cek_bandingan() {
        const januari = document.getElementById("januari_real").value;
        const februari = document.getElementById("februari_real").value;
        const maret = document.getElementById("maret_real").value;
        const april = document.getElementById("april_real").value;
        const mei = document.getElementById("mei_real").value;
        const juni = document.getElementById("juni_real").value;
        const juli = document.getElementById("juli_real").value;
        const agustus = document.getElementById("agustus_real").value;
        const september = document.getElementById("september_real").value;
        const oktober = document.getElementById("oktober_real").value;
        const november = document.getElementById("november_real").value;
        const desember = document.getElementById("desember_real").value;
        const total = parseInt(januari) + parseInt(februari) + parseInt(maret) + parseInt(april) + parseInt(mei) + parseInt(juni) + parseInt(juli) + parseInt(agustus) + parseInt(september) + parseInt(oktober) + parseInt(november) + parseInt(desember);
        return total;
    }


    function cek() {
        var budget_tahunan = document.getElementById("budget_real").value;
        var budget_bulan = cek_bandingan();
        if (parseInt(budget_bulan) > parseInt(budget_tahunan)) {
            alert("Planing budget melebihi kapasitas yang ada");
            return false;
        }
        return;
    }
</script>