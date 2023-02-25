<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panjar</title>
    <style>
        .card {
            background-color: #FFF;
            height: auto;
            width: auto;
            border: 2px solid black;
        }

        .card h2 {
            text-align: center;
        }

        .card .date {
            display: flex;
            justify-content: flex-start;
        }

        .date div {
            width: auto;
            height: auto;
        }

        .tb tr,
        .tb td,
        .tb th {
            border: 1px solid #000;
            border-collapse: collapse;
        }

        .tb {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="card">
        <h2>PT RAVALIA INTI MANDIRI<br>FORM PANJAR</h2>

        <div class="date">
            <div style="background-color:#FFF;height:30px">
                <table style="margin-left: 180px;">
                    <tr>
                        <td>No</td>
                        <td>:</td>
                        <td><?= $remarks->bk ?></td>
                    </tr>
                    <tr>
                        <td>Tgl</td>
                        <td>:</td>
                        <td><?= $remarks->tanggal_request ?></td>
                    </tr>
                </table>
            </div>
            <div style="background-color:#FFF;border:2px solid #000">
                <table style="padding: 10px;">
                    <tr>
                        <td style="padding: 10px;">Keterangan</td>
                        <td>:</td>
                        <td><?= $remarks->remarks ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 10px;">Jumlah</td>
                        <td>:</td>
                        <td><?= 'Rp.' . number_format($total->total, 2, ",", ",") ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 10px;">Terbilang</td>
                        <td>:</td>
                        <td><?= ucwords(penyebut($total->total)) ?></td>
                    </tr>
                </table>
            </div>
            <div style="background-color:#FFF;margin-top:10px">
                <table class="tb" style="padding: 10px;border:1px solid #000;border-collapse:collapse;margin-left:170px;height:300px">
                    <tr>
                        <th>Finance</th>
                        <th>General Manager</th>
                        <th>Dept Head 1</th>
                        <th>Dept Head 2</th>
                        <th>Prepared</th>
                    </tr>
                    <tbody>
                        <tr>
                            <td>
                                <img height="60px" width="60px" src="./assets/ttd/<?= $fin_ttd->file ?>" alt="">
                            </td>
                            <td style="width: 90px;">
                                <img height="60px" width="60px" src="./assets/ttd/<?= $gm->file ?>" alt="">
                            </td>
                            <td>
                                <img height="60px" width="60px" src="./assets/ttd/<?= $depthead2->file ?>" alt="">
                            </td>
                            <td>
                                <img height="60px" width="60px" src="./assets/ttd/<?= $depthead->file ?>" alt="">
                            </td>
                            <td>
                                <img height="60px" width="60px" src="./assets/ttd/<?= $pre->tertanda ?>" alt="">
                            </td>
                        </tr>
                        <tr>
                            <td><?= ucwords($fin_ttd->nama_lengkap) ?></td>
                            <td><?= ucwords($gm->nama_lengkap) ?></td>
                            <td><?= ucwords($depthead2->nama_lengkap) ?></td>
                            <td><?= ucwords($depthead->nama_lengkap) ?></td>
                            <td><?= ucwords($pre->name) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div style="background-color:#FFF;font-size:10px">
                <label for="">Note :</label><br>
                <label for="">Lembar 1 : Untuk Finance</label><br>
                <label for="">Lembar 2 : Untuk Received & saat pertanggungjawaban mohon dilampirkan</label>
            </div>

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