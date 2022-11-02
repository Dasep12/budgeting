<div class="row">
    <div class="col-lg-12">
        <h3>Master User</h3>
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
                            <th>Nama</th>
                            <th>Npk</th>
                            <th>Level</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($user as $u) : ?>
                            <tr>
                                <td><?= $u->nama_plant ?></td>
                                <td><?= $u->nama_user ?></td>
                                <td><?= $u->npk ?></td>
                                <td><?= $u->level ?></td>
                                <td>
                                    <a href="">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="">
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
                <form action="<?= base_url('PIC/Master/input_user') ?>" method="post">
                    <label for="">Plant</label>
                    <select class="form-control" name="plant" id="plant">
                        <?php foreach ($plant as $p) : ?>
                            <option value="<?= $p->id ?>"><?= $p->nama_plant ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label for="">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama">
                    <label for="">Npk</label>
                    <input type="text" class="form-control" id="npk" name="npk">
                    <label for="">Password</label>
                    <input type="text" class="form-control" id="password" name="password">
                    <label for="">Level</label>
                    <select class="form-control" name="level" id="level">
                        <option value="0">Security</option>
                        <option value="1">PIC</option>
                    </select>
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