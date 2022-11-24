<table class="table-sm" style="width:100% ;border-collapse:collapse;border:1px solid #000">
    <thead>
        <tr>
            <th style="border-collapse:collapse;border:1px solid #000">Bulan</th>
            <th>Nilai</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data->result() as $d) : ?>
            <tr style="border-collapse:collapse;border:1px solid #000">
                <td style="border-collapse:collapse;border:1px solid #000"><?= $d->bulan ?></td>
                <td><?= 'Rp. ' . number_format($d->nilai_budget, 0, ",", ".") ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>