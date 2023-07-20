<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">E-Budget</a>
                    </li>
                    <li class="breadcrumb-item active ">
                        Approved Plant
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

                        <button type="button" onclick="approveAll()" id="btn_approve_all" style="display:none ;" class="btn btn-success btn-sm mb-2 mr-2"> APPROVE DATA TERPILIH</button>
                        <button type="button" onclick="rejectAll()" id="btn_reject_all" style="display:none ;" class="btn btn-danger btn-sm mb-2 mr-2"> REJECT DATA TERPILIH</button>
                        <button type="button" onclick="deleteAll()" id="btn_delete_all" style="display:none ;" class="btn btn-danger btn-sm mb-2 mr-2"> DELETE DATA TERPILIH</button>
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
                                        <?php
                                        if ($df->approve_bc == 2  ||  $df->approve_bc == 1) { ?>
                                            <a data-kode="<?= $df->kode_budget ?>" data-id="<?= $df->id_budget ?>" class="userinfo badge badge-primary text-white" data-toggle="modal" data-target="#exampleModal">Detail</a>
                                        <?php } else if ($df->approve_mgr == 1 ||  $df->approve_bc == 0) { ?>

                                            <a data-kode="<?= $df->kode_budget ?>" data-id="<?= $df->id_budget ?>" class="userinfo badge badge-primary text-white" data-toggle="modal" data-target="#exampleModal">Detail</a>

                                            <a href="<?= base_url('budgetControl/Approved/approve?id_budget=' . $df->id_budget . '&kode=1') ?>" onclick="return confirm('Yakin approve ?')" class="badge badge-success">Approved</a>

                                            <a onclick="return confirm('Yakin delete ?')" href="<?= base_url('budgetControl/Approved/delete?id_budget=' . $df->id_budget) ?>" class="badge badge-danger">Delete</a>

                                            <a onclick="return confirm('Yakin reject ?')" href="<?= base_url('budgetControl/Approved/approve?id_budget=' . $df->id_budget . '&kode=2') ?>" class="badge badge-warning text-white">Reject</a>

                                            <a data-kode="<?= $df->kode_budget ?>" data-budget="<?= $df->budget ?>" data-id="<?= $df->id_budget ?>" class="editUser badge badge-info text-white" data-toggle="modal" data-target="#editData">edit</a>

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

    <div class="tab-pane fade show " id="profile" role="tabpanel" aria-labelledby="profile-tab">
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
                                    <a data-kode="<?= $df->kode_budget ?>" data-id="<?= $df->id_budget ?>" data-budget="<?= $df->budget ?>" class="userinfo badge badge-primary text-white" data-toggle="modal" data-target="#exampleModal">Detail</a>

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
                    <label for="">Bulan</label>
                    <select name="bulan" id="bulan" class="form-control">
                        <option value="">Pilih Bulan</option>
                        <option>Januari</option>
                        <option>Februari</option>
                        <option>Maret</option>
                        <option>April</option>
                        <option>Mei</option>
                        <option>Juni</option>
                        <option>Juli</option>
                        <option>Agustus</option>
                        <option>September</option>
                        <option>Oktober</option>
                        <option>November</option>
                        <option>Desember</option>
                    </select>
                    <div id="load_budget_nilai" style="display:none ;">
                        <span class="text-danger font-italic small">mengambil nilai budget . . .</span>
                    </div>
                    <label for="" id="bln">Nilai Budget </label>
                    <input type="hidden" name="id_planing" id="id_planing">
                    <input type="hidden" name="bulan_budget_real" id="bulan_budget_real">
                    <input required readonly class="form-control" type="text" name="budget_bulan" id="budget_bulan">

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
<div class="tab-pane fade show" id="profile" role="tabpanel" aria-labelledby="profile-tab">
</div>
</div>

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

        $('#exampleModal').on("show.bs.modal", function(event) {
            var div = $(event.relatedTarget);
            var userid = div.data('id');
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
                    // $('#empModal').modal('show');
                }
            });
        });


        $('#editData').on("show.bs.modal", function(event) {
            var div = $(event.relatedTarget);
            var id = div.data('id');
            var budget = div.data('budget');
            var kode = div.data('kode');
            console.log(budget)
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

        $('select[name=bulan').on('change', function() {
            var bulan = $("select[name=bulan] option:selected").text();
            var id = document.getElementById("id_budget_update").value;
            if (bulan == null || bulan == "") {
                alert("Pilih Kode Transaksi")
                $('#bulan').prop('selectedIndex', 0);
            } else {
                $.ajax({
                    url: "<?= base_url('budgetControl/Approved/getBudgetBulanan') ?>",
                    method: "GET",
                    data: "bulan=" + bulan + "&id_plant=" + id,
                    cache: false,
                    beforeSend: function() {
                        document.getElementById("load_budget_nilai").style.display = 'block';
                    },
                    complete: function() {
                        document.getElementById("load_budget_nilai").style.display = 'none';
                    },
                    success: function(e) {
                        if (e == 0 || e === '0') {
                            alert('tidak ada data');
                        } else {
                            const data = JSON.parse(e);
                            // console.log(data)
                            var budget = formatRupiah(data.nilai_budget, 'Rp. ');
                            document.getElementById("bln").innerHTML = "Nilai Budget " + bulan
                            document.getElementById("id_planing").value = data.id_planing;
                            document.getElementById("bulan_budget_real").value = data.nilai_budget;
                            document.getElementById("budget_bulan").value = budget;
                        }
                    }
                })
            }
        })

        $(".multi").click(function() {
            var panjang = $('[name="multi[]"]:checked').length;
            if (panjang > 0) {
                document.getElementById('btn_approve_all').style.display = "block";
                document.getElementById('btn_reject_all').style.display = "block";
                document.getElementById('btn_delete_all').style.display = "block";
            } else {
                document.getElementById('btn_approve_all').style.display = "none";
                document.getElementById('btn_reject_all').style.display = "none";
                document.getElementById('btn_delete_all').style.display = "none";
            }
        })

        $("#check-all").click(function() {
            if ($(this).is(":checked")) {
                $(".multi").prop("checked", true);
                document.getElementById('btn_delete_all').style.display = "block";
                document.getElementById('btn_delete_all').style.display = "block";
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
            $("#form").attr("action", "<?= base_url('budgetControl/Approved/multiReject') ?>");
            $("#form").submit();
        }
        console.log("cancel");
    }

    function approveAll() {
        if (confirm("Yakin Approve Budget ?") == true) {
            $("#form").attr("action", "<?= base_url('budgetControl/Approved/multiApprove') ?>");
            $("#form").submit();
        }
        console.log("cancel");
    }

    function deleteAll() {
        if (confirm("Yakin Delete Budget ?") == true) {
            $("#form").attr("action", "<?= base_url('budgetControl/Approved/multiDelete') ?>");
            $("#form").submit();
        }
        console.log("cancel");
    }
</script>