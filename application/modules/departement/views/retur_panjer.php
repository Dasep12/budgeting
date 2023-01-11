<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.html">Transaction</a>
                    </li>
                    <li class="breadcrumb-item active">
                        Lapor Panjar
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
            <h4 class="text-blue h4 mb-2">LAPOR PANJAR</h4>
        </div>
    </div>

    <form action="<?= base_url('departement/Retur/inputRetur') ?>" method="post" onsubmit="return cek()">
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">

                    <input type="hidden" name="plant_id" id="plant_id">
                    <input type="hidden" name="id_trans" id="id_trans">
                    <input type="hidden" name="detail_idtrans" id="detail_idtrans">
                    <label>KODE TRANSAKSI</label>
                    <select id="jenis_trans" name="jenis_trans" class="form-control select2-single">
                        <option value="">Pilih Kode Transaksi</option>
                        <?php foreach ($list->result() as $jn) : ?>
                            <option value="<?= $jn->id ?>"><?= $jn->request_code ?></option>
                        <?php endforeach ?>
                    </select>
                    <div id="load_budget_nilai" style="display:none ;">
                        <span class="text-danger font-italic small">mengambil nilai panjar . . .</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="">KETERANGAN</label>
                    <textarea name="keterangan" required id="keterangan" class="form-control"></textarea>
                </div>


            </div>
            <div class="col-lg-6">

                <div class="form-group">
                    <label>NILAI PANJAR</label>
                    <input readonly class="form-control" id="nilai_panjar" type="text" placeholder="">
                    <input readonly class="form-control" name="nilai_panjar" id="nilai_panjar_real" type="hidden" placeholder="">
                </div>

                <div class="form-group">
                    <label>PENGEMBALIAN PANJAR</label>
                    <input class="form-control" id="return_panjar_real" name="return_panjar" type="hidden" placeholder="">
                    <input class="form-control" required id="return_panjar" type="text" placeholder="">
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

    $('select[name=jenis_trans').on('change', function() {
        $('#jenis_budget').prop('selectedIndex', 0);
    })

    $('select[name=jenis_trans').on('change', function() {
        var id = $("select[name=jenis_trans] option:selected").val();

        if (id == null || id == "") {
            alert("Pilih Kode Transaksi")
            $('#jenis_budget').prop('selectedIndex', 0);
        } else {
            $.ajax({
                url: "<?= base_url('departement/Retur/getDataTransaksi') ?>",
                method: "GET",
                data: "id=" + id,
                cache: false,
                beforeSend: function() {
                    document.getElementById("load_budget_nilai").style.display = 'block';
                },
                complete: function() {
                    document.getElementById("load_budget_nilai").style.display = 'none';
                },
                success: function(e) {
                    if (e == 0 || e === '0') {
                        alert('tidak ada data');
                    } else {
                        const data = JSON.parse(e);
                        var budget = formatRupiah(data.total, 'Rp. ');
                        document.getElementById("plant_id").value = data.plant_id;
                        document.getElementById("id_trans").value = data.trans_id;
                        document.getElementById("detail_idtrans").value = data.detail_id_trans;
                        document.getElementById("nilai_panjar_real").value = data.total;
                        document.getElementById("nilai_panjar").value = budget;
                    }
                }
            })
        }

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

    convert("return_panjar", "return_panjar_real");


    function cek() {
        var panjar = document.getElementById("nilai_panjar_real").value;
        var retur = document.getElementById("return_panjar_real").value;

        if (parseInt(retur) > parseInt(panjar)) {
            alert("return terlalu besar melebihi kapasitas");
            return false;
        }
        return;
    }
</script>