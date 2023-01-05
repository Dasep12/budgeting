<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.html">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active ">
                        Approved Plant Voucher
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
            <form action="<?= base_url('budgetControl/Approve_voucher/multiApprove') ?>" method="post">
                <div class="pd-20">
                    <button onclick="return confirm('Yakin Approve Data ?')" id="btn_delete_all" style="display:none ;" class="btn btn-success btn-sm mb-2 mr-2"> APPROVE DATA TERPILIH</button>
                </div>
                <div class="pb-20">
                    <table class="data-table table stripe hover nowrap table-bordered">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Kode Request</th>
                                <th>Departement</th>
                                <th>Tanggal</th>
                                <th>Particullar</th>
                                <th>Total </th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($wait->result() as $df) : ?>
                                <tr>
                                    <th>
                                        <input type="checkbox" class="multi" name="multi[]" id="multi" value="<?= $df->id ?>">
                                    </th>
                                    <td><?= $df->request_code ?></td>
                                    <td><?= $df->nama_departement ?></td>
                                    <td><?= $df->tanggal ?></td>
                                    <td>
                                        <?php
                                        $parti = $this->model->ambilData("transaksi_detail_voucher", ['transaksi_plant_voucher_id' => $df->id])->result();
                                        foreach ($parti as $pr) {
                                            echo "<li>" . $pr->particullar . "</li>";
                                        }
                                        ?>
                                    </td>
                                    <td><?= 'Rp. ' . number_format($df->total_voucher, 0, ",", ".")  ?></td>

                                    <td>
                                        <?php
                                        if ($df->approve_acc == 1 || $df->approve_acc == 2) { ?>
                                            <a data-kode="<?= $df->request_code ?>" data-id="<?= $df->id ?>" class="userinfo badge badge-primary text-white" data-toggle="modal" data-target="#exampleModal">Checked</a>
                                        <?php } else { ?>
                                            <!-- <a data-kode="<?= $df->request_code ?>" data-id="<?= $df->id ?>" class="userinfo badge badge-primary text-white" data-toggle="modal" data-target="#exampleModal">Checked</a> -->

                                            <a href="<?= base_url('budgetControl/Approve_voucher/approve?id_budget=' . $df->id . '&kode=1') ?>" onclick="return confirm('Yakin approve ?')" class="badge badge-success">Approved</a>
                                            <a onclick="return confirm('Yakin reject ?')" href="<?= base_url('budgetControl/Approve_voucher/approve?id_budget=' . $df->id . '&kode=2') ?>" class="badge badge-danger">Reject</a>

                                        <?php }
                                        ?>
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
                            <th>Kode Request</th>
                            <th>Departement</th>
                            <th>Tanggal</th>
                            <th>Particullar</th>
                            <th>Total </th>
                            <th>Status</th>
                            <!-- <th>Action</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($proces->result() as $df) : ?>
                            <tr>
                                <td><?= $df->request_code ?></td>
                                <td><?= $df->nama_departement ?></td>
                                <td><?= $df->tanggal ?></td>
                                <td>
                                    <?php
                                    $parti = $this->model->ambilData("transaksi_detail_voucher", ['transaksi_plant_voucher_id' => $df->id])->result();
                                    foreach ($parti as $pr) {
                                        echo "<li>" . $pr->particullar . "</li>";
                                    }
                                    ?>
                                </td>
                                <td><?= 'Rp. ' . number_format($df->total_voucher, 0, ",", ".")  ?></td>
                                <td>
                                    <?= $df->ket ?>
                                </td>

                                <!-- <td>
                                    <a data-kode="<?= $df->request_code ?>" data-id="<?= $df->id ?>" class="userinfo badge badge-primary text-white" data-toggle="modal" data-target="#exampleModal">Checked</a>
                                </td> -->
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

        $('.userinfo').click(function() {
            var userid = $(this).data('id');
            // AJAX request
            $.ajax({
                url: "<?= base_url('budgetControl/Approved_voucher/viewDetailPlant') ?>",
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
                    $('#empModal').modal('show');
                }
            });
        });

        $(".multi").click(function() {
            var panjang = $('[name="multi[]"]:checked').length;
            if (panjang > 0) {
                document.getElementById('btn_delete_all').style.display = "block";
            } else {
                document.getElementById('btn_delete_all').style.display = "none";
            }
        })

        $("#check-all").click(function() {
            if ($(this).is(":checked")) {
                $(".multi").prop("checked", true);
                document.getElementById('btn_delete_all').style.display = "block";
                var panjang = $('[name="multi[]"]:checked').length;
            } else {
                $(".multi").prop("checked", false);
                document.getElementById('btn_delete_all').style.display = "none";
            }
        })
    })
</script>