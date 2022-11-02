<div class="row">
    <div class="col-lg-12">
        <h3>Laporan Abnormality</h3>
        <div class="card">
            <div class="card-body">
                <form action="">
                    <div class="form-group">
                        <label for="">Plant</label>
                        <select class="form-control" name="plant" id="plant">
                            <?php foreach ($plant as $pl) : ?>
                                <option value="<?= $pl->id ?>"><?= $pl->nama_plant ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Tanggal Awal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal">
                    </div>
                    <div class="form-group">
                        <label for="">Tanggal Akhir</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal">
                    </div>
                    <button class="btn btn-primary btn-sm">submit</button>
                </form>
            </div>
        </div>
    </div>
</div>