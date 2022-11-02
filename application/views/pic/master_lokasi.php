<div class="row">
    <div class="col-lg-12">
        <h3>Master Lokasi</h3>
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
                            <th>Lokasi</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($lokasi_data->result() as $lok) : ?>
                            <tr>
                                <td><?= $lok->nama_plant ?></td>
                                <td><?= $lok->nama_lokasi ?></td>
                                <td><?= $lok->latitude ?></td>
                                <td><?= $lok->longitude ?></td>
                                <td>
                                    <a data-toggle="modal" data-target="#edit-data" class=" ml-2 text-primary" title="lihat data" data-backdrop="static" data-keyboard="false" data-id="<?= $lok->id ?>" data-lokasi="<?= $lok->nama_lokasi ?>" data-latitude="<?= $lok->latitude ?>" data-longitude="<?= $lok->longitude ?>" data-plant="<?= $lok->nama_plant ?>">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a onclick="return confirm('Yakin hapus ?')" href="<?= base_url('PIC/Master/delete_lokasi?id_lokasi=' . $lok->id) ?>">
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
                <form method="post" action="<?= base_url('pic/Master/input_lokasi') ?>">
                    <div class="form-group">
                        <label for="">Plant</label>
                        <select class="form-control" name="plant" id="plant">
                            <?php foreach ($plant as $p) : ?>
                                <option value="<?= $p->id ?>"><?= $p->nama_plant ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Lokasi</label>
                        <input type="text" class="form-control" id="lokasi" name="lokasi">
                    </div>
                    <div class="form-group">
                        <label for="">Latitude</label>
                        <input type="text" class="form-control" id="latitude" name="latitude">
                    </div>
                    <div class="form-group">
                        <label for="">Longitude</label>
                        <input type="text" class="form-control" id="longitude" name="longitude">
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
                <form method="post" action="<?= base_url('PIC/Master/edit_lokasi') ?>">
                    <div class="form-group">
                        <label for="">Plant</label>
                        <input type="text" class="form-control" name="id_lokasi" id="id_lokasi">
                        <input type="text" class="form-control" name="plant_2" id="plant_2">
                    </div>
                    <div class="form-group">
                        <label for="">Lokasi</label>
                        <input type="text" class="form-control" id="lokasi_2" name="lokasi_2">
                    </div>
                    <div class="form-group">
                        <label for="">Latitude</label>
                        <input type="text" class="form-control" id="latitude_2" name="latitude_2">
                    </div>
                    <div class="form-group">
                        <label for="">Longitude</label>
                        <input type="text" class="form-control" id="longitude_2" name="longitude_2">
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
            modal.find("#id_lokasi").attr("value", div.data("id"));
            modal.find("#lokasi_2").attr("value", div.data("lokasi"));
            modal.find("#latitude_2").attr("value", div.data("latitude"));
            modal.find("#longitude_2").attr("value", div.data("longitude"));
        });
    });
</script>