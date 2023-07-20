<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">EBUDGET</a>
                    </li>
                    <li class="breadcrumb-item active ">
                        Approved
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
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Gagal !</strong> <?= $this->session->flashdata("nok") ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php $this->session->unset_userdata("nok") ?>
<?php } ?>

<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="home-tab" data-toggle="tab" data-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">MENUNGGU </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="profile-tab" data-toggle="tab" data-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">SUDAH TERPROSES</button>
    </li>
</ul>

<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <div class="card-box mb-30">
            <form id="form" name="form" method="post">
                <div class="pd-20">
                    <div class="form-inline">
                        <button type="button" onclick="approveAll()" id="btn_delete_all" style="display:none ;" class="btn btn-success btn-sm mb-2 mr-2"> APPROVE DATA TERPILIH</button>
                        <button type="button" onclick="rejectAll()" id="btn_reject_all" style="display:none ;" class="btn btn-danger btn-sm mb-2 mr-2"> REJECT DATA TERPILIH</button>
                    </div>
                </div>
                <div class="pb-20">
                    <table class="data-table table stripe hover nowrap table-bordered">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Kode Budget</th>
                                <th>Departement</th>
                                <th>Tahun</th>
                                <th>Total Budget</th>
                                <th>Jenis Budget</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($daftar->result() as $df) : ?>
                                <tr>
                                    <th>
                                        <input type="checkbox" class="multi" name="multi[]" id="multi" value="<?= $df->id_budget ?>">
                                    </th>
                                    <td><?= $df->kode_budget ?></td>
                                    <td><?= $df->nama_departement ?></td>
                                    <td><?= $df->tahun ?></td>
                                    <td><?= 'Rp. ' . number_format($df->budget, 0, ",", ".")  ?></td>
                                    <td><?= $df->jenis_budget ?></td>

                                    <td>
                                        <a data-kode="<?= $df->kode_budget ?>" data-id="<?= $df->id_budget ?>" class="userinfo badge badge-primary text-white" data-toggle="modal" data-target="#exampleModal">Detail</a>

                                        <a href="<?= base_url('finance/Approved/approve?id_budget=' . $df->id_budget . '&kode=1') ?>" onclick="return confirm('Yakin approve ?')" class="badge badge-success">Approved</a>

                                        <a onclick="return confirm('Yakin reject ?')" href="<?= base_url('finance/Approved/approve?id_budget=' . $df->id_budget . '&kode=2') ?>" class="badge badge-danger">Reject</a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>

    <div class="tab-pane fade show" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <div class="card-box mb-30">
            <div class="pd-20">
                <!-- <h4 class="text-blue h4">Data Table Simple</h4> -->
            </div>
            <div class="pb-20">
                <table class="data-table table stripe hover nowrap table-bordered">
                    <thead>
                        <tr>
                            <th>Kode Budget</th>
                            <th>Departement</th>
                            <th>Tahun</th>
                            <th>Total Budget</th>
                            <th>Jenis Budget</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($selesai->result() as $df) : ?>
                            <tr>
                                <td><?= $df->kode_budget ?></td>
                                <td><?= $df->nama_departement ?></td>
                                <td><?= $df->tahun ?></td>
                                <td><?= 'Rp. ' . number_format($df->budget, 0, ",", ".")  ?></td>
                                <td><?= $df->jenis_budget ?></td>
                                <td><?= $df->ket ?></td>

                                <td>
                                    <a data-kode="<?= $df->kode_budget ?>" data-id="<?= $df->id_budget ?>" class="userinfo badge badge-primary text-white" data-toggle="modal" data-target="#exampleModal">Detail</a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>




<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail</h5>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> -->
            </div>
            <div class="modal-body">
                sedang mengambil data
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--  -->

<script>
    $(function() {

        $('#exampleModal').on("show.bs.modal", function(event) {
            var div = $(event.relatedTarget);
            var userid = div.data('id');
            // AJAX request
            $.ajax({
                url: "<?= base_url('finance/Approved/viewDetailPlant') ?>",
                type: 'post',
                data: {
                    id: userid
                },
                beforeSend: function() {

                },
                complete: function() {

                },
                success: function(response) {
                    // console.log(response)
                    // Add response in Modal body
                    $('.modal-body').html(response);
                    // Display Modal
                    // $('#empModal').modal('show');
                }
            });
        });

        $(".multi").click(function() {
            var panjang = $('[name="multi[]"]:checked').length;
            if (panjang > 0) {
                document.getElementById('btn_delete_all').style.display = "block";
                document.getElementById('btn_reject_all').style.display = "block";
            } else {
                document.getElementById('btn_delete_all').style.display = "none";
                document.getElementById('btn_reject_all').style.display = "none";
            }
        })

        $("#check-all").click(function() {
            if ($(this).is(":checked")) {
                $(".multi").prop("checked", true);
                document.getElementById('btn_delete_all').style.display = "block";
                document.getElementById('btn_reject_all').style.display = "block";
                var panjang = $('[name="multi[]"]:checked').length;
            } else {
                $(".multi").prop("checked", false);
                document.getElementById('btn_delete_all').style.display = "none";
                document.getElementById('btn_reject_all').style.display = "none";
            }
        })
    })

    function rejectAll() {
        if (confirm("Yakin Reject Budget ?") == true) {
            $("#form").attr("action", "<?= base_url('finance/Approved/multiReject') ?>");
            $("#form").submit();
        }
    }

    function approveAll() {
        if (confirm("Yakin Approve Budget ?") == true) {
            $("#form").attr("action", "<?= base_url('finance/Approved/multiApprove') ?>");
            $("#form").submit();
        }
    }
</script>