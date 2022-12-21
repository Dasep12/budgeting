<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.html">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        Master
                    </li>
                    <li class="breadcrumb-item active ">
                        Jenis Budget
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<a href="" data-toggle="modal" data-target="#add-data" data-backdrop="static" data-keyboard="false" class="btn btn-primary btn-sm mb-2"><i class="fa fa-plus"></i> Tambah Data</a>
<div class="card-box mb-30">
    <div class="pd-20">
        <!-- <h4 class="text-blue h4">Data Table Simple</h4> -->
    </div>
    <div class="pb-20">
        <table class="data-table table hover nowrap">
            <thead>
                <tr>
                    <th>Nik</th>
                    <th>Nama</th>
                    <th>Level</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($ttd->result() as $dpt) : ?>
                    <tr>
                        <td><?= $dpt->nik ?></td>
                        <td><?= strtoupper($dpt->nama_lengkap) ?></td>
                        <td><?= $dpt->level ?></td>
                        <td>
                            <a href="" class="btn btn-outline btn-sm btn-success">edit</a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<!-- modal edit -->
<div class="modal fade" id="add-data" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Data</h5>
            </div>
            <form method="post" enctype="multipart/form-data" action="<?= base_url('admin/Tertanda/input') ?>">
                <div class="modal-body">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">NAMA USER</label>
                            <select class="form-control" name="user" id="user">
                                <?php foreach ($akun->result() as $us) : ?>
                                    <option value="<?= $us->nik ?>"><?= strtoupper($us->nama_lengkap . ' - ' . $us->level) ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">FILE TTD</label>
                            <input type="file" name="lampiran" id="lampiran" class="form-control">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary btn-sm">Simpan</button>
                    <button type="button" class="btn btn-sm btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- edit  -->

<script>
    $("#edit-data").on("show.bs.modal", function(event) {
        var div = $(event.relatedTarget); // Tombol dimana modal di tampilkan
        var modal = $(this);
        // Isi nilai pada field
        modal.find("#acc_no").attr("value", div.data("acc_no"));
        modal.find("#acc_name").attr("value", div.data("acc_name"));
        document.getElementById("ket").value = div.data("ket");
    });
</script>