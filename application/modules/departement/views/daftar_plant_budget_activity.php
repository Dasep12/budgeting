<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.html">Dashboard</a>
                    </li>
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
                    <th class="table-plus datatable-nosort">Kode Budget</th>
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
                        <td><?= $pl->kode_budget ?></td>
                        <td><?= $pl->nama_departement ?></td>
                        <td><?= $pl->tahun ?></td>
                        <td><?= 'Rp. ' . number_format($pl->budget, 0, ",", ".") ?></td>
                        <td><?= $pl->activity ?></td>
                        <td>
                            <button type="button" data-id="<?= $pl->id_budget ?>" class="userinfo btn btn-sm btn-primary" data-toggle="modal" data-target="#exampleModal">
                                <i class="fa fa-eye"></i>
                            </button>
                            <button type="button" data-id="<?= $pl->id_budget ?>" class="approve_modal btn btn-sm btn-success" data-toggle="modal" data-target="#detailApprove">
                                <i class="fa fa-file"></i>
                            </button>
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
            var code = $(this).data('kode');
            // AJAX request
            $.ajax({
                url: "<?= base_url('departement/Plant_budget/viewDetailPlant') ?>",
                type: 'post',
                data: {
                    id: userid,
                },
                success: function(response) {
                    // Add response in Modal body
                    $('.modal-body').html(response);
                    // Display Modal
                    $('#exampleModal').modal('show');
                }
            });
        });

        $('.approve_modal').click(function() {
            var userid = $(this).data('id');
            var code = $(this).data('kode');
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
                    $('#detailApprove').modal('show');
                }
            });
        });


    })
</script>