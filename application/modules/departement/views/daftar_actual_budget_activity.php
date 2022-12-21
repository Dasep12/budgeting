<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.html">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        Actual Budget
                    </li>
                    <li class="breadcrumb-item active ">
                        Daftar Actual Activity Budget
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="home-tab" data-toggle="tab" data-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Approval Dept Head</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="profile-tab" data-toggle="tab" data-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Approval Budget Controller</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="contact-tab" data-toggle="tab" data-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Approval General Manager</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="contact-tab2" data-toggle="tab" data-target="#contact2" type="button" role="tab" aria-controls="contact" aria-selected="false">Approval Finance</button>
    </li>
</ul>
<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <div class="card-box mb-30" style="margin-top:-1px">
            <div class="pd-20">
                <!-- <h4 class="text-blue h4">Data Table Simple</h4> -->
            </div>
            <div class="pb-20">
                <table class="data-table table hover nowrap">
                    <thead>
                        <tr>
                            <th>Kode Request</th>
                            <th>Tanggal</th>
                            <th>Jenis Transaksi</th>
                            <th>Nilai</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($manager->result() as $df) : ?>
                            <tr>
                                <td>
                                    <a data-id="<?= $df->id_trans ?>" data-file1="<?= $df->lampiran_1 ?>" data-file2="<?= $df->lampiran_2 ?>" data-file3="<?= $df->lampiran_3 ?>" data-nama="<?= $df->nama_lengkap ?>" data-remarks="<?= $df->remarks ?>" data-jenis="<?= $df->jenis_transaksi ?>" href="#" class="text-primary tx-under userinfo" data-toggle="modal" data-target="#exampleModal">
                                        <?= $df->request_code ?>
                                    </a>
                                </td>
                                <td><?= $df->tanggal_request ?></td>
                                <td><?= $df->jenis_transaksi ?></td>
                                <td><?= 'Rp. ' . number_format($df->total, 0, ",", ".") ?></td>
                                <td>
                                    <label for="" class="badge <?= $df->approve_mgr == '1' ? 'badge-primary' : 'badge-danger' ?>"><?= $df->ket ?></label>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <div class="card-box mb-30" style="margin-top:-1px">
            <div class="pd-20">
                <!-- <h4 class="text-blue h4">Data Table Simple</h4> -->
            </div>
            <div class="pb-20">
                <table class="data-table table hover nowrap">
                    <thead>
                        <tr>
                            <th>Kode Request</th>
                            <th>Tanggal</th>
                            <th>Jenis Transaksi</th>
                            <th>Nilai</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bc->result() as $df) : ?>
                            <tr>
                                <td> <a data-id="<?= $df->id_trans ?>" data-file1="<?= $df->lampiran_1 ?>" data-file2="<?= $df->lampiran_2 ?>" data-file3="<?= $df->lampiran_3 ?>" data-nama="<?= $df->nama_lengkap ?>" data-remarks="<?= $df->remarks ?>" data-jenis="<?= $df->jenis_transaksi ?>" href="#" class="text-primary tx-under userinfo" data-toggle="modal" data-target="#exampleModal">
                                        <?= $df->request_code ?>
                                    </a></td>
                                <td><?= $df->tanggal_request ?></td>
                                <td><?= $df->jenis_transaksi ?></td>
                                <td><?= 'Rp. ' . number_format($df->total, 0, ",", ".") ?></td>
                                <td>
                                    <label for="" class="badge <?= $df->approve_acc == '1' ? 'badge-primary' : 'badge-danger' ?>"><?= $df->ket ?></label>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
        <div class="card-box mb-30" style="margin-top:-1px">
            <div class="pd-20">
                <!-- <h4 class="text-blue h4">Data Table Simple</h4> -->
            </div>
            <div class="pb-20">
                <table class="data-table table hover nowrap">
                    <thead>
                        <tr>
                            <th>Kode Request</th>
                            <th>Tanggal</th>
                            <th>Jenis Transaksi</th>
                            <th>Nilai</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($gm->result() as $df) : ?>
                            <tr>
                                <td>
                                    <a data-id="<?= $df->id_trans ?>" data-file1="<?= $df->lampiran_1 ?>" data-file2="<?= $df->lampiran_2 ?>" data-file3="<?= $df->lampiran_3 ?>" data-nama="<?= $df->nama_lengkap ?>" data-remarks="<?= $df->remarks ?>" data-jenis="<?= $df->jenis_transaksi ?>" href="#" class="text-primary tx-under userinfo" data-toggle="modal" data-target="#exampleModal">
                                        <?= $df->request_code ?>
                                    </a>
                                </td>
                                <td><?= $df->tanggal_request ?></td>
                                <td><?= $df->jenis_transaksi ?></td>
                                <td><?= 'Rp. ' . number_format($df->total, 0, ",", ".") ?></td>
                                <td>
                                    <label for="" class="badge <?= $df->approve_gm == '1' ? 'badge-primary' : 'badge-danger' ?>"><?= $df->ket ?></label>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="contact2" role="tabpanel" aria-labelledby="contact-tab2">
        <div class="card-box mb-30" style="margin-top:-1px">
            <div class="pd-20">
                <!-- <h4 class="text-blue h4">Data Table Simple</h4> -->
            </div>
            <div class="pb-20">
                <table class="data-table table hover nowrap">
                    <thead>
                        <tr>
                            <th>Kode Request</th>
                            <th>Tanggal</th>
                            <th>Jenis Transaksi</th>
                            <th>Nilai</th>
                            <th>Status</th>
                            <th>Cetak</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($finance->result() as $df) : ?>
                            <tr>
                                <td>
                                    <a data-id="<?= $df->id_trans ?>" data-file1="<?= $df->lampiran_1 ?>" data-file2="<?= $df->lampiran_2 ?>" data-file3="<?= $df->lampiran_3 ?>" data-nama="<?= $df->nama_lengkap ?>" data-remarks="<?= $df->remarks ?>" data-jenis="<?= $df->jenis_transaksi ?>" href="#" class="text-primary tx-under userinfo" data-toggle="modal" data-target="#exampleModal">
                                        <?= $df->request_code ?>
                                    </a>
                                </td>
                                <td><?= $df->tanggal_request ?></td>
                                <td><?= $df->jenis_transaksi ?></td>
                                <td><?= 'Rp. ' . number_format($df->total, 0, ",", ".") ?></td>
                                <td>
                                    <label for="" class="badge <?= $df->approve_fin == '1' ? 'badge-primary' : 'badge-danger' ?>"><?= $df->ket ?></label>
                                </td>
                                <td>
                                    <?php
                                    if ($df->jenis_transaksi == "PANJAR") { ?>

                                        <?php if ($df->approve_fin == 1) { ?>
                                            <a target="_blank" href="<?= base_url('departement/Laporan/cetak_pdfPanjer?id=' . $df->id_trans) ?>" class="badge badge-success"><i class="fa fa-print"></i></a>
                                        <?php } else { ?>
                                            <a target="_blank" onclick="alert('Transaksi di tolak tidak bisa cetak')"><i class="fa fa-print"></i></a>
                                        <?php } ?>
                                    <?php  } else { ?>
                                        <?php if ($df->approve_fin == 1) { ?>
                                            <a target="_blank" href="<?= base_url('departement/Laporan/cetak_pdfPayment?id=' . $df->id_trans) ?>" class="badge badge-success"><i class="fa fa-print"></i></a>
                                        <?php } else { ?>
                                            <a href="#" onclick="alert('Transaksi di tolak tidak bisa cetak')" class="badge badge-danger"><i class="fa fa-print"></i></a>
                                        <?php } ?>

                                    <?php } ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
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
                var file1 = $(this).data('file1');
                var file2 = $(this).data('file2');
                var file3 = $(this).data('file3');
                var nama = $(this).data('nama');
                var remarks = $(this).data('remarks');
                var jenis = $(this).data('jenis');
                // AJAX request
                $.ajax({
                    url: "<?= base_url('departement/Actual_budget/viewDetailRaimbes') ?>",
                    type: 'post',
                    data: {
                        id: userid,
                        'file1': file1,
                        'file2': file2,
                        'file3': file3,
                        'nama': nama,
                        'remarks': remarks,
                        'jenis': jenis
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
        })
    </script>