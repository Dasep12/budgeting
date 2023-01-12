<div class="row">
    <div class="col-lg-12">
        <table class="" style="width:100% ;">

            <tbody>
                <tr>
                    <td>Kode Budget</td>
                    <td>:</td>
                    <td><?= $detail->kode_budget ?></td>
                </tr>
                <tr>
                    <td>Tahun Budget</td>
                    <td>:</td>
                    <td><?= $detail->tahun ?></td>
                </tr>
                <tr>
                    <td>Departement</td>
                    <td>:</td>
                    <td><?= $detail->nama_departement ?></td>
                </tr>
                <tr>
                    <td>Jenis Budget</td>
                    <td>:</td>
                    <td><?= $detail->jenis_budget ?></td>
                </tr>
                <tr>
                    <td>Improvment</td>
                    <td>:</td>
                    <td><?= $detail->improvment ?></td>
                </tr>
                <tr>
                    <td>Pic</td>
                    <td>:</td>
                    <td><?= $detail->pic ?></td>
                </tr>
                <tr>
                    <td>Budget</td>
                    <td>:</td>
                    <td><?= 'Rp. ' . number_format($detail->budget, 0, ",", ".") ?></td>
                </tr>
                <tr>
                    <td>Activity</td>
                    <td>:</td>
                    <td><?= $detail->activity ?></td>
                </tr>
            </tbody>
        </table>
    </div>

</div>

<div class="card">
    <div class="table-responsive ">

        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <!-- <th>ACTIVITY</th> -->
                    <th>TAHUN</th>
                    <th>JANUARI</th>
                    <th>FEBRUARI</th>
                    <th>MARET</th>
                    <th>APRIL</th>
                    <th>MEI</th>
                    <th>JUNI</th>
                    <th>JULI</th>
                    <th>AGUSTUS</th>
                    <th>SEPTEMBER</th>
                    <th>OKTOBER</th>
                    <th>NOVEMBER</th>
                    <th>DESEMBER</th>
                    <th>TOTAL</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data->result() as $d) : ?>
                    <tr>
                        <!-- <td><?= $d->activity ?></td> -->
                        <td><?= $d->kode_budget ?></td>
                        <?php
                        $data = $this->model->ambilData("master_planning_budget", ['master_budget_id_budget' => $d->id_budget, 'kode_plant_activity' => $d->kode_plant_activity]);
                        $t = 0;
                        foreach ($data->result() as $da) {
                            echo "<td>Rp. " . number_format($da->nilai_budget, 0, ",", ".") . "</td>";
                            $t += $da->nilai_budget;
                        }
                        echo "<td>Rp. " . number_format($t, 0, ",", ".") . "</td>";
                        ?>

                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>