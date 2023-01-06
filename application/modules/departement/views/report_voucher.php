<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        Transaksi Ap Voucer
                    </li>
                    <li class="breadcrumb-item active ">
                        Lapor Ap Voucher
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
            <h4 class="text-blue h4 mb-2">LAPOR AP VOUCHER</h4>
        </div>
    </div>

    <form id="regForm" enctype="multipart/form-data" action="<?= base_url('departement/ReportVoucher/input') ?>" method="post" onsubmit="return cek()">
        <div class="tab">
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>KODE REQUEST</label>
                        <input type="hidden" id="id_planning" name="id_planning">
                        <select id="request" name="request" class="form-control">
                            <option value="">Pilih Kode</option>
                            <?php foreach ($plant->result() as $pl) : ?>
                                <option value="<?= $pl->id ?>"><?= $pl->request_code ?></option>
                            <?php endforeach ?>
                        </select>
                        <div id="load_budget_nilai" style="display:none ;">
                            <span class="text-danger font-italic small">mengambil nilai budget . . .</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>PARTICULLARS</label>
                        <a href="" class="add_field_button badge badge-success badge-sm">Tambah</a>
                        <input class="form-control" id="particullar" name="particullar[]" type="text" placeholder="">
                    </div>
                    <div class="form-group input_fields_wrap">

                    </div>

                    <div class="form-group">

                    </div>

                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>VOUCHER PLANT</label>
                        <input type="hidden" name="budget_real" id="budget_real">
                        <input readonly class="form-control" id="budget" type="text" placeholder="">
                    </div>

                    <div class="form-group">
                        <label>AMMOUNT</label>
                        <input class="form-control" id="ammount" name="ammount[]" type="text" placeholder="">
                    </div>

                    <div class="form-group">
                        <div class="add_ammount">
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                    </div>
                </div>
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

    $('select[name=request').on('change', function() {
        var kode = $("select[name=request] option:selected").val();
        $.ajax({
            url: "<?= base_url('departement/ReportVoucher/getBudget') ?>",
            method: "GET",
            data: "kode=" + kode,
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
                    console.log(data);
                    var budget = formatRupiah(data.total_voucher, 'Rp. ');
                    document.getElementById("budget_real").value = data.total_voucher;
                    document.getElementById("budget").value = budget;
                    document.getElementById("id_planning").value = data.id;
                }
            }
        })
    })




    function cek() {
        var budget_plant = document.getElementById("budget_real").value;
        var budget_input = document.getElementById("use_budget_real").value;

        if (parseInt(budget_input) > parseInt(budget_plant)) {
            alert("budget melebih kapasitas");
            return false;
        }
        return;
    }

    $(document).ready(function() {
        var wrapper = $(".input_fields_wrap"); //Fields wrapper
        var ammount = $(".add_ammount"); //Fields wrapper
        var add_button = $(".add_field_button"); //Add button ID
        var x = 1; //initlal text box count
        $(add_button).click(function(e) { //on add input button click
            e.preventDefault();

            $(wrapper).append('<div class="form-group"><label>PARTICULLARS</label><input type="text" name="particullar[]" class="form-control"/><a href="#" class="remove_field">Remove</a></div>'); //add input box

            $(ammount).append('<div class="form-group"><label>AMMOUNT</label><input type="text" name="ammount[]" class="form-control"/><a href="#" class="remove_field2">Remove</a></div>'); //add input box
        });

        $(wrapper).on("click", ".remove_field", function(e) { //user click on remove text
            e.preventDefault();
            $(this).parent('div').remove();
        })
        $(ammount).on("click", ".remove_field2 ", function(e) { //user click on remove text
            e.preventDefault();
            $(this).parent('div').remove();
        })
    });
</script>