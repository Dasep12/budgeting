<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF PLANT</title>
    <style>
        .tbl {
            border: 1px solid #000;
            border-collapse: collapse;
        }

        .tbl th,
        .tbl td,
        .tbl tr {
            border: 1px solid #000;
            border-collapse: collapse;
        }

        .header_2 td {
            text-align: center;
        }

        .ttd_image {
            height: 150px;
            width: 150px;
        }
    </style>
</head>

<body>
    <table class="tbl">
        <thead>
            <tr>
                <th rowspan="4"><img height="80px" width="150px" src="./assets/src/images/pim_logo.jpeg" alt=""></th>
                <th colspan="15">RENCANA PENARIKAN DANA BULANAN</th>
                <th rowspan="4">RPBB RIMGROUP</th>
            </tr>
            <tr>
                <th colspan="15">PT RAVALIA INTI MANDIRI</th>
            </tr>
            <tr>
                <th colspan="15"><?= $dept ?></th>
            </tr>
            <tr>
                <th colspan="15">PERIODE <?= $tahun ?></th>
            </tr>
            <tr>
                <th rowspan="2">Code</th>
                <th rowspan="2">Act Plan</th>
                <th rowspan="2">Jenis Project</th>
                <th rowspan="2">Acc Name</th>
                <th colspan="12">Bulan</th>
                <th rowspan="2">Total</th>

            </tr>
            <tr>
                <th>Jan</th>
                <th>Feb</th>
                <th>Mar</th>
                <th>Apr</th>
                <th>Mei</th>
                <th>Jun</th>
                <th>Jul</th>
                <th>Agu</th>
                <th>Sep</th>
                <th>Okt</th>
                <th>Nov</th>
                <th>Des</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($headers as $rl) { ?>
                <tr>
                    <td><?= $rl->code ?></td>
                    <td><?= $rl->description ?></td>
                    <td><?= $transaksi ?></td>
                    <td><?= $rl->acc_name ?></td>
                    <td>
                        <?php
                        $jan = $this->model->getReportDetail($rl->id, "Januari")->row();
                        echo number_format($jan->nilai_budget, 0);
                        ?>
                    </td>
                    <td>
                        <?php
                        $feb = $this->model->getReportDetail($rl->id, "Februari")->row();
                        echo number_format($feb->nilai_budget, 0);
                        ?>
                    </td>
                    <td>
                        <?php
                        $mar = $this->model->getReportDetail($rl->id, "Maret")->row();
                        echo number_format($mar->nilai_budget, 0);
                        ?>
                    </td>
                    <td>
                        <?php
                        $apr = $this->model->getReportDetail($rl->id, "April")->row();
                        echo number_format($apr->nilai_budget, 0);
                        ?>
                    </td>
                    <td>
                        <?php
                        $mei = $this->model->getReportDetail($rl->id, "Mei")->row();
                        echo number_format($mei->nilai_budget, 0);
                        ?>
                    </td>
                    <td>
                        <?php
                        $jun = $this->model->getReportDetail($rl->id, "Juni")->row();
                        echo number_format($jun->nilai_budget, 0);
                        ?>
                    </td>
                    <td>
                        <?php
                        $jul = $this->model->getReportDetail($rl->id, "Juli")->row();
                        echo number_format($jul->nilai_budget, 0);
                        ?>
                    </td>
                    <td>
                        <?php
                        $agu = $this->model->getReportDetail($rl->id, "Agustus")->row();
                        echo number_format($agu->nilai_budget, 0);
                        ?>
                    </td>
                    <td>
                        <?php
                        $sep = $this->model->getReportDetail($rl->id, "September")->row();
                        echo number_format($sep->nilai_budget, 0);
                        ?>
                    </td>
                    <td>
                        <?php
                        $okt = $this->model->getReportDetail($rl->id, "Oktober")->row();
                        echo number_format($okt->nilai_budget, 0);
                        ?>
                    </td>
                    <td>
                        <?php
                        $nov = $this->model->getReportDetail($rl->id, "November")->row();
                        echo number_format($nov->nilai_budget, 0);
                        ?>
                    </td>
                    <td>
                        <?php
                        $des = $this->model->getReportDetail($rl->id, "Desember")->row();
                        echo number_format($des->nilai_budget, 0);
                        ?>
                    </td>
                    <td><?= number_format($rl->total, 0) ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <div class="tanggal" style="margin-top:40px">
        <label for=""><?= $date ?></label>
        <table class="tbl">
            <tr>
                <th colspan="2">Approved</th>
                <th colspan="2">Checked</th>
                <th colspan="2">Prepared</th>
            </tr>
            <tr>
                <td></td>
                <td><img class="ttd_image" src="./assets/ttd/<?= $gm->file ?>" alt=""></td>
                <td><img class="ttd_image" src="./assets/ttd/<?= $fin->file ?>" alt=""></td>
                <td><img class="ttd_image" src="./assets/ttd/<?= $acc->file ?>" alt=""></td>
                <td><img class="ttd_image" src="./assets/ttd/<?= $manager->file ?>" alt="">
                </td>
                <td><img class="ttd_image" src="./assets/ttd/<?= $fin->file ?>" alt="">
                </td>
            </tr>

            <tr>
                <td>Direksi</td>
                <td>General Manager</td>
                <td>Dept. Head Finance</td>
                <td>Budget Controller</td>
                <td>Dept. Head</td>
                <td>Dept. Admin</td>
            </tr>


        </table>
    </div>

    <table>

    </table>
</body>

</html>