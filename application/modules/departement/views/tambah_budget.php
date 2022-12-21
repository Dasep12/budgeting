<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">Plant Budget</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('departement/TambahBudget') ?>">List Request Tambah Budget </a>
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
                    <input required type="hidden" name="id_planning_budget" id="id_planning_budget">
                    <select class="form-control" name="tahun_budget" id="tahun_budget">
                        <option value="">Pilih Tahun</option>
                        <?php for ($i = 21; $i < 70; $i++) { ?>
                            <option><?= 20 . $i ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>JENIS BUDGET</label>
                    <select required id="jenis_budget" name="jenis_budget" class="form-control">
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
                    <select required name="kode_budget" id="kode_budget" class="form-control">
                        <option value="">Pilih Kode Budget</option>
                    </select>
                    <div id="load_budget_nilai" style="display:none ;">
                        <span class="text-danger font-italic small">mengambil nilai budget . . .</span>
                    </div>
                </div>

                <div class="form-group">
                    <label>KEPERLUAN</label>
                    <textarea name="keperluan" class="form-control" id="keperluan"></textarea>
                </div>



            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label>BULAN</label>
                    <select required id="bulan_budget" name="bulan_budget" class="form-control">
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
                    <div id="load_budget_nilai" style="display:none ;">
                        <span class="text-danger font-italic small">mengambil nilai budget . . .</span>
                    </div>
                </div>

                <div class="form-group">
                    <label>BUDGET TERSEDIA</label>
                    <input readonly class="form-control" required id="budget" type="text" placeholder="">
                    <input id="budget_real" name="budget" type="hidden" placeholder="">
                </div>

                <div class="form-group">
                    <label>REQUEST NILAI BUDGET</label>
                    <input required class="form-control" id="budget_request" type="text" placeholder="">
                    <input class="form-control" id="budget_request_real" name="budget_request" type="hidden" placeholder="">
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
        var jenis = $("select[name=jenis_budget] option:selected").val();
        var tahun = $("select[name=tahun_budget] option:selected").val();

        if (tahun == null || tahun == "") {
            alert("Pilih tahun terlebih dahulu");
            $('#jenis_budget').prop('selectedIndex', 0);
        } else {
            $.ajax({
                url: "<?= base_url('departement/TambahBudget/getKodeBudget') ?>",
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
        }
    });


    $('select[name=bulan_budget').on('change', function() {
        var kode = $("select[name=kode_budget] option:selected").val();
        var tahun = $("select[name=tahun_budget] option:selected").val();
        var bulan = document.getElementById("bulan_budget").value;

        if (kode == null || tahun == "") {
            alert("Pilih Kode Budget Dahulu");
            $('#bulan_budget').prop('selectedIndex', 0);
        } else {

            $.ajax({
                url: "<?= base_url('departement/TambahBudget/getBudget') ?>",
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
                        alert('budget belum selesai di approve');
                    } else {
                        const data = JSON.parse(e);
                        console.log(e);
                        var budget = formatRupiah(data.budget_actual, 'Rp. ');
                        document.getElementById("budget_real").value = data.budget_actual;
                        document.getElementById("budget").value = budget;
                        document.getElementById("id_planning_budget").value = data.id_planing;
                    }
                }
            })
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

    var parsing = document.getElementById("budget_request");
    parsing.addEventListener('keyup', function(e) {
        // tambahkan 'Rp.' pada saat form di ketik
        // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
        parsing.value = formatRupiah(this.value, 'Rp. ');
        const convert_1 = this.value.replace(/[^\w\s]/gi, '');
        const convert_2 = convert_1.replace('Rp', '');
        document.getElementById("budget_request_real").value = convert_2;
    });
</script>