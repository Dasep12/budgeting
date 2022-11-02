<div class="row">
    <div class="col-md-5">
        <h5>Daftar Lokasi Patroli</h5>
    </div>

    <div class="container">
        <div class="flex-column">
            <?php foreach ($lokasi->result() as $lk) : ?>
                <div class="<?= $lk->status == 1  ? 'bg-success' : 'bg-danger' ?> p-2">
                    <span class="justify-content-end"><i class="text-white fas <?= $lk->status == 1  ? 'fa-check' : 'fa-close' ?>"></i></span>
                    <a href="<?= base_url('Patroli/scan_barcode?id_lokasi=' . $lk->id_lokasi . '&id_setting=' . $lk->id_setting) ?>" style="color:#FFF"><?= $lk->nama_lokasi ?></a>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</div>