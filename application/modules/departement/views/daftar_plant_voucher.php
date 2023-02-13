<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        Transaksi AP Voucher
                    </li>
                    <li class="breadcrumb-item active ">
                        Histori Plant
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
                    <th class="table-sm small table-plus datatable-nosort">Kode Budget</th>
                    <th>Tanggal</th>
                    <th>Request By</th>
                    <th>Particullar</th>
                    <th>Ammount</th>
                    <th>Remarks</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($plant->result() as $pl) : ?>
                    <tr>
                        <td><span class="text-primary"><?= $pl->request_code  ?></span></td>
                        <td><?= $pl->tanggal ?></td>
                        <td><?= ucwords($pl->nama)  ?></td>
                        <td>
                            <?php
                            $parti = $this->model->ambilData("transaksi_detail_voucher", ['transaksi_plant_voucher_id' => $pl->id])->result();
                            foreach ($parti as $pr) {
                                echo "<li>" . $pr->particullar . "</li>";
                            }
                            ?>
                        </td>
                        <td><?= 'Rp. ' . number_format($pl->total_voucher, 0, ",", ".") ?></td>
                        <td><?= $pl->remarks ?></td>
                        <td>
                            <a data-file1="<?= $pl->lampiran_1 ?>" data-file2="<?= $pl->lampiran_2 ?>" data-file3="<?= $pl->lampiran_3 ?>" data-nama="<?= $pl->nama ?>" data-remarks="<?= $pl->remarks ?>" data-jenis="<?= $pl->jenis_transaksi ?>" data-id="<?= $pl->id ?>" class="text-white userinfo badge badge-primary" data-toggle="modal" data-target="#detailPlant">
                                <i class="fa fa-eye"></i>
                            </a>

                            <a data-id="<?= $pl->id ?>" class="approve_modal  text-white badge badge-success" data-toggle="modal" data-target="#detailApprove">
                                <i class="fa fa-file"></i>
                            </a>

                            <?php if ($pl->approve_spv == 0) { ?>
                                <a onclick="return confirm('Yakin Hapus ?')" href="<?= base_url('departement/HistoriVoucher/delete?id=' . $pl->id) ?>" class="text-white badge badge-danger">
                                    <i class="fa fa-close"></i>
                                </a>

                                <a href="<?= base_url('departement/HistoriVoucher/form_edit_voucher?id=' . $pl->id) ?>" class="text-white badge badge-primary">
                                    <i class="fa fa-edit"></i>
                                </a>
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
            <div class="modal-body timeline_data">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--  -->

<!-- Modal -->
<div class="modal fade" id="detailPlant" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail</h5>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> -->
            </div>
            <div class="modal-body detail_plant">
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
                url: "<?= base_url('departement/HistoriVoucher/viewDetailApprove') ?>",
                type: 'post',
                data: {
                    id: userid,
                },
                success: function(response) {
                    // console.log(response)
                    $('.timeline_data').html(response);
                    // $('#detailPlant').modal('show');
                }
            });
        });

        $("#detailPlant").on("show.bs.modal", function(event) {
            var div = $(event.relatedTarget);
            // Tombol dimana modal di tampilkan
            var modal = $(this);
            var userid = div.data('id');
            var file1 = div.data('file1');
            var file2 = div.data('file2');
            var file3 = div.data('file3');
            var nama = div.data('nama');
            var remarks = div.data('remarks');
            var jenis = div.data('jenis');
            // AJAX request
            $.ajax({
                url: "<?= base_url('departement/HistoriVoucher/viewDetailPlant') ?>",
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
                success: function(response) {
                    // Add response in Modal body
                    $('.detail_plant').html(response);
                    // Display Modal
                    // $('#detail_plant').modal('show');
                }
            });
        });
    });
</script>