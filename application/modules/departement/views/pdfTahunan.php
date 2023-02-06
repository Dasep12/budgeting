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
                <th rowspan="4"><img height="80px" width="150px" src="./assets/src/images/logoBenecom.jpg" alt=""></th>
                <th colspan="8">RENCANA ANGGARAN & KEGIATAN</th>
                <th rowspan="4">RKA RIMGROUP</th>
            </tr>
            <tr>
                <th colspan="8">PT RAVALIA INTI MANDIRI</th>
            </tr>
            <tr>
                <th colspan="8">IT</th>
            </tr>
            <tr>
                <th colspan="8">PERIODE 2023</th>
            </tr>
            <tr>
                <th>Perspective</th>
                <th>Kpi</th>
                <th>Target Kpi</th>
                <th>Improvement</th>
                <th>Due Date</th>
                <th>PIC</th>
                <th>Code</th>
                <th>Act Plan</th>
                <th>Act Name</th>
                <th>Act Budget</th>
            </tr>
        </thead>
        <tbody>
            <?php for ($i = 1; $i <= 5; $i++) { ?>
                <tr>
                    <td></td>
                    <td>KPI <?= $i ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            <?php } ?>
            <tr>
                <td align="center" colspan="11">SUB TOTAL</td>
            </tr>
            <tr>
                <td align="center" style="background-color: #ccc;" colspan="11"></td>
            </tr>
            <tr>
                <td align="center" colspan="11">Regular & Project Cost</td>
            </tr>
            <tr class="header_2">
                <td>Jenis Project</td>
                <td colspan="5">Desc</td>
                <td>Code</td>
                <td>Act Plan</td>
                <td>Act Name</td>
                <td>Budget</td>
            </tr>
            <tr>
                <td>Regular & Project Cost</td>
                <td colspan="5">Pemeliharaan Komputer, Laptop, Printer, Server, Pabx & CCTV</td>
                <td>IT/REG01/01</td>
                <td>1. Pembersihan / Perawatan Personal Computer (Perkiraan Rp. 55.000 x 10 PC )</td>
                <td>Biaya Perawatan/Pemeliharaan Mesin & Peralatan</td>
                <td>2,200,000</td>
            </tr>
            <tr>
                <td align="center" colspan="9">SUB TOTAL</td>
                <td>120000</td>
            </tr>
            <tr>
                <td align="center" style="background-color: #ccc;" colspan="11"></td>
            </tr>
            <tr>
                <td align="center" colspan="11">Invesment</td>
            </tr>
            <tr class="header_2">
                <td>Jenis Project</td>
                <td colspan="5">Desc</td>
                <td>Code</td>
                <td>Act Plan</td>
                <td>Act Name</td>
                <td>Budget</td>
            </tr>
            <tr>
                <td align="center" colspan="9">SUB TOTAL</td>
                <td></td>
            </tr>
            <tr>
                <td align="center" style="font-size: 14px;" colspan="9">TOTAL BUDGET</td>
                <td style="font-size: 14px;">10000</td>
            </tr>
        </tbody>
    </table>

    <div class="tanggal" style="margin-left:50%;margin-top:40px">
        <label for="">Bekasi 18 , Januari 2023</label>
        <table class="tbl">
            <tr>
                <th colspan="2">Approved</th>
                <th colspan="2">Checked</th>
                <th colspan="2">Prepared</th>
            </tr>
            <tr>
                <td><img class="ttd_image" src="./assets/ttd/finance.png" alt=""></td>
                <td><img class="ttd_image" src="./assets/ttd/finance.png" alt=""></td>
                <td><img class="ttd_image" src="./assets/ttd/finance.png" alt=""></td>
                <td><img class="ttd_image" src="./assets/ttd/finance.png" alt=""></td>
                <td><img class="ttd_image" src="./assets/ttd/finance.png" alt="">
                </td>
                <td><img class="ttd_image" src="./assets/ttd/finance.png" alt="">
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