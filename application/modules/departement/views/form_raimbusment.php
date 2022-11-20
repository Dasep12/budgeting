<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active ">
                        Raimbusment
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
            <h4 class="text-blue h4 mb-2">RAIMBUSMENT</h4>
        </div>
    </div>

    <form action="<?= base_url('departement/Raimbusment/input') ?>" method="post" onsubmit="return cek()">
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label>REQUEST CODE</label>
                    <input readonly class="form-control" value="<?= $code_dept ?>" id="kode_budget" name="kode_budget" type="text" placeholder="">
                </div>

                <div class="form-group">
                    <label>PARTICULLARS</label>
                    <a href="" class="add_field_button badge badge-success badge-sm">Tambah</a>
                    <input class="form-control" name="particullar[]" type="text" placeholder="">
                </div>
                <div class="form-group input_fields_wrap">

                </div>

                <div class="form-group">
                    <label>REMARKS</label>
                    <textarea id="activity" name="activity" class="form-control" placeholder=""></textarea>
                </div>

            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label>TANGGAL REQUEST</label>
                    <input class="form-control" id="use_budget" type="date" placeholder="">
                </div>

                <div class="form-group">
                    <label>AMMOUNT</label>
                    <input class="form-control" name="ammount[]" type="text" placeholder="">
                </div>

                <div class="add_ammount">

                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-sm">Save</button>
                    <button type="reset" class="btn btn-danger btn-sm">Reset</button>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="card-box mb-30">
    <div class="pd-20">
        <!-- <h4 class="text-blue h4">Data Table Simple</h4> -->
    </div>
    <div class="pb-20">
        <table class="data-table table hover nowrap">
            <thead>
                <tr>
                    <th class="table-plus datatable-nosort">Kode Budget</th>
                    <th>Departement</th>
                    <th>Tahun Budget</th>
                    <th>Bulan</th>
                    <th>Budget</th>
                    <th>Activity</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>

<script>
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

    function cek() {


    }
</script>