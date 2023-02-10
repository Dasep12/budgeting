<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        Transaksi Ap Voucer
                    </li>
                    <li class="breadcrumb-item active ">
                        Input Plant
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
            <h4 class="text-blue h4 mb-2">PLANT AP VOUCHER</h4>
        </div>
    </div>

    <form id="regForm" enctype="multipart/form-data" action="<?= base_url('departement/InputVoucher/input') ?>" method="post" onsubmit="return cek()">
        <div class="tab">
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

                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>BULAN</label>
                        <!-- <input type="text" readonly value="<?= $bulan ?>" class="form-control" name="bulan_budget" id="bulan_budget"> -->
                        <select name="bulan_budget" id="bulan_budget" class="form-control">
                            <option value="">Pilih Bulan</option>
                            <option>Januari</option>
                            <option>Februari</option>
                            <option>Maret</option>
                            <option>April</option>
                            <option>Mei</option>
                            <option>Juni</option>
                            <option>Juli</option>
                            <option>Agustus</option>
                            <option>September</option>
                            <option>Oktober</option>
                            <option>November</option>
                            <option>Desember</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>BUDGET TERSEDIA</label>
                        <input type="hidden" name="budget_real" id="budget_real">
                        <input readonly class="form-control" id="budget" name="budget" type="text" placeholder="">
                    </div>

                    <div class="form-group">
                        <label for="">AKUN</label>
                        <select id="acc" name="acc" class="form-control">
                            <option value="">Pilih Jenis Akun</option>
                            <?php foreach ($acc as $jn) : ?>
                                <option value="<?= $jn->id ?>"><?= $jn->acc_no . ' - ' . $jn->acc_name ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                </div>
            </div>
        </div>

        <div class="tab">
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>KODE TRANSAKSI</label>
                        <input readonly class="form-control" value="<?= $code_dept ?>" id="request_code" name="request_code" type="text" placeholder="">
                    </div>

                    <div class="form-group">
                        <label>TO</label>
                        <input class="form-control" id="to" name="toPenerima" type="text" placeholder="">
                    </div>

                    <div class="form-group">
                        <label>REKENING</label>
                        <input class="form-control" id="rekening" name="rekening" type="text" placeholder="">
                    </div>
                    <div class="form-group">
                        <label>PARTICULLARS</label>
                        <a href="" class="add_field_button badge badge-success badge-sm">Tambah</a>
                        <input class="form-control" id="particullar" name="particullar[]" type="text" placeholder="">
                    </div>
                    <div class="form-group input_fields_wrap">

                    </div>

                    <div class="form-group">
                        <label>REMARKS</label>
                        <textarea id="remarks" name="remarks" class="form-control" placeholder=""></textarea>
                    </div>



                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>TANGGAL REQUEST</label>
                        <input class="form-control" id="tanggal" name="tanggal" type="text" placeholder="">
                    </div>

                    <div class="form-group">
                        <label for="">JENIS TRANSAKSI</label>
                        <select class="form-control" name="jenis_transaksi" id="jenis_transaksi">
                            <option selected value="<?= $transaksi->id ?>"><?= $transaksi->jenis_transaksi ?></option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>NO BK</label>
                        <input type="text" readonly value="<?= $bk ?>" class="form-control" name="bk" id="bk">
                    </div>
                    <div class="form-group">
                        <label>AMMOUNT</label>
                        <input class="form-control input_am" autocomplete="off" onkeyup="convertNilai()" id="ammount" name="ammount[]" type="text" placeholder="">
                    </div>
                    <div class="add_ammount">

                    </div>
                    <div class="form-group">
                        <label>BANK</label>
                        <input class="form-control" id="bank" name="bank" type="text" placeholder="">
                    </div>


                    <div class="form-group ">
                        <label>LAMPIRAN</label>
                        <input required class="form-control" type="file" name="lampiran[]" id="lampiran">
                        <input required class="form-control" type="file" name="lampiran[]" id="lampiran">
                        <input required class="form-control" type="file" name="lampiran[]" id="lampiran">
                    </div>
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

        var kode = $("select[name=kode_budget] option:selected").val();
        var tahun = $("select[name=tahun_budget] option:selected").val();
        var bulan = $("select[name=bulan_budget] option:selected").val();

        if (kode == "" || kode == null) {
            alert("Pilih Kode Budget Dahulu");
            $('#bulan_budget').prop('selectedIndex', 0);
        } else {
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
                        alert('budget belum selesai di approve');
                    } else {
                        const data = JSON.parse(e);
                        console.log(e);
                        var budget = formatRupiah(data.budget_actual, 'Rp. ');
                        document.getElementById("budget_real").value = budget;
                        document.getElementById("budget").value = budget;
                        document.getElementById("id_planning_budget").value = data.id_planing;
                    }
                }
            })
        }
    })

    $('select[name=jenis_budget').on('change', function() {
        var jenis = $("select[name=jenis_budget] option:selected").val();
        var tahun = $("select[name=tahun_budget] option:selected").val();

        if (tahun == null || tahun == "") {
            alert("Pilih Tahun Terlebih Dahulu");
            $('#jenis_budget').prop('selectedIndex', 0);
        } else {
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
        }
    });


    $('select[name=jenis_transaksi').on('change', function() {
        var jenis = $("select[name=jenis_transaksi] option:selected").text();
        $.ajax({
            url: "<?= base_url('departement/Actual_budget/getNilaiBK') ?>",
            data: 'jenis=' + jenis,
            method: "POST",
            success: function(e) {
                document.getElementById("bk").value = e
            }
        })


        if (jenis == "PANJAR") {
            $("#rekening").prop("disabled", true);
            $("#to").prop("disabled", true);
            $("#bank").prop("disabled", true);
            $("#particullars").prop("disabled", true);
            $("#ammount").prop("disabled", true);
            $("#particullar").prop("disabled", true);
            $("#panjar").prop("disabled", false);
        } else if (jenis == "PAYMENT VOUCHER") {
            $("#rekening").prop("disabled", false);
            $("#to").prop("disabled", false);
            $("#bank").prop("disabled", false);
            $("#particullars").prop("disabled", false);
            $("#ammount").prop("disabled", false);
            $("#particullar").prop("disabled", false);
            $("#panjar").prop("disabled", true);
        } else {
            $("#particullar").prop("disabled", false);
            $("#rekening").prop("disabled", false);
            $("#to").prop("disabled", false);
            $("#bank").prop("disabled", false);
            $("#particullars").prop("disabled", false);
            $("#ammount").prop("disabled", false);
            $("#panjar").prop("disabled", false);

        }
    });

    $('select[name=kode_budget]').on('change', function() {
        // $('#jenis_budget').prop('selectedIndex', 0);
        // $('#kode_budget').prop('selectedIndex', 0);
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




    function convertNilai() {
        $(".input_am").keyup(function(event) {
            var div = $(event.relatedTarget);
            // console.log($(this).val());
            var angka = $(this).val();
            $(this).val(formatRupiah(angka.toString(), 'Rp. '));
        });
    }

    $(document).ready(function() {
        var wrapper = $(".input_fields_wrap"); //Fields wrapper
        var ammount = $(".add_ammount"); //Fields wrapper
        var add_button = $(".add_field_button"); //Add button ID
        var x = 1; //initlal text box count
        $(add_button).click(function(e) { //on add input button click
            e.preventDefault();

            $(wrapper).append('<div class="form-group"><label>PARTICULLARS</label><input type="text" name="particullar[]"  class="form-control"><a href="#" class="remove_field">Remove</a></div>'); //add input box

            $(ammount).append('<div class="form-group"><label>AMMOUNT</label><input type="text" name="ammount[]" onkeyup="convertNilai()" autocomplete="off" class="form-control input_am"><a href="#" class="remove_field2">Remove</a></div>'); //add input box
        });

        $(wrapper).on("click", ".remove_field", function(e) { //user click on remove text
            e.preventDefault();
            $(this).parent('div').remove();
        })
        $(ammount).on("click", ".remove_field2 ", function(e) { //user click on remove text
            e.preventDefault();
            $(this).parent('div').remove();
        })
        $("#tanggal").datepicker({
            "minDate": -7,
        });
    });
</script>