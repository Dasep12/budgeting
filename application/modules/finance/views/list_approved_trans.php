<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.html">Dashboard</a>
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
                    <th>Jenis Transaksi</th>
                    <th>Nilai Rupiah</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($raimbus->result() as $rm) : ?>
                    <tr>
                        <td><?= $rm->request_code ?></td>
                        <td><?= $rm->tanggal_request ?></td>
                        <td><?= $rm->jenis_transaksi ?></td>
                        <td><?= 'Rp. ' . number_format($rm->total, 0, ",", ".") ?></td>
                        <td>
                            <?php
                            if ($rm->approve_gm == 1) { ?>
                                <a data-id="<?= $rm->id_trans ?>" class="userinfo badge badge-primary text-white" data-toggle="modal" data-target="#exampleModal">Checked</a>
                            <?php } else { ?>
                                <a data-id="<?= $rm->id_trans ?>" class="userinfo badge badge-primary text-white" data-toggle="modal" data-target="#exampleModal">Checked</a>

                                <a href="<?= base_url('finance/Approve_trans/approve?id=' . $rm->id_trans . '&kode=1') ?>" onclick="return confirm('Yakin approve ?')" class="badge badge-success">Approved</a>
                                <a onclick="return confirm('Yakin reject ?')" href="<?= base_url('finance/Approve_trans/approve?id_budget=' . $rm->id_trans . '&kode=2') ?>" class="badge badge-danger">Reject</a>
                            <?php }
                            ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
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
                url: "<?= base_url('finance/Approve_trans/viewDetailRaimbes') ?>",
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
    })
</script>