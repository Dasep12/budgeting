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

<a href="" class="btn btn-primary btn-sm mb-2"><i class="fa fa-plus"></i> Tambah Data</a>
<div class="card-box mb-30">
    <div class="pd-20">
        <!-- <h4 class="text-blue h4">Data Table Simple</h4> -->
    </div>
    <div class="pb-20">
        <table class="data-table table hover nowrap">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Acc No</th>
                    <th>Acc Name</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($data->result() as $dpt) : ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $dpt->acc_no ?></td>
                        <td><?= strtoupper($dpt->acc_name)  ?></td>
                        <td><?= strtoupper($dpt->ket)  ?></td>
                        <td>
                            <a href="#" class="badge badge-info"><i class="fa fa-edit"></i></a>

                            <a href="#" data-toggle="modal" data-target="#edit-data" data-backdrop="static" data-keyboard="false" class="badge badge-success" data-acc_no="<?= strtoupper($dpt->acc_no) ?>" data-acc_name="<?= strtoupper($dpt->acc_name) ?>" data-ket="<?= strtoupper($dpt->ket) ?>"><i class="fa fa-eye"></i></a>

                            <a href="#" class="badge badge-danger"><i class="fa fa-close"></i></a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<!-- modal edit data plant -->
<div class="modal fade" id="edit-data" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Data</h5>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> -->
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="form-group">
                        <label for="">ACC NO</label>
                        <input type="text" readonly autocomplete="off" id="acc_no" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">ACC NAME</label>
                        <input type="text" readonly autocomplete="off" id="acc_name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">KETERANGAN</label>
                        <textarea readonly class="form-control" id="ket"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- edit data plant -->

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