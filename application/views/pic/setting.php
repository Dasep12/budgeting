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
                <form method="post" action="<?= base_url('PIC/Setting/input') ?>">
                    <div class="form-group">
                        <label for="">Pilih Lokasi</label>
                        <select class="form-control js-example-basic-multiple" name="lokasi[]" multiple="multiple">
                            <?php foreach ($lokasi_data->result() as $lok) : ?>
                                <option value="<?= $lok->id  ?>"><?= $lok->nama_lokasi . ' - ' . $lok->nama_plant ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-danger">Save</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h5>Daftar Titik Patroli</h5>
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Plant</th>
                            <th>Lokasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($lokasi_patrol->result() as $lok) : ?>
                            <tr>
                                <td><?= $lok->nama_plant ?></td>
                                <td><?= $lok->nama_lokasi ?></td>
                                <td>
                                    <a onclick="return confirm('Yakin hapus ?')" href="<?= base_url('PIC/Master/delete_lokasi?id_lokasi=' . $lok->id_setting) ?>">
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



<script>
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    });
</script>