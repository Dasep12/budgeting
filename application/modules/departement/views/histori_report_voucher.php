<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">Transaksi Ap Voucher</a>
                    </li>
                    <li class="breadcrumb-item">
                        Lapor Voucher
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
                    <th class="table-sm small table-plus datatable-nosort">Kode Plant</th>
                    <th>Particullar</th>
                    <th>Voucher Plant</th>
                    <th>Voucher Actual</th>
                    <th>Status</th>
                    <th>Cetak</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($retur->result() as $pl) : ?>
                    <tr>
                        <td><?= $pl->request_code ?></td>
                        <td>
                            <?php
                            $parti = $this->model->ambilData("transaksi_detail_voucher", ['transaksi_plant_voucher_id' => $pl->id])->result();
                            foreach ($parti as $pr) {
                                echo "<li>" . $pr->particullar . "</li>";
                            }
                            ?>
                        </td>
                        <td><?= 'Rp. ' . number_format($pl->plant_sebelumnya, 0, ",", ".")  ?></td>
                        <td><?= 'Rp. ' . number_format($pl->total_voucher, 0, ",", ".")  ?></td>
                        <td>
                            <a href="#" type="button" data-id="<?= $pl->id ?>" class="approve_modal badge badge-success" data-toggle="modal" data-target="#detailApprove">
                                <i class="fa fa-file"></i>
                            </a>
                        </td>
                        <td>
                            <?php if ($pl->approve_lapor_fin == 1) { ?>
                                <a target="_blank" href="<?= base_url('departement/ReportVoucher/cetak_pdfVoucher?id=' . $pl->id) ?>" class="badge badge-success"><i class="fa fa-print"></i></a>
                            <?php } else { ?>
                                <a href="#" onclick="alert('Transaksi di tolak tidak bisa cetak')" class="badge badge-danger"><i class="fa fa-print"></i></a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="detailApprove" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail</h5>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> -->
            </div>
            <div class="modal-body data_detail">
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
    $(document).ready(function() {
        $("#detailApprove").on("show.bs.modal", function(event) {
            var div = $(event.relatedTarget);
            // Tombol dimana modal di tampilkan
            var modal = $(this);
            var userid = div.data('id');
            // AJAX request
            $.ajax({
                url: "<?= base_url('departement/ReportVoucher/viewDetailApprove') ?>",
                type: 'post',
                data: {
                    id: userid,
                },
                success: function(response) {
                    $('.data_detail').html(response);
                }
            });
        });

    })
</script>