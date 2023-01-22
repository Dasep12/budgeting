<!DOCTYPE html>
<html>

<head>
    <style>
        .table tr,
        .table th,
        .table td {
            border: 1px solid #000;
            font-size: 8px;
        }

        .table2 {
            border: 1px solid #000;
        }

        .table2 tr {
            border: 1px solid #000;
        }

        .table {
            border-collapse: collapse;
        }


        .header {
            display: flex;
            flex-direction: row;
            position: relative;
            width: 100%;
        }

        .col-1 {
            margin-bottom: 10px;
            position: relative;
            background-color: red;
        }

        .col-2 {
            margin-bottom: 10px;
            position: relative;
            background-color: red;
        }

        .col6 {
            width: 30%;
            float: left;
        }

        .col12 {
            width: 100%;
            float: left;
            margin-bottom: 10px;
        }

        .tb-detail td,
        .tb-detail th {
            font-size: large;
        }
    </style>
    <title>Raimbusment</title>
</head>

<body>

    <div class="container">
        <div class="col12">
            <div class="col6">
                <table class="table2">
                    <tr>
                        <td style="width:32% ;">To</td>
                        <td>:</td>
                        <td><?= ucwords($remarks->to) ?></td>
                    <tr>
                    <tr>
                        <td>Bank</td>
                        <td>:</td>
                        <td> <?= strtoupper($remarks->bank) ?></td>
                    <tr>
                    <tr>
                        <td>Giro / Cheque / TT No</td>
                        <td>:</td>
                        <td><?= $remarks->rekening ?></td>
                    <tr>
                </table>
            </div>
            <div class="col6" style="width:35%;justify-content: center;margin-left:5px;align-items:center">
                <h4 style="text-align: center;">PT RAVALIA INTI MANDIRI<br><u>AP VOUCHER</u></h4>
            </div>
            <div class="col6">
                <table class="table2" style="width: 100%;">
                    <tr>
                        <td style="width:32% ;">Date</td>
                        <td>:</td>
                        <td><?= $remarks->tanggal ?></td>
                    <tr>
                    <tr>
                        <td>NO BK</td>
                        <td>:</td>
                        <td><?= strtoupper($remarks->bk) ?></td>
                    <tr>
                </table>
            </div>
        </div>


        <div class="detail">
            <table class="table tb-detail" style="width: 100%;">
                <thead>
                    <tr>
                        <th colspan="4">Debit</th>
                        <th rowspan="2" colspan="6">Particullars</th>
                    </tr>
                    <tr>
                        <th colspan="2">Ammount</th>
                        <th colspan="2">Acc No</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $total = 0;

                    foreach ($raim as $r) : ?>
                        <tr>
                            <td colspan="2"><?= 'Rp.' . number_format($r->ammount, 0, ",", ".")  ?></td>
                            <td colspan="2" style="width:40px;"></td>
                            <td colspan="6"><?= $r->particullar ?></td>
                        </tr>
                        <?php $total += $r->ammount; ?>
                    <?php endforeach ?>
                    <tr>
                        <td colspan="2"><?= 'Rp.' . number_format($total, 0, ",", ".")  ?></td>
                        <td colspan="2">Total</td>
                        <td colspan="6">Total</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td style="height: 40px;width:20px;"> TERBILANG</td>
                        <td align="center" colspan="9"><?= strtoupper(penyebut($total) . ' RUPIAH') ?></td>
                    </tr>
                    <tr>
                        <td colspan="10"></td>
                    </tr>
                    <tr>
                        <td colspan="3" rowspan="2">Remarks</td>
                        <td align="center" colspan="4">Approved</td>
                        <td align="center" rowspan="2">Checked 2</td>
                        <td align="center" rowspan="2">Checked 1</td>
                        <td align="center" rowspan="2">Prepared</td>
                    </tr>
                    <tr>
                        <td align="center">Director</td>
                        <td align="center">General Manager</td>
                        <td align="center">Finance </td>
                        <td align="center">Budget Controller</td>
                    </tr>
                    <tr>
                        <td rowspan="2" colspan="3"><?= ucwords($remarks->remarks) ?></td>
                        <td style="height:90px ;"></td>
                        <td><img height="90px" width="90px" src="./assets/ttd/<?= $gm->file  ?>" alt=""></td>
                        <td align="center"><img height="90px" width="90px" src="./assets/ttd/<?= $fin->file  ?>" alt=""></td>
                        <td><img height="90px" width="90px" src="./assets/ttd/<?= $acc->file  ?>" alt=""></td>
                        <td><img height="90px" width="90px" src="./assets/ttd/<?= $depthead2->file  ?>" alt=""></td>
                        <td><img height="90px" width="90px" src="./assets/ttd/<?= $depthead->file  ?>" alt=""></td>

                        <td><img height="90px" width="90px" src="./assets/ttd/<?= $pre->tertanda  ?>" alt=""></td>
                    </tr>
                    <tr>
                        <td style="height:20px ;"></td>
                        <td><?= ucwords($gm->nama_lengkap) ?></td>
                        <td><?= ucwords($fin->nama_lengkap) ?></td>
                        <td><?= ucwords($acc->nama_lengkap) ?></td>
                        <td><?= ucwords($depthead2->nama_lengkap) ?></td>
                        <td><?= ucwords($depthead->nama_lengkap) ?></td>
                        <td><?= ucwords($remarks->nama_lengkap) ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>

    </div>

</body>
<?php
function penyebut($nilai)
{
    $nilai = abs($nilai);
    $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($nilai < 12) {
        $temp = " " . $huruf[$nilai];
    } else if ($nilai < 20) {
        $temp = penyebut($nilai - 10) . " belas";
    } else if ($nilai < 100) {
        $temp = penyebut($nilai / 10) . " puluh" . penyebut($nilai % 10);
    } else if ($nilai < 200) {
        $temp = " seratus" . penyebut($nilai - 100);
    } else if ($nilai < 1000) {
        $temp = penyebut($nilai / 100) . " ratus" . penyebut($nilai % 100);
    } else if ($nilai < 2000) {
        $temp = " seribu" . penyebut($nilai - 1000);
    } else if ($nilai < 1000000) {
        $temp = penyebut($nilai / 1000) . " ribu" . penyebut($nilai % 1000);
    } else if ($nilai < 1000000000) {
        $temp = penyebut($nilai / 1000000) . " juta" . penyebut($nilai % 1000000);
    } else if ($nilai < 1000000000000) {
        $temp = penyebut($nilai / 1000000000) . " milyar" . penyebut(fmod($nilai, 1000000000));
    } else if ($nilai < 1000000000000000) {
        $temp = penyebut($nilai / 1000000000000) . " trilyun" . penyebut(fmod($nilai, 1000000000000));
    }
    return $temp;
}

?>

</html>