<!DOCTYPE html>
<html>

<head>
    <style>
        .table tr,
        .table th,
        .table td {
            border: 1px solid #000;
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
                        <td></td>
                    <tr>
                    <tr>
                        <td>Bank</td>
                        <td>:</td>
                        <td></td>
                    <tr>
                    <tr>
                        <td>Giro / Cheque / TT No</td>
                        <td>:</td>
                        <td></td>
                    <tr>
                </table>
            </div>
            <div class="col6" style="width:35%;justify-content: center;margin-left:5px;align-items:center">
                <h4 style="text-align: center;">PT RAVALIA INTI MANDIRI<br><u>PAYMENT VOUCHER</u></h4>
                <h6 style="text-align: center;">Date : 2022-10-11 </h6>
            </div>
            <div class="col6">
                <table class="table" style="width: 100%;">
                    <thead>
                        <tr>
                            <th colspan="2">Finance Division</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="height: 90px;border-bottom: none"></td>
                            <td style="border-bottom: none;"></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td style="border:none ;">Manager</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>


        <div class="detail">
            <table class="table" style="width: 100%;">
                <thead>
                    <tr>
                        <th colspan="2">Debit</th>
                        <th rowspan="2">Particullars</th>
                        <th colspan="2">Credit</th>
                    </tr>
                    <tr>
                        <th>Ammount</th>
                        <th>Acc No</th>
                        <th>Acc</th>
                        <th>Ammount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $total = 0;
                    foreach ($raim as $r) : ?>
                        <tr>
                            <td><?= 'Rp.' . number_format($r->ammount, 0, ",", ".")  ?></td>
                            <td style="width:40px;"></td>
                            <td><?= $r->particullar ?></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <?php $total += $r->ammount; ?>
                    <?php endforeach ?>
                    <tr>
                        <td><?= 'Rp.' . number_format($total, 0, ",", ".")  ?></td>
                        <td>Total</td>
                        <td></td>
                        <td>Total</td>
                        <td></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td style="height: 40px;width:20px;"> TERBILANG</td>
                        <td align="center" colspan="4"><?= strtoupper(penyebut($total) . ' RUPIAH') ?></td>
                    </tr>
                    <tr>
                        <td colspan="5"></td>
                    </tr>
                    <tr>
                        <td colspan="2" rowspan="2">Remarks</td>
                        <td style="width:40px;">Section</td>
                        <td style="width:40px;">Dept.Manager</td>
                        <td style="width:40px;">Director</td>
                    </tr>
                    <tr>
                        <td align="center" style="height:70px;">
                            <img height="90px" width="90px" src="./assets/ttd/tanda.png" alt=""><br>
                            Ahmad Febri Hartanto
                        </td>
                        <td></td>
                        <td></td>
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