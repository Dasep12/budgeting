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

    <form enctype="multipart/form-data" action="<?= base_url('departement/Raimbusment/input') ?>" method="post" onsubmit="return cek()">
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label>REQUEST CODE</label>
                    <input readonly class="form-control" value="<?= $code_dept ?>" id="request_code" name="request_code" type="text" placeholder="">
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
                    <input class="form-control" id="tanggal" name="tanggal" type="date" placeholder="">
                </div>

                <div class="form-group">
                    <label>AMMOUNT</label>
                    <input class="form-control" id="ammount" name="ammount[]" type="text" placeholder="">
                </div>

                <div class="add_ammount">

                </div>

                <div class="form-group ">
                    <label>LAMPIRAN</label>
                    <input required class="form-control" type="file" name="lampiran" id="lampiran">
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
                    <th class="table-plus datatable-nosort">Kode Request</th>
                    <th>Tanggal Request</th>
                    <th>Remarks</th>
                    <th>Nilai Rupiah</th>
                    <th>Status</th>
                    <th>Attach</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($raimbus->result() as $rm) : ?>
                    <tr>
                        <td><?= $rm->request_code ?></td>
                        <td><?= $rm->tanggal_request ?></td>
                        <td><?= $rm->remarks ?></td>
                        <?php $d = $this->model->TotalNilaiRaimbusment($rm->id)->row() ?>
                        <td><?= 'Rp. ' . number_format($d->total, 0, ",", ".") ?></td>
                        <td>
                            <?php if ($rm->status_approved == 0) { ?>
                                <span class="badge badge-danger">menunggu approved</span>
                            <?php } else if ($rm->status_approved == 1) { ?>
                                <span class="badge badge-success">approved manager</span>
                            <?php } else if ($rm->status_approved == 2) { ?>
                                <span class="badge badge-success">approved finance</span>
                            <?php } else if ($rm->status_approved == 3) { ?>
                                <span class="badge badge-success">approved accounting</span>
                            <?php } else if ($rm->status_approved == 4) { ?>
                                <span class="badge badge-success">approved gm</span>
                            <?php } else if ($rm->status_approved == 6) { ?>
                                <span class="badge badge-danger"><?= $bd->ket ?></span>
                            <?php } ?>
                        </td>
                        <td>
                            <a onclick="javascript:void window.open('<?= base_url('assets/lampiran/' . $rm->lampiran) ?>','1429893142534','scrollbars=1');return false;" class="badge badge-danger"><i class="fa fa-image"></i></a>
                        </td>
                        <td>
                            <span style="cursor:pointer ;" data-id="<?= $rm->id ?>" class="userinfo badge badge-primary"><i class="fa fa-eye"></i></span>

                            <a target="_blank" href="<?= base_url('departement/Laporan/cetak_pdfPanjer?id=' . $rm->id) ?>" class="badge badge-success"><i class="fa fa-print"></i></a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="empModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--  -->
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


        $('.userinfo').click(function() {
            var userid = $(this).data('id');
            // AJAX request
            $.ajax({
                url: "<?= base_url('departement/Raimbusment/detail_raimbusment') ?>",
                type: 'post',
                data: {
                    id: userid
                },
                success: function(response) {
                    // Add response in Modal body
                    $('.modal-body').html(response);
                    // Display Modal
                    $('#empModal').modal('show');
                }
            });
        });
    });

    function cek() {
        if (document.getElementById("particullar").value == "" || document.getElementById("particullar").value == NULL) {
            alert("isi data particullars");
            return false;
        } else if (document.getElementById("ammount").value == "" || document.getElementById("ammount").value == NULL) {
            alert("isi data ammount");
            return false;
        }

        return;
    }
</script>