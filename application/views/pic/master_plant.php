<div class="row">
    <div class="col-lg-12">
        <h3>Master Plant</h3>
        <?php if ($this->session->flashdata("ok")) { ?>
            <div class="alert alert-success">
                <p><?= $this->session->flashdata("ok") ?></p>
                <?php $this->session->unset_userdata('ok'); ?>
            </div>
        <?php } else if ($this->session->flashdata("nok")) { ?>
            <div class="alert alert-danger">
                <p><?= $this->session->flashdata("nok") ?></p>
                <?php $this->session->unset_userdata('nok'); ?>
            </div>
        <?php } ?>
        <div class="card">
            <div class="card-body">
                <button data-toggle="modal" data-target="#exampleModal" class="btn btn-success btn-sm mb-3 ">Tambah Data</button>
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Plant</th>
                            <th>Wilayah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($plant->result() as $pl) : ?>
                            <tr>
                                <td><?= $pl->nama_plant ?></td>
                                <td><?= $pl->wilayah ?></td>
                                <td>
                                    <a data-toggle="modal" data-target="#edit-data" class=" ml-2 text-primary" title="lihat data" data-backdrop="static" data-keyboard="false" data-id="<?= $pl->id ?>" data-plant="<?= $pl->nama_plant ?>" data-wilayah="<?= $pl->wilayah ?>">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a onclick="return confirm('Yakin hapus ?')" href="<?= base_url('PIC/Master/delete_plant?id_plant=' . $pl->id) ?>">
                                        <i class="fas fa-close"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!--  -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?= base_url('pic/Master/input_plant') ?>">
                    <div class="form-group">
                        <label for="">Plant</label>
                        <input type="text" class="form-control" name="plant" id="plant">
                    </div>
                    <div class="form-group">
                        <label for="">Wilayah</label>
                        <input type="text" class="form-control" id="wilayah" name="wilayah">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-sm btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn-sm btn btn-primary">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--  -->



<!--  modal edit -->
<div class="modal fade" id="edit-data" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?= base_url('pic/Master/edit_plant') ?>">
                    <div class="form-group">
                        <label for="">Plant</label>
                        <input type="hidden" class="form-control" name="id_plant" id="id_plant">
                        <input type="text" class="form-control" name="plant_2" id="plant_2">
                    </div>
                    <div class="form-group">

                        <label for="">Wilayah</label>
                        <input type="text" class="form-control" id="wilayah_2" name="wilayah_2">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-sm btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn-sm btn btn-primary">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--  -->


<script>
    $(document).ready(function() {
        $("#edit-data").on("show.bs.modal", function(event) {
            var div = $(event.relatedTarget); // Tombol dimana modal di tampilkan
            var modal = $(this);
            // Isi nilai pada field
            modal.find("#plant_2").attr("value", div.data("plant"));
            modal.find("#id_plant").attr("value", div.data("id"));
            modal.find("#wilayah_2").attr("value", div.data("wilayah"));
        });
    });
</script>