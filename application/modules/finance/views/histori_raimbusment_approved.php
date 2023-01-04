<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active ">
                        Histori Approved
                    </li>
                </ol>
            </nav>
        </div>
    </div>
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
                    <th>Particullar</th>
                    <th>Nilai Rupiah</th>
                    <th>Status</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($raimbus->result() as $rm) : ?>
                    <tr>
                        <td><?= $rm->request_code ?></td>
                        <td><?= $rm->tanggal_request ?></td>
                        <td><?php
                            $data = $this->model->ambilData("trans_detail_jenis_pembayaran", ['transaksi_jenis_pembayaran_id' => $rm->id])->result();
                            foreach ($data as $lp) {
                                echo "<li>" . $lp->particullar . "</li>";
                            }
                            ?></td>
                        <?php $d = $this->model->TotalNilaiRaimbusment($rm->id)->row() ?>
                        <td><?= 'Rp. ' . number_format($d->total, 0, ",", ".") ?></td>
                        <td><?= $rm->ket ?></td>
                        <td>
                            <a data-id="<?= $rm->id ?>" data-file1="<?= $rm->lampiran_1 ?>" data-file2="<?= $rm->lampiran_2 ?>" data-file3="<?= $rm->lampiran_3 ?>" data-nama="<?= $rm->nama_lengkap ?>" data-remarks="<?= $rm->remarks ?>" data-jenis="<?= $rm->jenis_transaksi ?>" class="userinfo badge badge-primary text-white" data-toggle="modal" data-target="#exampleModal">Checked</a>

                            <?php
                            if ($rm->jenis_transaksi == "PAYMENT VOUCHER" || $rm->jenis_transaksi == "payment voucher") {
                                if ($rm->pcl == 0) { ?>
                                    <a onclick="return confirm('Close Transaksi ?')" href="<?= base_url('finance/Approve_trans/closePayment?id=' . $rm->id_trans . '&kode=1') ?>" class="badge badge-danger text-white">close</a>
                                <?php   } else { ?>
                                    <a href="#" onclick="alert('Transaksi Sudah Close')" class="badge badge-success text-white">close</a>
                                <?php    }
                                ?>

                            <?php } ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
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
                url: "<?= base_url('finance/Approve_trans/viewDetailRaimbes') ?>",
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