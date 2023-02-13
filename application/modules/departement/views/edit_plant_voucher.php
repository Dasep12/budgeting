<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        Transaksi Ap Voucer
                    </li>
                    <li class="breadcrumb-item active ">
                        Edit Plant Voucher
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
            <h4 class="text-blue h4 mb-2">EDIT PLANT AP VOUCHER</h4>
        </div>
    </div>

    <form id="regForm" enctype="multipart/form-data" action="<?= base_url('departement/HistoriVoucher/update') ?>" method="post" onsubmit="return cek()">
        <div class="tab">
            <div class="row">
                <!-- <a href="" class="add_field_button badge badge-success badge-sm">Tambah</a> -->
                <?php foreach ($detail as $dtl) : ?>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>PARTICULLARS</label>

                            <input class="form-control" value="<?= $dtl->particullar ?>" id="particullar" name="particullar[]" type="text" placeholder="">
                            <a href="#" class="remove_field2">Remove</a>
                        </div>
                        <div class="form-group input_fields_wrap">

                        </div>

                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>AMMOUNT</label>
                            <input value="<?= 'Rp. ' . number_format($dtl->ammount, 0, ",", ".") ?>" class="form-control input_am" autocomplete="off" onkeyup="convertNilai()" id="ammount" name="ammount[]" type="text" placeholder="">
                            <a href="#" class="remove_field2">Remove</a>
                        </div>
                        <div class="add_ammount">

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>REMARKS</label>
                        <input type="hidden" name="id" value="<?= $header->id ?>">
                        <textarea id="remarks" name="remarks" class="form-control" placeholder=""><?= $header->remarks ?></textarea>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">

                        <button type="submit" class="btn btn-sm btn-primary" id="nextBtn">Update Data</button>
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

        $($(".form-group")).on("click", ".remove_field2 ", function(e) { //user click on remove text
            e.preventDefault();
            $(this).parent('div').remove();
        })

        $("#tanggal").datepicker({
            "minDate": -7,
        });
    });
</script>