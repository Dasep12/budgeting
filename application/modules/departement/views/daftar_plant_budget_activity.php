<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        Plant Budget
                    </li>
                    <li class="breadcrumb-item active ">
                        Daftar Plant Activity Budget
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
                    <!-- <th>Tanggal</th> -->
                    <th class="table-sm small table-plus datatable-nosort">Kode Budget</th>
                    <th>Departement</th>
                    <th>Tahun Budget</th>
                    <th>Budget</th>
                    <th>Activity</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($plant->result() as $pl) : ?>
                    <tr>
                        <!-- <td><?= $pl->created_at ?></td> -->
                        <td><span class="text-primary"><?= $pl->kode_budget ?></span></td>
                        <td><?= $pl->nama_departement ?></td>
                        <td><?= $pl->tahun ?></td>
                        <td>
                            <?php if ($pl->budget == "NaN" || $pl->budget == "nan") { ?>
                                <a onclick="return confirm('Syncronize')" href="<?= base_url('departement/Plant_budget/sync?id_budget=' . $pl->id_budget) ?>" class="badge badge-info text-white">
                                    syncronize budget <i class="fa fa-refresh"></i>
                                </a>
                            <?php } else {
                                echo 'Rp. ' . number_format($pl->budget, 0, ",", ".");
                            } ?>
                        </td>
                        <td><?= $pl->activity ?></td>
                        <td>
                            <a data-id="<?= $pl->id_budget ?>" class="text-white userinfo badge badge-primary" data-toggle="modal" data-target="#detailPlant">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a data-id="<?= $pl->id_budget ?>" class="text-white approve_modal badge badge-success" data-toggle="modal" data-target="#detailApprove">
                                <i class="fa fa-file"></i>
                            </a>

                            <?php
                            if ($pl->approve_mgr == 1  || $pl->approve_bc == 1  || $pl->approve_fin == 1) { ?>
                            <?php } else { ?>
                                <a href="<?= base_url('departement/Plant_budget/form_edit?id=' . $pl->id_budget) ?>" class="badge badge-info text-white">
                                    <i class="fa fa-edit"></i>
                                </a>
                            <?php } ?>

                            <?php
                            if ($pl->approve_spv == 0 || $pl->approve_spv == 2) { ?>
                                <a onclick="return confirm('Yakin Hapus ?')" href="<?= base_url('departement/Plant_budget/delete?id_budget=' . $pl->id_budget) ?>" class="badge badge-danger text-white">
                                    <i class="fa fa-close"></i>
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
            <div class="modal-body approve_body">

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
    <div class="modal-dialog modal-xl" role="document">
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
        // Untuk sunting modal data edit zona
        $("#detailPlant").on("show.bs.modal", function(event) {
            var div = $(event.relatedTarget);
            // Tombol dimana modal di tampilkan
            var modal = $(this);
            var userid = div.data('id');
            var code = div.data('kode');
            // AJAX request
            $.ajax({
                url: "<?= base_url('departement/Plant_budget/viewDetailPlant') ?>",
                type: 'post',
                data: {
                    id: userid,
                },
                success: function(response) {
                    // console.log(response)
                    $('.data_detail').html(response);
                    // $('#detailPlant').modal('show');
                }
            });
        });

        $("#detailApprove").on("show.bs.modal", function(event) {
            var div = $(event.relatedTarget);
            // Tombol dimana modal di tampilkan
            var modal = $(this);
            var userid = div.data('id');
            var code = div.data('kode');
            // AJAX request
            $.ajax({
                url: "<?= base_url('departement/Plant_budget/viewDetailApprove') ?>",
                type: 'post',
                data: {
                    id: userid,
                },
                success: function(response) {
                    // Add response in Modal body
                    $('.approve_body').html(response);
                    // Display Modal
                    // $('#detailApprove').modal('show');
                }
            });
        });
    });
</script>