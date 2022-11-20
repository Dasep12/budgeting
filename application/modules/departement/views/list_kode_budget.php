<?php foreach ($data_kode->result() as $d) : ?>
    <option value="<?= $d->kode_budget ?>"><?= $d->kode_budget ?></option>
<?php endforeach ?>