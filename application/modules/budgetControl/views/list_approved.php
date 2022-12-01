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

        <table class="data-table table stripe hover nowrap table-bordered">
            <thead>
                <tr>
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
                        <td><?= $df->kode_budget ?></td>
                        <td><?= $df->nama_departement ?></td>
                        <td><?= $df->tahun ?></td>
                        <td><?= 'Rp. ' . number_format($df->budget, 0, ",", ".")  ?></td>
                        <td><?= $df->jenis_budget ?></td>

                        <td>
                            <?php
                            if ($df->approve_bc == 2  ||  $df->approve_bc == 1) { ?>
                                <a data-kode="<?= $df->kode_budget ?>" data-id="<?= $df->id_budget ?>" class="userinfo badge badge-primary text-white" data-toggle="modal" data-target="#exampleModal">Checked</a>


                            <?php } else if ($df->approve_mgr == 1 ||  $df->approve_bc == 0) { ?>


                                <a data-kode="<?= $df->kode_budget ?>" data-id="<?= $df->id_budget ?>" class="userinfo badge badge-primary text-white" data-toggle="modal" data-target="#exampleModal">Checked</a>

                                <a href="<?= base_url('budgetControl/Approved/approve?id_budget=' . $df->id_budget . '&kode=1') ?>" onclick="return confirm('Yakin approve ?')" class="badge badge-success">Approved</a>

                                <a onclick="return confirm('Yakin reject ?')" href="<?= base_url('budgetControl/Approved/approve?id_budget=' . $df->id_budget . '&kode=2') ?>" class="badge badge-danger">Reject</a>

                                <a data-kode="<?= $df->kode_budget ?>" data-budget="<?= $df->budget ?>" data-id="<?= $df->id_budget ?>" class="editUser badge badge-info text-white" data-toggle="modal" data-target="#editData">edit</a>

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
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail</h5>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> -->
            </div>
            <div class="modal-body editBudgetModal">
                sedang mengambil data
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--  -->

<!-- Modal -->
<div class="modal fade" id="editData" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail</h5>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> -->
            </div>
            <form action="<?= base_url('budgetControl/Approved/editBudget') ?>" method="post">
                <div class="modal-body">
                    <label for="">Budget</label>
                    <input type="hidden" name="id_budget_update" id="id_budget_update">
                    <input type="hidden" name="budget_awal_real" id="budget_awal_real">
                    <input readonly class="form-control" type="text" name="budget_awal" id="budget_awal">
                    <label for="">Input Perubahan Budget</label>
                    <input type="hidden" name="budget_baru_real" id="budget_baru_real">
                    <input required class="form-control" type="text" name="budget_baru" id="budget_baru">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
            </form>
        </div>
    </div>
</div>
</div>
<!--  -->

<script>
    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }
    $(function() {

        $('.userinfo').click(function() {
            var userid = $(this).data('id');
            // AJAX request
            $.ajax({
                url: "<?= base_url('budgetControl/Approved/viewDetailPlant') ?>",
                type: 'post',
                data: {
                    id: userid
                },
                beforeSend: function() {

                },
                complete: function() {

                },
                success: function(response) {
                    $('.editBudgetModal').html(response);
                    $('#empModal').modal('show');
                }
            });
        });


        $('.editUser').click(function() {
            var id = $(this).data('id');
            var budget = $(this).data('budget');
            document.getElementById('budget_awal').value = formatRupiah(budget.toString(), 'Rp. ');
            document.getElementById('budget_awal_real').value = budget;
            document.getElementById('id_budget_update').value = id;
        });


        var parsing = document.getElementById('budget_baru');
        parsing.addEventListener('keyup', function(e) {
            // tambahkan 'Rp.' pada saat form di ketik
            // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
            parsing.value = formatRupiah(this.value, 'Rp. ');
            const convert_1 = this.value.replace(/[^\w\s]/gi, '');
            const convert_2 = convert_1.replace('Rp', '');
            document.getElementById('budget_baru_real').value = convert_2;
        });
    })
</script>