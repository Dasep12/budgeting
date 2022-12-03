<div class="row">
    <div class="col-lg-6">
        <table class="small" style="width:100% ;border-collapse:collapse;border:1px solid #000">

            <tbody>
                <tr style="border-collapse:collapse;border:1px solid #000">
                    <td>Kode Budget</td>
                    <td>:</td>
                    <td><?= $detail->kode_budget ?></td>
                </tr>
                <tr style="border-collapse:collapse;border:1px solid #000">
                    <td>Tahun Budget</td>
                    <td>:</td>
                    <td><?= $detail->tahun ?></td>
                </tr>
                <tr style="border-collapse:collapse;border:1px solid #000">
                    <td>Departement</td>
                    <td>:</td>
                    <td><?= $detail->nama_departement ?></td>
                </tr>
                <tr style="border-collapse:collapse;border:1px solid #000">
                    <td>Jenis Budget</td>
                    <td>:</td>
                    <td><?= $detail->jenis_budget ?></td>
                </tr>
                <tr style="border-collapse:collapse;border:1px solid #000">
                    <td>Improvment</td>
                    <td>:</td>
                    <td><?= $detail->improvment ?></td>
                </tr>
                <tr style="border-collapse:collapse;border:1px solid #000">
                    <td>Pic</td>
                    <td>:</td>
                    <td><?= $detail->pic ?></td>
                </tr>
                <tr style="border-collapse:collapse;border:1px solid #000">
                    <td>Budget</td>
                    <td>:</td>
                    <td><?= 'Rp. ' . number_format($detail->budget, 0, ",", ".") ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-lg-6">
        <table class="small" style="width:100% ;border-collapse:collapse;border:1px solid #000">
            <thead>
                <tr>
                    <th>Activity</th>
                    <th style="border-collapse:collapse;border:1px solid #000">Bulan</th>
                    <th>Nilai</th>
                </tr>
            </thead>
            <tbody>
                <?php $total = 0;
                foreach ($data->result() as $d) : ?>
                    <tr style="border-collapse:collapse;border:1px solid #000">
                        <td><?= $d->activity ?></td>
                        <td style="border-collapse:collapse;border:1px solid #000"><?= $d->bulan ?></td>
                        <td><?= 'Rp. ' . number_format($d->nilai_budget, 0, ",", ".") ?></td>
                        <?php $total += $d->nilai_budget; ?>
                    </tr>
                <?php endforeach ?>
            </tbody>
            <tfoot>
                <tr>
                    <td align="center" colspan="2">Total</td>
                    <td style="border-collapse:collapse;border:1px solid #000"><?= 'Rp. ' . number_format($total, 0, ",", ".") ?></td>
                </tr>
            </tfoot>
        </table>
    </div>

</div>